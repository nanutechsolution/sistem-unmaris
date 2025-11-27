<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinanceComponent;
use App\Models\FinanceRate;
use App\Models\ProgramStudi;
use Illuminate\Support\Str;

class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Master Komponen Biaya
        $spp = FinanceComponent::firstOrCreate(
            ['nama' => 'SPP (Sumbangan Pembinaan Pendidikan)'],
            ['tipe' => 'Per Semester', 'is_wajib' => true]
        );
        
        $spi = FinanceComponent::firstOrCreate(
            ['nama' => 'SPI (Sumbangan Pengembangan Institusi)'],
            ['tipe' => 'Sekali Bayar', 'is_wajib' => true]
        );

        $almet = FinanceComponent::firstOrCreate(
            ['nama' => 'Jas Almamater & KTM'],
            ['tipe' => 'Sekali Bayar', 'is_wajib' => true]
        );

        $kkn = FinanceComponent::firstOrCreate(
            ['nama' => 'Biaya KKN/Magang'],
            ['tipe' => 'Sekali Bayar', 'is_wajib' => true]
        );

        $wisuda = FinanceComponent::firstOrCreate(
            ['nama' => 'Biaya Wisuda'],
            ['tipe' => 'Sekali Bayar', 'is_wajib' => true]
        );


        // 2. Set Tarif Dummy untuk Angkatan 2025
        $prodis = ProgramStudi::all();
        $angkatan = '2025';

        foreach ($prodis as $prodi) {
            // Logic Harga: Teknik/Kesehatan lebih mahal
            $isMahal = Str::contains($prodi->nama_prodi, ['Teknik', 'Kesehatan', 'Farmasi']);
            
            // TARIF SPP
            FinanceRate::create([
                'finance_component_id' => $spp->id,
                'program_studi_id' => $prodi->id,
                'angkatan' => $angkatan,
                'nominal' => $isMahal ? 4500000 : 3000000, // Teknik 4.5jt, Lainnya 3jt
            ]);

            // TARIF SPI (Uang Gedung)
            FinanceRate::create([
                'finance_component_id' => $spi->id,
                'program_studi_id' => $prodi->id,
                'angkatan' => $angkatan,
                'nominal' => $isMahal ? 7500000 : 5000000,
            ]);

            // TARIF ALMAMATER (Sama Semua Prodi)
            FinanceRate::create([
                'finance_component_id' => $almet->id,
                'program_studi_id' => $prodi->id,
                'angkatan' => $angkatan,
                'nominal' => 850000,
            ]);
            
            // TARIF KKN (Sama Semua Prodi - Tapi nanti di semester akhir)
            FinanceRate::create([
                'finance_component_id' => $kkn->id,
                'program_studi_id' => $prodi->id,
                'angkatan' => $angkatan,
                'nominal' => 1500000,
            ]);
        }
    }
}