<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('mahasiswas', function (Blueprint $table) {
        $table->foreignId('kurikulum_id')
              ->nullable() // Nullable dulu untuk data lama
              ->after('program_studi_id')
              ->constrained('kurikulums')
              ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('mahasiswas', function (Blueprint $table) {
        $table->dropForeign(['kurikulum_id']);
        $table->dropColumn('kurikulum_id');
    });
}
};
