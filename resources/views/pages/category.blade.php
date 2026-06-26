<?php

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component {
    public $name = '';

    // Mengambil data kategori terbaru dari database untuk tabel
    public function with()
    {
        return [
            'categories' => Category::latest()->get(),
        ];
    }

    // Fungsi untuk Menyimpan Kategori Baru (Create)
    public function save()
    {
        // Validasi agar nama wajib diisi, minimal 3 huruf, dan tidak boleh kembar
        $this->validate([
            'name' => 'required|min:3|unique:categories,name',
        ]);

        // Simpan ke database
        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        // Reset form input setelah sukses
        $this->reset('name');

        // Beri pesan sukses
        session()->flash('message', 'Kategori studio foto berhasil ditambahkan!');
    }

    // Fungsi untuk Menghapus Kategori (Delete)
    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Kategori berhasil dihapus!');
    }
}; ?>

<div>
    <div class="p-6 max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Kategori Studio Foto</h1>
            <p class="text-sm text-gray-500">Kelola kategori paket foto (Contoh: Prewedding, Graduation, Family, Wedding)</p>
        </div>

        @if (session()->has('message'))
            <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <form wire:submit.prevent="save" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori Baru</label>
                    <input type="text" wire:model="name" placeholder="Contoh: Graduation, Prewedding..." 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-lg transition shadow-sm h-[42px]">
                    Tambah Kategori
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Nama Kategori</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Slug URL</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-sm text-gray-800 font-medium">{{ $category->name }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $category->slug }}</td>
                            <td class="p-4 text-sm text-center">
                                <button wire:click="delete({{ $category->id }})" 
                                    wire:confirm="Yakin ingin menghapus kategori ini?"
                                    class="text-red-600 hover:text-red-900 font-medium bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-8 text-sm text-center text-gray-400">Belum ada kategori. Silakan ketik nama kategori di atas!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>