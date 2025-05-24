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
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Langsung ubah tipe kolom tokenable_id menjadi string (varchar(36) untuk UUID)
            $table->string('tokenable_id', 36)->change();

            // Tambahkan indeks jika diperlukan (opsional)
            $table->index(['tokenable_id', 'tokenable_type'], 'personal_access_tokens_tokenable_id_tokenable_type_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Hapus indeks jika ada
            if (Schema::hasIndex('personal_access_tokens', 'personal_access_tokens_tokenable_id_tokenable_type_index')) {
                $table->dropIndex('personal_access_tokens_tokenable_id_tokenable_type_index');
            }
            // Kembalikan ke tipe asli (bigint)
            $table->unsignedBigInteger('tokenable_id')->change();
        });
    }
};
