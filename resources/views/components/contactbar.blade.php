<div class="contactbar p-3">
    <ul>
        <li>
            <i class="icon icon-phone"></i>
            39099 999 99 99
        </li>
        <li>
            <i class="icon icon-email"></i>
            admin@gmail.com
        </li>
    </ul>
    <div class="lang px-2">
        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">ru</a>
        <ul class="dropdown-menu justify-content-end">
            <li>ua</li>
        </ul>
    </div>
    <ul class="auth">

        @guest
            <li>
                <a href="/login" class="icon icon-sign_in">
                    Sign In
                </a>
            </li>
            <li>
                <a href="/register" class="icon icon-registration">
                    Sign Up
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
                    <i class="icon icon-logout"></i>Logout
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @endauth
    </ul>
</div>
