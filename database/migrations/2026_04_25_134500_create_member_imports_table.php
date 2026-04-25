<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_imports', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->integer('total_data')->default(0);
            $table->integer('total_success')->default(0);
            $table->integer('total_failed')->default(0);
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->string('error_file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_imports');
    }
};
