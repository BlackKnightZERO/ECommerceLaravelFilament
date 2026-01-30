<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Reset Password Page')]
class ResetPasswordPage extends Component
{
    #[Validate('required')]
    public $token;

    #[Url]
    #[Validate('required|email')]
    public $email;

    #[Validate('required|min:6|confirmed')]
    public $password;

    #[Validate('required|min:6')]
    public $password_confirmation;

    public function mount($token) {
        $this->token = $token;
    }

    public function save() {

        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email, 
                'password' => $this->password, 
                'password_confirmation' => $this->password_confirmation, 
                'token' => $this->token
            ],
            function (User $user, string $password) {
                $password = $this->password;
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET ? redirect('/login') : session()->flash('error', 'Something went wrong');
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
