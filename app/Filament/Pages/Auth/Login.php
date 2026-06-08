<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Login extends Page
{
    protected static ?string $title = 'Iniciar Sesión';
    protected static string $layout = 'filament-panels::components.page';
    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        if (Auth::check()) {
            redirect()->intended(route('filament.admin.pages.dashboard'));
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->autocomplete('email')
                    ->autofocus(),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function authenticate(): void
    {
        $data = $this->form->getState();

        // Buscar el usuario por email
        $user = User::where('email', $data['email'])->first();

        // Verificar si el usuario existe y está activo
        if ($user && !$user->is_active) {
            throw ValidationException::withMessages([
                'data.email' => 'Esta cuenta ha sido desactivada. Contacta al administrador para más información.',
            ]);
        }

        // Intentar autenticar
        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            throw ValidationException::withMessages([
                'data.email' => 'Las credenciales no son válidas.',
            ]);
        }

        session()->regenerate();
    }
}

