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
        Schema::create('school_membership_summaries', function (Blueprint $table) {
            $table->id();
            $table->uuid('school_id')->nullable()->index();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade')->onUpdate('cascade');
            $table->uuid('membership_id')->nullable()->index();
            $table->foreign('membership_id')->references('id')->on('memberships')->onDelete('cascade')->onUpdate('cascade');
            $table->date('start_membership')->nullable();
            $table->date('end_membership')->nullable(false);
            $table->integer('majors_used')->nullable()->default(0)->comment('Number of majors used');
            $table->integer('classes_used')->nullable()->default(0)->comment('Number of classes used');
            $table->integer('students_used')->nullable()->default(0)->comment('Number of students used');
            $table->integer('partners_used')->nullable()->default(0)->comment('Number of partners used');
            $table->integer('mentors_used')->nullable()->default(0)->comment('Number of mentors used');
            $table->integer('programs_used')->nullable()->default(0)->comment('Number of programs used');
            $table->integer('activities_used')->nullable()->default(0)->comment('Number of activities used');
            $table->integer('storages_used')->nullable()->default(0)->comment('Number of storages used');
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->uuid('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_membership_summaries');
    }
};
