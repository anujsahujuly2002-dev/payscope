<?php

namespace App\Livewire\Admin\AEPS;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AepsSystem extends Component
{

    public $currentForm = 'form1';

    public function showForm($form)
    {
        $this->currentForm = $form;
    }

    // public $banks = [];

    // public function mount()
    // {
    //     $this->fetchBankList();
    // }

    // public function fetchBankList()
    // {
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer YOUR_API_TOKEN',
    //         'Content-Type' => 'application/json',
    //     ])->get('https://api.instantpay.in/payments/payout/banks');

    //     if ($response->successful()) {
    //         Log::info('API Response: ', $response->json());
    //         $this->banks = $response->json()['data'];
    //     } else {
    //         // Handle error
    //         Log::error('API Error: ', $response->body());
    //         $this->banks = [];
    //     }
    //     if ($response->failed()) {
    //         Log::error('Failed to fetch bank list', [
    //             'status' => $response->status(),
    //             'body' => $response->body()
    //         ]);
    //         $this->banks = [];
    //         return;
    //     }


    // }

    public function render()
    {
        return view('livewire.admin.a-e-p-s.aeps-system');
    }
}
