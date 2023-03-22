<x-filament-breezy::auth-card action="register">
    <!-- <div class="w-full flex justify-center">
        <x-filament::brand />
    </div> -->
    <img src="{{url('/images/banner-black.png')}}" alt="Image" style="height:60px; margin-left:27%;"/>

    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament-breezy::default.registration.heading') }}
        </h2>
        <p class="mt-2 text-sm text-center">
            {{ __('filament-breezy::default.or') }}
            <a class="text-primary-600" href="{{route('filament.auth.login')}}">
                {{ strtolower(__('filament::login.heading')) }}
            </a>
        </p>
    </div>
    <form wire:submit.prevent="register" class="space-y-4 md:space-y-6">
        {{ $this->form }}
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-32 rounded"> Register</button>
    </form>
</x-filament-breezy::auth-card>
