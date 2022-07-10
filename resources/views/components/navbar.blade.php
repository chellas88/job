<nav class="navbar navbar-expand-md navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <svg class="logo-icon">
                <use xlink:href="/images/sprites.svg#logo"></use>
            </svg>
            GlobalLang<span>Net</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto main-menu">
                <li><a class="{{ request()->is('/') ? 'active' : '' }}" href="/">{{ __('navs.home') }}</a></li>
                <li><a href="/contacts">{{ __('navs.contacts') }}</a></li>
                <li><a href="/about">{{ __('navs.about_us') }}</a></li>
            </ul>
        </div>
    </div>
</nav>
