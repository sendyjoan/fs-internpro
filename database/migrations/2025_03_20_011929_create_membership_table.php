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
        Schema::create('memberships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->integer('price')->nullable(false);
            $table->integer('duration')->nullable(false)->comment('Duration in months');
            $table->integer('max_majors')->nullable(false)->default(0)->comment('Maximum number of majors allowed');
            $table->integer('max_classes')->nullable(false)->default(0)->comment('Maximum number of classes allowed');
            $table->integer('max_students')->nullable(false)->default(0)->comment('Maximum number of students allowed');
            $table->integer('max_partners')->nullable(false)->default(0)->comment('Maximum number of partners allowed');
            $table->integer('max_mentors')->nullable(false)->default(0)->comment('Maximum number of mentors allowed');
            $table->integer('max_programs')->nullable(false)->default(0)->comment('Maximum number of programs allowed');
            $table->integer('max_activities')->nullable(false)->default(0)->comment('Maximum number of activities allowed');
            $table->integer('max_storages')->nullable(false)->default(0)->comment('Maximum number of storages allowed');
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->uuid('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
