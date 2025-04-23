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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('image_id')->nullable()->constrained('images')->onDelete('set null');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->integer('number_of_participant')->default(0);
            $table->string('title');
            $table->date('Execution_date')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['حملة رسمية', 'مبادرة']);
            $table->enum('status', ['نشطة', 'منجزة' , 'تصويت' , 'ملغية'])->default('تصويت');
            $table->enum('created_by', ['user', 'volunteer']);
            $table->string('stripe_account_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
