<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('material') }}">
                <i class="mdi mdi-table menu-icon"></i>
                <span class="menu-title">Material</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customer') }}">
                <i class="mdi mdi-table menu-icon"></i>
                <span class="menu-title">Customer</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('payment') }}">
                <i class="mdi mdi-table menu-icon"></i>
                <span class="menu-title">Pembayaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('oprasional') }}">
                <i class="mdi mdi-table menu-icon"></i>
                <span class="menu-title">Oprasional</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kelola-file') }}">
                <i class="mdi mdi-file-outline menu-icon"></i>
                <span class="menu-title">Kelola File</span>
            </a>
        </li>
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="nav-link logoutForm">
                @csrf
                <button type="submit" class="btn btn-sm p-0 m-0">
                    <i class="mdi mdi-power menu-icon"></i>
                    <span class="menu-title">Sign Out</span>
                </button>
            </form>
        </li>
        {{-- <li class="nav-item nav-category">UI Elements</li> --}}
    </ul>
</nav>
