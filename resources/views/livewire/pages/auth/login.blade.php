<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">
        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model.defer="form.email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow" type="email" required autofocus />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model.defer="form.password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow" type="password" required />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center gap-2">
                <input wire:model="form.remember" type="checkbox" class="rounded border-gray-300 text-unmaris-blue shadow-sm focus:ring-unmaris-yellow">
                <span class="text-gray-700">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-unmaris-blue hover:underline">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="w-full bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            Masuk
        </button>

        <p class="text-center text-sm text-gray-500 mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-unmaris-blue font-semibold hover:underline">Daftar di sini</a>
        </p>
    </form>
</div>
