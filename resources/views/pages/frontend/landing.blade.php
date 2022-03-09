<div x-data="{mobileMenu:false}" class="relative font-sans">

    {{-- Mobile menu --}}
    <div x-show="mobileMenu" x-cloak class="full-screen absolute inset-0 z-10 w-full overflow-hidden bg-zinc-900">
        <button x-on:click="mobileMenu = false" class="absolute top-0 right-0 m-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon h-10 w-10 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="flex h-full items-center justify-center">
            <div class="text-dark flex flex-col space-y-8 text-center text-4xl font-bold dark:text-white">
                <a href="#">Home</a>
                <a href="#">Properties</a>
                <a href="#">Contact us</a>
                <a href="#">Guest Portal</a>
            </div>
        </div>
    </div>

    <section class="full-screen w-full bg-cover bg-bottom" style="background-image: url(https://i.imgur.com/Cygaelg.jpg)">
        <div class="fixed top-0 w-full">
            <header class="frontend-container flex space-x-10">

                {{-- Logo & Nav --}}
                <div class="flex w-full items-center justify-between">

                    {{-- Logo --}}
                    <div class="w-[150px] flex-none h-10 bg-white flex justify-center items-center">
                        <span class="text-2xl font-bold">LOGO</span>
                    </div>

                    {{-- Navigation --}}
                    <nav class="hide-mobile show-desktop flex space-x-5 text-lg font-semibold text-white">
                        <a href="#">Home</a>
                        <a href="#">Properties</a>
                        <a href="#">Get in touch</a>
                        <a href="#" class="button button-primary rounded-full px-8 text-lg">Guest Portal</a>
                    </nav>
                </div>

                {{-- Guest Portal / Mobile menu button --}}
                <div class="show-mobile mt-1 flex items-center">
                    <button x-on:click="mobileMenu = true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon h-10 w-10 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="4" y1="6" x2="20" y2="6"></line>
                            <line x1="4" y1="12" x2="20" y2="12"></line>
                            <line x1="4" y1="18" x2="20" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </header>
        </div>

        {{-- Where are you going? --}}
        <div class="flex h-full items-center justify-center pb-32">
            <div class="flex flex-col items-center space-y-5">
                <h1 class="text-center text-2xl font-bold text-white md:text-4xl">Let us host your next getaway</h1>
                <div class="flex items-center justify-center space-x-3 rounded-full bg-white px-8 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="10" cy="10" r="7"></circle>
                        <line x1="21" y1="21" x2="15" y2="15"></line>
                    </svg>
                    <span class="text-lg font-medium">Where are you going?</span>
                </div>
            </div>
        </div>
    </section>


    <nav class="frontend-container sticky top-0 flex w-full justify-between">

        {{-- Links --}}
        <div class="">
            {{-- Mobile menu button --}}
            <div class="md:hidden">
                <button x-on:click="mobileMenu = true" class="block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon h-10 w-10 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="4" y1="6" x2="20" y2="6"></line>
                        <line x1="4" y1="12" x2="20" y2="12"></line>
                        <line x1="4" y1="18" x2="20" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="mt-2 hidden text-lg font-medium tracking-wide text-white md:flex md:space-x-10">
                <a href="#" class="">Home</a>

            </div>
            {{-- Desktop Menu --}}
        </div>
    </nav>

    {{-- Where are you going? --}}
    <section class="flex h-full items-center justify-center pb-32">
        <div class="flex flex-col items-center space-y-5">
            <h1 class="text-center text-2xl font-bold text-white">Let us host your next getaway</h1>
            <div class="flex items-center justify-center space-x-3 rounded-full bg-white px-8 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="10" cy="10" r="7"></circle>
                    <line x1="21" y1="21" x2="15" y2="15"></line>
                </svg>
                <span class="text-xl font-medium">Where are you going?</span>
            </div>
        </div>
    </section>
    </header>

    <section x-show="!mobileMenu" class="full-screen relative hidden w-full bg-cover bg-center" style="background-image: url(https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80)">

        {{-- Dark overlay --}}
        <div class="absolute inset-0 z-0 bg-black/60"></div>


        {{-- Navbar --}}
        <header class="sticky top-0 w-full">
            <nav class="frontend-container flex items-center justify-between">

                {{-- Logo --}}
                <div class="">
                    <div class="w-[150px] h-10 bg-white flex justify-center items-center">
                        <span class="text-2xl font-bold">LOGO</span>
                    </div>
                </div>

                {{-- Links --}}
                <div class="">
                    {{-- Mobile menu button --}}
                    <div class="md:hidden">
                        <button x-on:click="mobileMenu = true" class="block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon h-10 w-10 text-white dark:text-stone-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="4" y1="6" x2="20" y2="6"></line>
                                <line x1="4" y1="12" x2="20" y2="12"></line>
                                <line x1="4" y1="18" x2="20" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden text-lg font-medium tracking-wide md:flex md:space-x-10">
                        <a href="#" class="border-b-2 border-transparent text-white transition-colors hover:border-white">Home</a>
                        <a href="#" class="border-b-2 border-transparent text-white transition-colors hover:border-white">Properties</a>
                        <a href="#" class="border-b-2 border-transparent text-white transition-colors hover:border-white">Contact us</a>
                        <a href="#" class="border-b-2 border-transparent text-white transition-colors hover:border-white">Guest Portal</a>

                    </div>
                    {{-- Desktop Menu --}}
                </div>
            </nav>

        </header>
        <section class="frontend-container flex h-full items-center justify-center">
            <div class="w-full max-w-screen-md bg-black/60 p-10 text-white">Blah</div>
        </section>
    </section>

    <section>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
        hello<br>
    </section>
</div>
