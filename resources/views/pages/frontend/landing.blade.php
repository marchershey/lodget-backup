<div x-data="{mobileMenu:false}" class="relative bg-white font-sans">

    {{-- Mobile menu --}}
    <div x-show="mobileMenu" x-cloak class="full-screen absolute inset-0 z-10 w-full overflow-hidden bg-white">
        <button x-on:click="mobileMenu = false" class="absolute top-0 right-0 m-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon h-7 w-7" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="flex h-full items-center justify-center">
            <div class="text-dark flex flex-col space-y-8 text-center text-4xl font-bold">
                <a href="#">Home</a>
                <a href="#">Properties</a>
                <a href="#">Contact us</a>
                <a href="#" class="text-primary">Guest Portal</a>
            </div>
        </div>
    </div>

    <header class="frontend-container flex items-center justify-between">

        {{-- Logo --}}
        <div class="flex-none">
            <span class="text-xl font-bold uppercase">Serrate Rentals</span>
        </div>

        {{-- Navigation --}}
        <div>
            <nav class="hide-mobile flex space-x-5 font-semibold">
                <a href="#">Home</a>
                <a href="#">Properties</a>
                <a href="#">Get in touch</a>
                <a href="#" class="button button-primary rounded-full px-8">Guest Portal</a>
            </nav>
            <div class="show-mobile">
                <button x-on:click="mobileMenu = true" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon h-7 w-7" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="4" y1="6" x2="20" y2="6"></line>
                        <line x1="4" y1="12" x2="20" y2="12"></line>
                        <line x1="4" y1="18" x2="20" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

    </header>


    <section class="frontend-container">
        <div class="relative h-96 rounded-3xl bg-cover bg-center shadow-xl" style="background-image: url(https://i.imgur.com/Cygaelg.jpeg)">

            {{-- Where are you going? --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="flex flex-col items-center justify-center space-y-10 px-5">

                    <h1 class="text-center text-4xl font-bold text-white">Let us host your next vacation</h1>

                    <div class="hover:bg-primary group flex cursor-pointer items-center justify-center space-x-3 rounded-full bg-white px-6 py-2 shadow-2xl transition hover:scale-110 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted h-7 w-7 group-hover:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="10" cy="10" r="7"></circle>
                            <line x1="21" y1="21" x2="15" y2="15"></line>
                        </svg>
                        <span class="text-lg md:font-medium">Where are you going?</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Properties --}}
    <section class="frontend-container mt-10 space-y-6" wire:init="loadProperties">
        <div class="">
            <h1 class="text-2xl font-bold">Check out some of our most popular properties</h1>
        </div>
        <div class="grid grid-cols-1 gap-10 md:grid-cols-3">
            @if ($properties)
                @foreach ($properties as $property)
                    <div class="flex flex-col space-y-3">
                        <div class="aspect-w-10 aspect-h-7 overflow-hidden rounded-3xl">
                            <img class="bg-cover bg-center" src="/storage/{{ $property->photos()->first()->path }}" alt="">
                        </div>
                        <div class="flex items-center justify-between">
                            <h1 class="text-2xl font-medium">{{ $property->name }}</h1>
                            <h3 class="text-lg">
                                ${{ number_format($property->rate, 2) }} <span class="text-muted">/ night</span>
                            </h3>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex animate-pulse flex-col space-y-3">
                    <div class="h-64 w-full rounded-3xl bg-gray-200"></div>
                    <div class="flex justify-between">
                        <div class="h-6 basis-1/2 rounded-3xl bg-gray-200"></div>
                        <div class="h-6 basis-1/4 rounded-3xl bg-gray-200"></div>
                    </div>
                </div>
            @endif
        </div>

    </section>

    {{-- ------------------------------------- --}}

    {{-- <section class="full-screen w-full bg-cover bg-bottom" style="background-image: url(https://i.imgur.com/c179D6p.jpg)"> --}}
    <section class="full-screen frontend-container relative hidden w-full bg-cover bg-bottom">
        <header class="fixed top-0 w-full">
            <div class="flex space-x-10">

                {{-- Logo & Nav --}}
                <div class="flex w-full items-center justify-between">

                    {{-- Logo --}}
                    <div class="flex-none">
                        <span class="text-xl font-bold uppercase">Serrate Rentals</span>
                    </div>

                    {{-- Navigation --}}
                    <nav class="hide-mobile show-desktop flex space-x-5 text-lg font-semibold">
                        <a href="#">Home</a>
                        <a href="#">Properties</a>
                        <a href="#">Get in touch</a>
                        <a href="#" class="button button-primary rounded-full px-8 text-lg">Guest Portal</a>
                    </nav>
                </div>

                {{-- Guest Portal / Mobile menu button --}}
                <div class="show-mobile mt-1 flex items-center">
                    <button x-on:click="mobileMenu = true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon h-8 w-8" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="4" y1="6" x2="20" y2="6"></line>
                            <line x1="4" y1="12" x2="20" y2="12"></line>
                            <line x1="4" y1="18" x2="20" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <div class="bg-primary h-full w-full">

        </div>

        {{-- Where are you going? --}}
        <div class="flex hidden h-full items-center justify-center pb-32">
            <div class="flex flex-col items-center space-y-5 bg-black/40 py-5 md:space-y-10">
                <h1 class="text-center text-5xl font-extrabold leading-tight tracking-wide text-white md:text-6xl md:font-bold">
                    Let us host your <span class="text-primary-lighter">next vacation</span>
                </h1>
                <div class="flex items-center justify-center space-x-3 rounded-full bg-white hover:bg-primary group hover:text-white px-8 py-3 md:w-[400px] cursor-pointer shadow-2xl hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted h-7 w-7 group-hover:text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="10" cy="10" r="7"></circle>
                        <line x1="21" y1="21" x2="15" y2="15"></line>
                    </svg>
                    <span class="text-xl md:font-medium">Where are you going?</span>
                </div>
            </div>
        </div>
    </section>


    <section class="hidden bg-white">
        <div class="frontend-container">
            <h1 class="text-primary text-center text-2xl font-bold">Check out some of our most popular properties</h1>

        </div>
    </section>
</div>
