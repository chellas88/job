<div class="contactbar p-3">
    <ul>
        <li>
            <svg class="contact-icon">
                <use xlink:href="/icons/sprites.svg#phone-icon"></use>
            </svg>
            39099 999 99 99
        </li>
        <li>
            <svg class="contact-icon">
                <use xlink:href="/icons/sprites.svg#email-icon"></use>
            </svg>
            admin@gmail.com
        </li>
    </ul>
    <ul class="auth">
        @guest
        <li>
            <a href="/login">
                <svg class="contact-icon">
                    <use xlink:href="/icons/sprites.svg#signin-icon"></use>
                </svg>
                Sign In
            </a>
        </li>
        <li>
            <a href="/register">
                <svg class="contact-icon">
                    <use xlink:href="/icons/sprites.svg#register-icon"></use>
                </svg>
                Register
            </a>
        </li>
        @endguest
        @auth
            <li>
                <span><a href="/home">{{ Auth::user()->name }}</a></span>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg class="contact-icon">
                        <use xlink:href="/icons/sprites.svg#logout-icon"></use>
                    </svg>
                    Logout
                </a>
            </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
        @endauth
    </ul>
</div>
