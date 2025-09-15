<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Personas\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DebugUser extends Command
{
    protected $signature = 'debug:user';
    protected $description = 'Debug user authentication';

    public function handle()
    {
        $email = 'maria.garcia@escuela.edu.ar';
        $password = '123456';

        // Buscar usuario por mail
        $user = Persona::where('mail', $email)->first();

        if (!$user) {
            $this->error('Usuario no encontrado');
            return;
        }

        $this->info('Usuario encontrado:');
        $this->info('ID: ' . $user->id);
        $this->info('Mail: ' . $user->mail);
        $this->info('Nombre: ' . $user->nombre_completo);
        $this->info('Pass (primeros 20 chars): ' . substr($user->pass, 0, 20) . '...');

        // Verificar password manualmente
        $passCheck = Hash::check($password, $user->pass);
        $this->info('Password check manual: ' . ($passCheck ? 'OK' : 'FAIL'));

        // Probar Auth::attempt con diferentes combinaciones
        $this->info('--- Probando diferentes combinaciones ---');

        $attempt1 = Auth::attempt(['mail' => $email, 'pass' => $password]);
        $this->info('Auth::attempt [mail, pass]: ' . ($attempt1 ? 'OK' : 'FAIL'));

        $attempt2 = Auth::attempt(['mail' => $email, 'password' => $password]);
        $this->info('Auth::attempt [mail, password]: ' . ($attempt2 ? 'OK' : 'FAIL'));

        if ($attempt2) {
            $this->info('Usuario autenticado después del attempt: ' . (Auth::check() ? 'SÍ' : 'NO'));
            if (Auth::check()) {
                $authUser = Auth::user();
                $this->info('Usuario autenticado ID: ' . $authUser->id);
                $this->info('Usuario autenticado Nombre: ' . $authUser->nombre_completo);
            }
        }

        // Verificar configuración del modelo
        $this->info('Auth identifier name: ' . $user->getAuthIdentifierName());
        $this->info('Auth password name: ' . $user->getAuthPasswordName());
        return 0;
    }
}
