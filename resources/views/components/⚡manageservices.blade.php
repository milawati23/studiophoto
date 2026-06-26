<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\Service;
use App\Models\Category;

class ManageServices extends Component {
    public $nama_layanan, $kategori_id, $harga, $deskripsi;

    public function store() {
        $this->validate([
            'nama_layanan' => 'required',
            'kategori_id' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
        ]);

        Service::create([
            'nama_layanan' => $this->nama_layanan,
            'kategori_id' => $this->kategori_id,
            'harga' => $this->harga,
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Layanan sukses ditambahkan!');
        $this->reset();
    }

    public function delete($id) {
        Service::find($id)->delete();
        session()->flash('message', 'Layanan sukses dihapus!');
    }

    public function render() {
        return view('livewire.manage-services', [
            'services' => Service::all(),
            'categories' => Category::all()
        ]);
    }
}