<div class="account">
    @auth
        <div class="account-trigger">
            <div class="account-icon">
                <span class="material-symbols-outlined">person</span>
            </div>
            <span class="account-username">{{ Auth::user()->username }}</span>
        </div>
        <div class="account-dropdown">
            <div class="account-dropdown-header">
                <div class="account-dropdown-header-name">{{ Auth::user()->username }}</div>
                <div class="account-dropdown-header-email">{{ Auth::user()->email }}</div>
            </div>
            <a href="#">
                <span class="material-symbols-outlined">person</span>
                Profile
            </a>
            <a href="#">
                <span class="material-symbols-outlined">restaurant</span>
                Shared Recipes
            </a>
            <a href="{{ route('recipes.create') }}">
                <span class="material-symbols-outlined">add_circle</span>
                Share a Recipe
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>
        </div>
    @else
        <div class="account-guest">
            <a href="{{ route('login') }}" class="btn btn-small">Login</a>
            <a href="{{ route('signup') }}" class="btn btn-small">Register</a>
        </div>
    @endauth
</div>
