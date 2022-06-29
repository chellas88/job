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
            <i class='bx bx-search'></i>
            <input type="text" placeholder="Search...">
        </li>
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
            <a href="/admin/countries">
                <i class='icon-flag'></i>
                <span class="links_name">Страны</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>
        <li>
            <a href="/dashboard">
                <i class='bx bx-cog' ></i>
                <span class="links_name">Settings</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>
    </ul>

    <div class="profile_content">
        <div class="profile">
            <div class="profile_details">
                <img src="/images/avatar.svg">
                <div class="user_name">
                    Admin
                </div>
            </div>
            <i class='bx bx-log-out' id="log_out"></i>
        </div>
    </div>
</div>
