<?php

use App\Models\Category;
use App\Models\Service;
use Livewire\Component;

new class extends Component {
    public $name = '';
    public $category_id = '';
    public $price = '';
    public $description = '';

    // Ambil data dari database untuk ditampilkan ke halaman
    public function with()
    {
        return [
            'services' => Service::latest()->get(),
            'categories' => Category::all(), // Mengambil semua kategori untuk pilihan dropdown
        ];
    }

    // Fungsi untuk Menyimpan Layanan/Paket Foto Baru
    public function save()
    {
        // Validasi input form
        $this->validate([
            'name' => 'required|min:3',
            'category_id' => 'required',
            'price' => 'required|numeric',
        ]);

        // Simpan data ke tabel services
        Service::create([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
        ]);

        // Reset form setelah berhasil simpan
        $this->reset(['name', 'category_id', 'price', 'description']);

        // Beri notifikasi sukses
        session()->flash('message', 'Layanan/Paket studio foto berhasil ditambahkan!');
    }

    // Fungsi untuk Menghapus Layanan
    public function delete($id)
    {
        Service::find($id)->delete();
        session()->flash('message', 'Layanan berhasil dihapus!');
    }
}; ?>

<div>
    <div class="p-6 max-w-5xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Layanan Studio Foto</h1>
            <p class="text-sm text-gray-500">Kelola paket dan jasa foto yang ditawarkan (Contoh: Paket Wisuda Premium, Prewedding Outdoor)</p>
        </div>

        @if (session()->has('message'))
            <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Form Tambah Paket / Layanan</h2>
            
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Paket/Layanan</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Paket Wisuda Single" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border">
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Induk</label>
                        <select wire:model="category_id" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rupiah)</label>
                        <input type="number" wire:model="price" placeholder="Contoh: 350000" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border">
                        @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi / Fasilitas Paket</label>
                        <input type="text" wire:model="description" placeholder="Contoh: 3x Cetak, 15 Menit Foto, All Files" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border">
                        @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-lg transition shadow-sm">
                        Simpan Layanan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <h2 class="text-lg font-semibold text-gray-700 p-4 border-b border-gray-100">Daftar Paket Studio</h2>
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Nama Paket</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Kategori</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Harga</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Fasilitas</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($services as $service)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-sm text-gray-800 font-medium">{{ $service->name }}</td>
                            <td class="p-4 text-sm text-gray-500">
                                <span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded text-xs font-semibold">
                                    {{ $service->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-800 font-semibold">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-sm text-gray-500 italic">{{ $service->description ?? '-' }}</td>
                            <td class="p-4 text-sm text-center">
                                <button wire:click="delete({{ $service->id }})" 
                                    wire:confirm="Yakin ingin menghapus layanan paket ini?"
                                    class="text-red-600 hover:text-red-900 font-medium bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-sm text-center text-gray-400">Belum ada paket layanan. Silakan tambah lewat form di atas!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>