<?php

namespace App\Livewire\System;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
#[Title('Manajemen Role & Hak Akses')]
class RoleManager extends Component
{
    use WithPagination;

    public $search = '';
    
    // Form Properties
    public $role_id;
    public $name;
    public $selectedPermissions = []; // Array ID permission yang dipilih

    // UI State
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    // Data Lists (Untuk Checkbox di Modal)
    public $allPermissions;

    public function mount()
    {
        // Ambil semua permission untuk ditampilkan di checkbox
        $this->allPermissions = Permission::orderBy('name')->get();
    }

    public function render()
    {
        $roles = Role::with('permissions')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.system.role-manager', [
            'roles' => $roles
        ]);
    }

    // --- CRUD ---

    public function create()
    {
        $this->reset(['role_id', 'name', 'selectedPermissions']);
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $role = Role::findOrFail($id);
        
        $this->role_id = $role->id;
        $this->name = $role->name;
        
        // Ambil permission yang sudah dimiliki role ini (pluck ID-nya saja)
        // Konversi ke array string agar checkbox wire:model terbaca
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('roles', 'name')->ignore($this->role_id)
            ],
            'selectedPermissions' => 'array'
        ]);

        // 1. Simpan/Update Role
        if ($this->isEditing) {
            $role = Role::findById($this->role_id);
            $role->update(['name' => $this->name]);
        } else {
            $role = Role::create(['name' => $this->name]);
        }

        // 2. Sync Permissions (Penting!)
        // Ini akan menghapus permission lama dan menggantinya dengan yang baru dipilih
        $role->syncPermissions($this->selectedPermissions);

        $this->showModal = false;
        session()->flash('success', 'Role & Hak Akses berhasil disimpan.');
    }

    // --- DELETE ---

    public function confirmDelete($id)
    {
        // Mencegah penghapusan Super Admin (Bahaya!)
        $role = Role::findById($id);
        if ($role->name === 'super_admin') {
            session()->flash('error', 'Role Super Admin tidak boleh dihapus!');
            return;
        }

        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Role::find($this->deletingId)->delete();
        $this->showDeleteModal = false;
        session()->flash('success', 'Role berhasil dihapus.');
    }
}