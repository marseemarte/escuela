<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Iniciar Sesión')" :description="__('Ingrese su email y contraseña')" />

        <!-- Session Status -->
        @if (session('status'))
            <div class="text-center text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="text-center text-red-600">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.custom') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input name="email" :label="__('Email')" type="email" required autofocus autocomplete="email"
                placeholder="maria.garcia@escuela.edu.ar" :value="old('email')" />

            <!-- Password -->
            <div class="relative">
                <flux:input name="password" :label="__('Contraseña')" type="password" required
                    autocomplete="current-password" :placeholder="__('Contraseña')" viewable />
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Recordarme')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Iniciar Sesión') }}</flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <p>Credenciales de prueba:</p>
            <p><strong>Email:</strong> maria.garcia@escuela.edu.ar</p>
            <p><strong>Contraseña:</strong> 123456</p>
        </div>
    </div>
</x-layouts.auth>
