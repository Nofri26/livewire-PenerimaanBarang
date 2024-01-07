<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserLogin extends Component
{
    public $name;
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.user-login');
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();
            session([
                'id' => $user->id,
                'name' => $user->name
            ]);
            session()->flash('success', 'Login Berhasil');
            return redirect()->intended('/penerimaan-barang');
        } else {
            session()->flash('error', 'Login Gagal. Email atau password salah.');
            $this->password = null;
        }
    }
}
