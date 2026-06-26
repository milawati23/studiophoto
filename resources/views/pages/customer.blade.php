<?php

use App\Models\Customer;
use Livewire\Component;

new class extends Component {
    public $nama_pelangan = '';
    public $no_hp = '';
    public $alamat = '';

    // Ambil data pelanggan untuk tabel
    public function with()
    {
        return [
            'customers' => Customer::latest()->get(),
        ];
    }

    // Fungsi Simpan Pelanggan Baru
    public function save()
    {
        $this->validate([
            'nama_pelangan' => 'required|min:3',
            'no_hp' => 'required|numeric|min:10',
            'alamat' => 'required',
        ]);

        Customer::create([
            'nama_pelangan' => $this->nama_pelangan,
            'no_hp' => $this->no_hp,
            'alamat' => $this->alamat,
        ]);

        $this->reset(['nama_pelangan', 'no_hp', 'alamat']);
        session()->flash('message', 'Data pelanggan berhasil ditambahkan!');
    }

    // Fungsi Hapus Pelanggan
    public function delete($id)
    {
        Customer::find($id)->delete();
        session()->flash('message', 'Data pelanggan berhasil dihapus!');
    }
}; ?>

<div>
    <div class="p-6 max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Data Pelanggan</h1>
            <p class="text-sm text-gray-500">Kelola data pelanggan tetap atau pemesan studio foto</p>
        </div>

        @if (session()->has('message'))
            <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelangan</label>
                        <input type="text" wire:model="nama_pelangan" placeholder="Nama lengkap..." 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border">
                        @error('nama_pelangan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP / WhatsApp</label>
                        <input type="text" wire:model="no_hp" placeholder="Contoh: 08123456789" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border">
                        @error('no_hp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Rumah</label>
                    <input type="text" wire:model="alamat" placeholder="Alamat lengkap pelanggan..." 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border">
                    @error('alamat') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-lg transition shadow-sm">
                        Simpan Pelanggan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Nama Pelanggan</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">No. HP</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Alamat</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-sm text-gray-800 font-medium">{{ $customer->nama_pelangan }}</td>
                            <td class="p-4 text-sm text-gray-600">{{ $customer->no_hp }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $customer->alamat }}</td>
                            <td class="p-4 text-sm text-center">
                                <button wire:click="delete({{ $customer->id }})" wire:confirm="Hapus data pelanggan ini?"
                                    class="text-red-600 hover:text-red-900 font-medium bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-sm text-center text-gray-400">Belum ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>