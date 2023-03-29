<nav class="font-sans flex text-center sm:flex-row sm:text-left sm:justify-between py-4 px-6 bg-white sm:items-baseline w-full">
    <div class="mb-2 sm:mb-0">
        <a href="{{ route('home') }}">
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">MyEasyList</span>
        </a>
    </div>
    @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'home')
        @include('Navbar.navbarButtons')
    @endif
</nav>
