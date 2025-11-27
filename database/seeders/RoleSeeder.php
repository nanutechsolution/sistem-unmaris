<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Buat Permissions (Hak Akses Spesifik)
        // Permission untuk Akademik (BAAK)
        Permission::create(['name' => 'manage_academic']); // Mengelola data akademik
        Permission::create(['name' => 'manage_users']);    // Mengelola user (mhs/dosen)
        
        // Permission untuk LPM
        Permission::create(['name' => 'manage_lpm']);      // Mengelola akreditasi/dokumen mutu

        // Permission untuk Website (CMS)
        Permission::create(['name' => 'manage_content']);  // Berita, Halaman
        Permission::create(['name' => 'manage_sliders']);  // Slider Depan (PENTING UTK DEMO)

        // 3. Buat Roles & Assign Permissions
        
        // ROLE: SUPER ADMIN (IT)
        // Biasanya Super Admin diberi akses ke semua permission
        $roleSuperAdmin = Role::create(['name' => 'super_admin']);
        $roleSuperAdmin->givePermissionTo(Permission::all());

        // ROLE: BAAK (Biro Administrasi Akademik)
        $roleBaak = Role::create(['name' => 'baak']);
        $roleBaak->givePermissionTo([
            'manage_academic', 
            'manage_users', 
            'manage_content', // BAAK boleh tulis berita/pengumuman
            'manage_sliders'  // BAAK boleh ganti slider
        ]);

        // ROLE: LPM (Lembaga Penjaminan Mutu)
        $roleLpm = Role::create(['name' => 'lpm']);
        $roleLpm->givePermissionTo([
            'manage_lpm', 
            'manage_content', // LPM boleh upload dokumen publik/berita mutu
            'manage_sliders'
        ]);

        // ROLE: DOSEN & MAHASISWA (Basic)
        $roleDosen = Role::create(['name' => 'dosen']);
        $roleMahasiswa = Role::create(['name' => 'mahasiswa']);


        // 4. Buat User Dummy (Untuk Login Demo)
        
        // User Super Admin
        $admin = User::updateOrCreate(['email' => 'admin@unmaris.ac.id'], [
            'name' => 'Super Admin IT',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($roleSuperAdmin);

        // User Kepala BAAK
        $baakUser = User::updateOrCreate(['email' => 'baak@unmaris.ac.id'], [
            'name' => 'Kepala BAAK',
            'password' => Hash::make('password'),
        ]);
        $baakUser->assignRole($roleBaak);

        // User Ketua LPM
        $lpmUser = User::updateOrCreate(['email' => 'lpm@unmaris.ac.id'], [
            'name' => 'Ketua LPM',
            'password' => Hash::make('password'),
        ]);
        $lpmUser->assignRole($roleLpm);

        // User Dosen Contoh
        $dosenUser = User::updateOrCreate(['email' => 'dosen@unmaris.ac.id'], [
            'name' => 'Budi Santoso, M.Kom',
            'password' => Hash::make('password'),
        ]);
        $dosenUser->assignRole($roleDosen);
        
        // User Mahasiswa Contoh
        $mhsUser = User::updateOrCreate(['email' => 'mahasiswa@unmaris.ac.id'], [
            'name' => 'Agus Mahasiswa',
            'password' => Hash::make('password'),
        ]);
        $mhsUser->assignRole($roleMahasiswa);
    }
}