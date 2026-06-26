<?php

namespace App\Livewire;

use Livewire\Component;

class ManageServices extends Component
{
    public function render()
    {
        // Sekarang diarahkan ke folder livewire dengan nama file pakai tanda strip
        return view('livewire.manage-services')
            ->layout('layouts.app'); 
    }
}