<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Login Page')]
class LoginPage extends Component
{
    #[Validate('required|email|exists:App\Models\User,email')]
    public $email;

    #[Validate('required|min:6|max:255')]
    public $password;

    public function save() {
        $this->validate();
        if(!auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error', 'Invalid credentials');
            return;
        }
        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
