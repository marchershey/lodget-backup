<div x-data="{mobileMenu:false}" class="relative">
    {{-- Mobile menu --}}
    <div x-show="mobileMenu" x-cloak class="absolute inset-0 z-10 w-full overflow-hidden bg-neutral-100 dark:bg-zinc-900 dark:text-white">
        <button x-on:click="mobileMenu = false" class="absolute top-0 right-0 m-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted h-10 w-10" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="flex h-full w-full items-center justify-center">
            <div class="text-dark flex flex-col space-y-8 text-center text-4xl font-bold dark:text-white">
                <a href="#">Home</a>
                <a href="#">Properties</a>
                <a href="#">Contact us</a>
                <a href="#">Guest Portal</a>
            </div>
        </div>
    </div>

    <div x-show="!mobileMenu">
        <section class="relative h-screen w-full bg-cover bg-center" style="background-image: url(https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80)">
            {{-- Dark overlay --}}
            <div class="absolute inset-0 bg-white/60 dark:bg-black/60"></div>


            {{-- Navbar --}}
            <header class="fixed w-full">
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
                        <button x-on:click="mobileMenu = true" class="block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon h-10 w-10 text-gray-800 dark:text-stone-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="4" y1="6" x2="20" y2="6"></line>
                                <line x1="4" y1="12" x2="20" y2="12"></line>
                                <line x1="4" y1="18" x2="20" y2="18"></line>
                            </svg>
                        </button>
                        {{-- Desktop Menu --}}
                    </div>

                </nav>
            </header>
        </section>
    </div>
</div>
