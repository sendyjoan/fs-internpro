<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan kolom UUID sementara
        Schema::table('model_has_roles', function ($table) {
            $table->uuid('model_id_uuid')->nullable();
        });

        Schema::table('model_has_permissions', function ($table) {
            $table->uuid('model_id_uuid')->nullable();
        });

        // 2. Isi nilai UUID dari bigint (gunakan md5 hashing sebagai dummy UUID)
        DB::statement("UPDATE model_has_roles SET model_id_uuid = md5(model_id::text || 'salt_roles')::uuid");
        DB::statement("UPDATE model_has_permissions SET model_id_uuid = md5(model_id::text || 'salt_permissions')::uuid");

        // 3. Hapus kolom lama
        Schema::table('model_has_roles', function ($table) {
            $table->dropColumn('model_id');
        });

        Schema::table('model_has_permissions', function ($table) {
            $table->dropColumn('model_id');
        });

        // 4. Rename kolom baru jadi 'model_id'
        Schema::table('model_has_roles', function ($table) {
            $table->renameColumn('model_id_uuid', 'model_id');
        });

        Schema::table('model_has_permissions', function ($table) {
            $table->renameColumn('model_id_uuid', 'model_id');
        });
    }

    public function down(): void
    {
        // Balikin jadi bigint, contoh reversenya
        Schema::table('model_has_roles', function ($table) {
            $table->unsignedBigInteger('model_id_bigint')->nullable();
        });

        Schema::table('model_has_permissions', function ($table) {
            $table->unsignedBigInteger('model_id_bigint')->nullable();
        });

        // NOTE: Tidak bisa mengembalikan UUID ke bigint secara akurat kecuali kamu simpan mapping aslinya

        Schema::table('model_has_roles', function ($table) {
            $table->dropColumn('model_id');
            $table->renameColumn('model_id_bigint', 'model_id');
        });

        Schema::table('model_has_permissions', function ($table) {
            $table->dropColumn('model_id');
            $table->renameColumn('model_id_bigint', 'model_id');
        });
    }
};
