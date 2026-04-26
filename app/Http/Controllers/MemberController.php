<?php

namespace App\Http\Controllers;

use App\Imports\MemberImport;
use App\Models\Member;
use App\Models\UploadLog as ModelsUploadLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        $recentUpload = ModelsUploadLog::latest()->first();
        return view('members.index', compact('members', 'recentUpload'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'member_number' => 'required|string|max:50|unique:member,member_number',
                'name' => 'required|string|max:200',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Member gagal ditambahkan.');
        }

        Member::create([
            'member_number' => $request->member_number,
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Member berhasil ditambahkan.');
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,xlsx,xls|max:51200', // 50MB
            ]);
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Member gagal ditambahkan.' . $e->getMessage());
        }

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('imports', $filename);


        $importSession = ModelsUploadLog::create([
            'filename' => $filename,
            'status' => 'processing',
        ]);


        Excel::queueImport(new MemberImport($importSession->id), $path);

        return redirect()->back()->with('success', 'Upload data sedang diproses.');
    }

    public function downloadErrors($id)
    {
        $importSession = ModelsUploadLog::findOrFail($id);
        $failures = DB::table('member_import_failures')->where('member_import_id', $id)->get();

        if ($failures->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data gagal untuk diunduh.');
        }

        $filename = 'errors_' . $importSession->filename . '.csv';
        $handle = fopen('php://output', 'w');

        // Header
        fputcsv($handle, ['no_anggota', 'name', 'is_active', 'note'], '|');

        foreach ($failures as $failure) {
            fputcsv($handle, [
                $failure->member_number,
                $failure->name,
                $failure->is_active,
                $failure->note
            ], '|');
        }

        return Response::stream(
            function () use ($handle) {
                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->back()->with('success', 'Member berhasil dihapus.');
    }
}

