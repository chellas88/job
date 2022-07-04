<div class="contactbar p-3">
    <ul class="contacts">
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
        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{\Illuminate\Support\Facades\App::currentLocale()}}</a>
        <ul class="dropdown-menu justify-content-end">
            @foreach(config('app.locales') as $locale)
            <li>
                <a class="dropdown-item locale text-black" value="{{ $locale }}">{{ $locale }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <ul class="auth">

        @guest
            <li>
                <a href="/{{\Illuminate\Support\Facades\App::getLocale()}}/login" class="icon icon-sign_in">
                    {{ __('navs.sign_in') }}
                </a>
            </li>
            <li>
                <a href="/{{\Illuminate\Support\Facades\App::getLocale()}}/register" class="icon icon-registration">
                    {{ __('navs.sign_up') }}
                </a>
            </li>
        @endguest
        @auth
            <li>
                <span><a href="/{{\Illuminate\Support\Facades\App::getLocale()}}/home">{{ Auth::user()->name }}</a></span>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="icon icon-logout"></i>{{ __('navs.logout') }}
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @endauth
    </ul>
</div>
