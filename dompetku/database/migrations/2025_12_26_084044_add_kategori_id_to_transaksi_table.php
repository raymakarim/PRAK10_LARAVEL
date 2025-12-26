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
        // Pastikan nama tabelnya 'transaksis' (pakai s)
        Schema::table('transaksis', function (Blueprint $table) {
            // Menambahkan kolom kategori_id sebagai foreign key
            $table->foreignId('kategori_id')
                  ->nullable() 
                  ->after('id') 
                  ->constrained('kategoris') 
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Menghapus relasi foreign key dan kolomnya jika migration di-rollback
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};