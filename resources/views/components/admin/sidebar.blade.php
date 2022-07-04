<div class="sidebar active">
    <div class="logo_content">
        <div class="logo">
            <i class='bx bx-line-chart' ></i>
            <div class="logo_name">AdminPanel</div>
        </div>
        <i class='bx bx-menu' id="menu"></i>
    </div>
    <ul class="nav_list">
        <li>
            <a href="{{ route('index') }}" class="{{ request()->route()->getName() == 'index' ? 'active' : ''}}">
                <i class='icon-grid'></i>
                <span class="links_name">Дашборд</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>
        <li>
            <a href="{{ route('category.index') }}" class="{{ request()->route()->getName() == 'category.index' ? 'active' : ''}}">
                <i class='icon-category'></i>
                <span class="links_name">Категории</span>
            </a>
            <span class="tooltip">Категории</span>
        </li>
        <li>
            <a href="{{ route('country.index') }}" class="{{ request()->route()->getName() == 'country.index' ? 'active' : ''}}">
                <i class='icon-flag'></i>
                <span class="links_name">Страны</span>
            </a>
            <span class="tooltip">Страны</span>
        </li>
        <li>
            <a href="{{ route('language.index') }}" class="{{ request()->route()->getName() == 'language.index' ? 'active' : ''}}">
                <i class='icon-lang' ></i>
                <span class="links_name">Языки</span>
            </a>
            <span class="tooltip">Языки</span>
        </li>
        <li>
            <a href="{{ route('user.index') }}" class="{{ request()->route()->getName() == 'user.index' ? 'active' : ''}}">
                <i class='icon-user'></i>
                <span class="links_name">Пользователи</span>
            </a>
            <span class="tooltip">Пользователи</span>
        </li>
    </ul>

    <div class="profile_content">
        <div class="profile">
            <div class="profile_details">
                <div class="user_name">
                    Вернуться на сайт
                </div>
            </div>
            <a href="/">
            <i class='bx bx-log-out' id="log_out"></i>
            </a>
        </div>
    </div>
</div>
