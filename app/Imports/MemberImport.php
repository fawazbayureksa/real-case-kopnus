<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\MemberImport as MemberImportModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Illuminate\Support\Facades\DB;

class MemberImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts, SkipsOnFailure, WithValidation, ShouldQueue, WithEvents
{
    use Importable;

    private $memberImportId;

    public function __construct($memberImportId)
    {
        $this->memberImportId = $memberImportId;
    }

    public function model(array $row)
    {
        // Increment success count
        DB::table('member_imports')->where('id', $this->memberImportId)->increment('total_success');

        return new Member([
            'member_number' => $row['no_anggota'],
            'name'          => $row['name'],
            'is_active'     => filter_var($row['is_active'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function uniqueBy()
    {
        return 'member_number';
    }

    public function rules(): array
    {
        return [
            'no_anggota' => 'required',
            'name'       => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $row = $failure->values();
            DB::table('member_import_failures')->insert([
                'member_import_id' => $this->memberImportId,
                'member_number'    => $row['no_anggota'] ?? null,
                'name'             => $row['name'] ?? null,
                'is_active'        => $row['is_active'] ?? null,
                'note'             => implode('; ', $failure->errors()),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            DB::table('member_imports')->where('id', $this->memberImportId)->increment('total_failed');
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                DB::table('member_imports')->where('id', $this->memberImportId)->update([
                    'status' => 'completed',
                ]);
            },
            ImportFailed::class => function(ImportFailed $event) {
                DB::table('member_imports')->where('id', $this->memberImportId)->update([
                    'status' => 'failed',
                ]);
            },
        ];
    }
}
