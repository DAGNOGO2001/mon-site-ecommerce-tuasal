<nav x-data="{ open: false }" class="navigation">

    <!-- Alpine.js (IMPORTANT) -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
    :root {
        --primary-green: #3e7d48;
        --bg-white: #ffffff;
        --text-dark: #333;
        --text-gray: #777;
        --hover-gray: #f5f5f5;
    }

    .navigation {
        background: var(--bg-white);
        border-bottom: 1px solid #eee;
        font-family: Arial, sans-serif;
    }

    .max-w-7xl {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .flex { display: flex; align-items: center; }
    .justify-between { justify-content: space-between; }
    .h-16 { height: 64px; }
    .shrink-0 { flex-shrink: 0; }

    .dropdown-button {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid transparent;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--primary-green);
        background: var(--bg-white);
        cursor: pointer;
        transition: 0.3s;
    }

    .dropdown-button:hover {
        background: #e6f2e6;
    }

    .dropdown-menu {
        position: absolute;
        right: 0;
        margin-top: 0.5rem;
        background: var(--bg-white);
        border: 1px solid #ddd;
        border-radius: 8px;
        min-width: 180px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 50;
    }

    .dropdown-link {
        display: block;
        padding: 10px 15px;
        font-size: 0.875rem;
        color: var(--text-dark);
        text-decoration: none;
        transition: 0.2s;
    }

    .dropdown-link:hover {
        background: var(--hover-gray);
    }

    .hamburger-button {
        display: none;
        padding: 6px;
        border-radius: 6px;
        cursor: pointer;
    }

    .hamburger-button:hover {
        background: var(--hover-gray);
    }

    @media (max-width: 640px) {
        .hidden.sm\:flex { display: none !important; }
        .sm\:hidden { display: block !important; }
        .hamburger-button { display: inline-flex; }

        .responsive-menu {
            display: flex;
            flex-direction: column;
            background: var(--bg-white);
            border-top: 1px solid #eee;
            padding: 10px 0;
        }

        .responsive-menu a,
        .responsive-menu button {
            padding: 10px 20px;
            text-decoration: none;
            color: var(--text-dark);
            background: none;
            border: none;
            text-align: left;
        }

        .responsive-menu a:hover,
        .responsive-menu button:hover {
            background: var(--hover-gray);
        }
    }
    </style>

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <!-- Logo -->
                </div>
            </div>

            <!-- RIGHT (DESKTOP) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 relative">

                <div @click="open = !open" class="dropdown-button">
                    {{ Auth::user()->name }}

                    <svg class="h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                    </svg>
                </div>

                <!-- DROPDOWN -->
                <div x-show="open" @click.away="open = false" class="dropdown-menu">
                    <a href="{{ route('profile.edit') }}" class="dropdown-link">Profil</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-link w-full text-left">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>

            <!-- HAMBURGER MOBILE -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="hamburger-button">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="responsive-menu sm:hidden">

        <a href="{{ route('dashboard') }}"></a>

        <a href="{{ route('profile.edit') }}">Profil</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Déconnexion</button>
        </form>

    </div>

</nav>