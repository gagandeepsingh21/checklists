<x-filament-breezy::auth-card action="authenticate">

 <!-- <img x-show="mode === 'light'" src="{{url('/images/banner-black.png')}}" alt="Dark Logo" class="h-[60px]" style="display: none;"> -->
    <!-- <img src="{{url('/images/banner-black.png')}}" alt="Image" style="height:60px; margin-left:27%;"/> -->
    
    <div
    x-data="{ mode: 'light' }"
    x-on:dark-mode-toggled.window="mode = $event.detail"
>
    <span x-show="mode === 'light'">
    <!-- <img src="{{url('/images/banner-black.png')}}" alt="Image" style="height:60px; margin-left:27%;"/> -->

    </span>
 
    <span x-show="mode === 'dark'">
    <img src="{{url('/images/logo.png')}}" alt="Light Logo" class="h-[60px]" style="display: none!important;">

    </span>
</div>
    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>
    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament::login.heading') }}
        </h2>
        @if(config("filament-breezy.enable_registration"))
        <p class="mt-2 text-sm text-center">
            {{ __('filament-breezy::default.or') }}
            <a class="text-primary-600" href="{{route(config('filament-breezy.route_group_prefix').'register')}}">
                {{ strtolower(__('filament-breezy::default.registration.heading')) }}
            </a>
        </p>
        @endif
    </div>

    {{ $this->form }}

    <x-filament::button type="submit" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{route(config('filament-breezy.route_group_prefix').'password.request')}}">{{ __('filament-breezy::default.login.forgot_password_link') }}</a>
    </div>
</x-filament-breezy::auth-card>
