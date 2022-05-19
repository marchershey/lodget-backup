<x-layouts.base>
    <div x-data="{ mobileSidebar: false }" class="h-full bg-gray-100">
        <!-- Mobile sidebar -->
        <div x-show="mobileSidebar" x-cloak class="fixed inset-0 z-40 flex md:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
            <div class="relative flex w-full max-w-xs flex-1 flex-col bg-gray-800 pt-5 pb-4">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button x-on:click="mobileSidebar = false" type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <!-- Heroicon name: outline/x -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-shrink-0 items-center px-4">
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow">
                </div>
                <div class="mt-5 h-0 flex-1 overflow-y-auto">
                    <x-layouts.navs.host />
                </div>
            </div>
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
            <div class="w-14 flex-shrink-0" aria-hidden="true"></div>
        </div>
        <!-- Desktop sidebar -->
        <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
            <div class="flex min-h-0 flex-1 flex-col bg-gray-800">
                <div class="flex h-16 flex-shrink-0 items-center bg-gray-900 px-4">
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow">
                </div>
                <div class="flex flex-1 flex-col overflow-y-auto">
                    <x-layouts.navs.host />
                </div>
            </div>
        </div>
        <div class="flex flex-col md:pl-64">
            <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">
                <button x-on:click="mobileSidebar = true" type="button" class="flex-none border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <!-- Heroicon name: outline/menu-alt-2 -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <div class="flex min-w-0 flex-1 items-center px-4">
                    <!-- Property selector -->
                    <div class="mr-2 min-w-0 flex-auto">
                        <div class="">
                            <div class="relative w-auto max-w-[250px]">
                                <button type="button" class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                                    <span class="flex items-center">
                                        <div class="h-6 w-8 flex-none rounded bg-black"></div>
                                        <span class="ml-3 block truncate"> Ohana Burnside </span>
                                    </span>
                                    <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                        <!-- Heroicon name: solid/selector -->
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>

                                <!--
                                Select popover, show/hide based on select state.
                          
                                Entering: ""
                                  From: ""
                                  To: ""
                                Leaving: "transition ease-in duration-100"
                                  From: "opacity-100"
                                  To: "opacity-0"
                              -->
                                <ul class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3">
                                    <!--
                                  Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.
                          
                                  Highlighted: "text-white bg-indigo-600", Not Highlighted: "text-gray-900"
                                -->
                                    <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900" id="listbox-option-0" role="option">
                                        <div class="flex items-center">
                                            <img src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-shrink-0 rounded-full">
                                            <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                            <span class="ml-3 block truncate font-normal"> Wade Cooper </span>
                                        </div>

                                        <!--
                                    Checkmark, only display for selected option.
                          
                                    Highlighted: "text-white", Not Highlighted: "text-indigo-600"
                                  -->
                                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                            <!-- Heroicon name: solid/check -->
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </li>

                                    <!-- More items... -->
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="flex-none justify-self-end">
                        <button type="button" class="rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                    </div>

                    <!-- Profile -->
                    <div class="flex-none justify-self-end">
                        <div x-data="{ userMenu: false }" class="relative ml-3">
                            <div>
                                <button x-on:click="userMenu = !userMenu" type="button" class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                </button>
                            </div>
                            <div x-cloak x-show="userMenu" x-on:click.away="userMenu = false" class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <x-layouts.navs.profile />
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="flex flex-1 justify-between px-4">

                    <!-- Property selector -->
                    <div class="flex items-center">
                        <div class="relative mt-1" x-data="{ open: false }">
                            <button x-on:click="open = !open" type="button" class="relative cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                                <span class="flex items-center">
                                    <div class="h-6 w-8 flex-shrink-0 rounded bg-black"></div>
                                    <span class="ml-3 block truncate"> Ohana Burnside witha long title </span>
                                </span>
                                <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                    <!-- Heroicon name: solid/selector -->
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>
                            <ul x-show="open" class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3">
                                <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                        <img src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-shrink-0 rounded-full">
                                        <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                        <span class="ml-3 block truncate font-normal"> Wade Cooper </span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                        <!-- Heroicon name: solid/check -->
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </li>

                                <!-- More items... -->
                            </ul>
                        </div>
                    </div>


                    <div class="ml-4 flex flex-none items-center md:ml-6">

                        <!-- Notifications icon -->
                        <button type="button" class="rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span class="sr-only">View notifications</span>
                            <!-- Heroicon name: outline/bell -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>

                        <!-- Profile dropdown -->
                        <div x-data="{ userMenu: false }" class="relative ml-3">
                            <div>
                                <button x-on:click="userMenu = !userMenu" type="button" class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                </button>
                            </div>
                            <div x-cloak x-show="userMenu" x-on:click.away="userMenu = false" class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <x-layouts.navs.profile />
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <main class="min-h-full flex-1 bg-gray-100">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 md:px-8">
                    @if (isset($title) || isset($goback) || isset($action))
                        <div class="mb-5">
                            <div class="flex items-baseline justify-between">
                                <div class="mb-5 flex items-center space-x-3">
                                    @if (isset($goback))
                                        <a href="{{ url()->previous() }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted mt-1 h-7 w-7" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <polyline points="15 6 9 12 15 18"></polyline>
                                            </svg>
                                        </a>
                                    @endif
                                    @if (isset($title))
                                        <h1 {{ $title->attributes->class(['text-2xl font-semibold text-gray-900 block align-baseline']) }}>{{ $title }}</h1>
                                    @endif
                                </div>

                                @if (isset($action))
                                    <div {{ $action->attributes->class(['']) }}>{{ $action }}</div>
                                @endif
                            </div>
                            <hr>
                        </div>
                    @endif
                    <div class="">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-layouts.base>
