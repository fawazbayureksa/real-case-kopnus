<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_import_failures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upload_log_id')->constrained()->onDelete('cascade');
            $table->string('member_number')->nullable();
            $table->string('name')->nullable();
            $table->string('is_active')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_import_failures');
    }
};
