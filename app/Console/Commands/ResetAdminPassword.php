<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password {email=alejandro@example.com} {password=password}';

    protected $description = 'Rehash admin password with Bcrypt algorithm';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("Usuario con email {$email} no encontrado.");
            return 1;
        }

        // Actualizar contraseña con Bcrypt (correcto)
        $user->update([
            'password' => Hash::make($password),
        ]);

        $this->info("✅ Contraseña rehashheada correctamente para {$email}");
        $this->info("Contraseña: {$password}");

        return 0;
    }
}
