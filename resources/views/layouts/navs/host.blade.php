<nav class="flex-1 space-y-1 px-2 py-4" x-data>
    <a href="{{ route('host.dashboard') }}" class="{{ request()->is('host') ? 'nav-active' : 'nav-default' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <circle cx="12" cy="13" r="2"></circle>
            <line x1="13.45" y1="11.55" x2="15.5" y2="9.5"></line>
            <path d="M6.4 20a9 9 0 1 1 11.2 0z"></path>
        </svg>
        Dashboard
    </a>

    <a href="{{ route('host.reservations') }}" class="{{ request()->is('host/reservations*') ? 'nav-active' : 'nav-default' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <rect x="4" y="5" width="16" height="16" rx="2"></rect>
            <line x1="16" y1="3" x2="16" y2="7"></line>
            <line x1="8" y1="3" x2="8" y2="7"></line>
            <line x1="4" y1="11" x2="20" y2="11"></line>
            <line x1="11" y1="15" x2="12" y2="15"></line>
            <line x1="12" y1="15" x2="12" y2="18"></line>
        </svg>
        Reservations
    </a>

    <a href="{{ route('host.properties.index') }}" class="{{ request()->is('host/properties*') ? 'nav-active' : 'nav-default' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M8 9l5 5v7h-5v-4m0 4h-5v-7l5 -5m1 1v-6a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v17h-8"></path>
            <line x1="13" y1="7" x2="13" y2="7.01"></line>
            <line x1="17" y1="7" x2="17" y2="7.01"></line>
            <line x1="17" y1="11" x2="17" y2="11.01"></line>
            <line x1="17" y1="15" x2="17" y2="15.01"></line>
        </svg>
        Properties
    </a>

    <a href="#" class="{{ request()->is('host/guests*') ? 'nav-active' : 'nav-default' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
        </svg>
        Guests
    </a>

    <a href="#" class="{{ request()->is('host/settings*') ? 'nav-active' : 'nav-default' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
        Settings
    </a>

</nav>
