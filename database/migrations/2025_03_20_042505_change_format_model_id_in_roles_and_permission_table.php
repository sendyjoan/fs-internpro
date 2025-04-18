<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            DB::statement('ALTER TABLE model_has_roles ALTER COLUMN model_id TYPE uuid USING model_id::uuid');
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            DB::statement('ALTER TABLE model_has_permissions ALTER COLUMN model_id TYPE uuid USING model_id::uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id')->change();
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id')->change();
        });
    }
};
