<div class="p-6">
    <x-slot:header>Pengaturan Website</x-slot:header>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row min-h-[500px]">
        
        {{-- SIDEBAR TABS --}}
        <div class="w-full md:w-64 bg-gray-50 border-r border-gray-200 p-4">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-2">Kategori</h4>
            <nav class="space-y-1">
                <button wire:click="$set('activeTab', 'general')" 
                    class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $activeTab === 'general' ? 'bg-unmaris-blue text-white shadow' : 'text-gray-600 hover:bg-white hover:text-unmaris-blue' }}">
                    <i class="fas fa-cogs w-6 text-center mr-2"></i> Umum
                </button>
                <button wire:click="$set('activeTab', 'contact')" 
                    class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $activeTab === 'contact' ? 'bg-unmaris-blue text-white shadow' : 'text-gray-600 hover:bg-white hover:text-unmaris-blue' }}">
                    <i class="fas fa-address-book w-6 text-center mr-2"></i> Kontak
                </button>
                <button wire:click="$set('activeTab', 'social_media')" 
                    class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $activeTab === 'social_media' ? 'bg-unmaris-blue text-white shadow' : 'text-gray-600 hover:bg-white hover:text-unmaris-blue' }}">
                    <i class="fab fa-instagram w-6 text-center mr-2"></i> Sosial Media
                </button>
            </nav>
        </div>

        {{-- CONTENT FORM --}}
        <div class="flex-1 p-8">
            <form wire:submit.prevent="save">
                
                @foreach($groupedSettings as $group => $items)
                    <div x-show="$wire.activeTab === '{{ $group }}'" class="space-y-6">
                        
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-6 capitalize">
                            Pengaturan {{ str_replace('_', ' ', $group) }}
                        </h3>

                        @foreach($items as $item)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                                <label class="block text-sm font-medium text-gray-700 md:pt-2">
                                    {{ $item->label }}
                                </label>
                                <div class="md:col-span-2">
                                    
                                    {{-- 1. TIPE TEXT / EMAIL / NUMBER --}}
                                    @if($item->type === 'text' || $item->type === 'email' || $item->type === 'number')
                                        <input type="{{ $item->type }}" 
                                               wire:model="inputs.{{ $item->key }}" 
                                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow sm:text-sm">
                                    
                                    {{-- 2. TIPE TEXTAREA (Termasuk Maps) --}}
                                    @elseif($item->type === 'textarea')
                                        <textarea wire:model="inputs.{{ $item->key }}" rows="4"
                                                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow sm:text-sm font-mono text-xs"
                                                  placeholder="Masukkan teks atau kode embed di sini..."></textarea>
                                        
                                        {{-- PREVIEW MAPS KHUSUS (Jika key mengandung kata 'map') --}}
                                        @if(str_contains($item->key, 'map'))
                                            <div class="mt-3 p-1 border rounded bg-gray-50">
                                                <span class="text-[10px] font-bold text-gray-400 uppercase mb-1 block px-1">Preview Peta</span>
                                                <div class="aspect-video w-full rounded overflow-hidden bg-gray-200 relative">
                                                    @if(!empty($inputs[$item->key]))
                                                        {!! $inputs[$item->key] !!}
                                                    @else
                                                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 text-xs italic p-4 text-center">
                                                            Paste kode <code>&lt;iframe&gt;</code> dari Google Maps di atas untuk melihat preview.
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    
                                    {{-- 3. TIPE IMAGE --}}
                                    @elseif($item->type === 'image')
                                        <div class="flex items-center gap-4">
                                            @if(isset($image_uploads[$item->key]))
                                                <img src="{{ $image_uploads[$item->key]->temporaryUrl() }}" class="h-20 w-20 object-contain border rounded bg-gray-100">
                                            @elseif($inputs[$item->key])
                                                <img src="{{ asset('storage/'.$inputs[$item->key]) }}" class="h-20 w-20 object-contain border rounded bg-gray-100">
                                            @else
                                                <div class="h-20 w-20 bg-gray-100 rounded border flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                            @endif
                                            
                                            <input type="file" wire:model="image_uploads.{{ $item->key }}" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach

                    </div>
                @endforeach

                <div class="mt-8 pt-6 border-t flex justify-end">
                    <button type="submit" class="bg-unmaris-blue text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 transition shadow-lg flex items-center">
                        <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                        <span wire:loading wire:target="save">
                            <i class="fas fa-spinner animate-spin mr-2"></i> Menyimpan...
                        </span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>