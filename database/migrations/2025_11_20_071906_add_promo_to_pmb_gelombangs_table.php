<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pmb_gelombangs', function (Blueprint $table) {
            // Kolom untuk menyimpan teks promo, misal: "Diskon 50% Uang Gedung"
            $table->string('promo')->nullable()->after('nama_gelombang');
        });
    }

    public function down(): void
    {
        Schema::table('pmb_gelombangs', function (Blueprint $table) {
            $table->dropColumn('promo');
        });
    }
};