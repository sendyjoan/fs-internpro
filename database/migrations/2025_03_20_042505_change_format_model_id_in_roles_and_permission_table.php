<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 🔁 Ubah tipe kolom model_id ke UUID dengan konversi manual
        DB::statement('ALTER TABLE model_has_roles ALTER COLUMN model_id TYPE uuid USING model_id::uuid');
        DB::statement('ALTER TABLE model_has_permissions ALTER COLUMN model_id TYPE uuid USING model_id::uuid');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ⏪ Kembalikan tipe kolom model_id ke unsignedBigInteger
        DB::statement('ALTER TABLE model_has_roles ALTER COLUMN model_id TYPE bigint USING model_id::bigint');
        DB::statement('ALTER TABLE model_has_permissions ALTER COLUMN model_id TYPE bigint USING model_id::bigint');
    }
};
