<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('complaint_category_id')->constrained('complaint_categories')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->string('region')->nullable(); // Add the 'region' column with nullable constraint
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('priority_points')->default(0);
            $table->enum('status', [
                'انتظار',        // submitted
                'تم التحقق',     // under_review
                'تم التعيين',     // assigned
                'يتم التنفيذ',   // in_progress
                'منجزة',        // resolved
                'مغلقة',        // closed
                'مرفوضة',       // rejected
            ])->default('انتظار');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
