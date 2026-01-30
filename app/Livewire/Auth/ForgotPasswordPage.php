<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Forgot Password Page')]
class ForgotPasswordPage extends Component
{
    #[Validate('required|email|exists:App\Models\User,email')]
    public $email;

    public function save() {
       $this->validate();
       
        $status = Password::sendResetLink(['email' => $this->email]);

        if($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Password reset link has been sent to your email address');
            $this->email = '';
        } else {
            session()->flash('error', 'Something went wrong');
        }
    }


    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }
}
