<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        @can('isAdmin')
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
        @endcan
        @can('isAffiliator')
        <div class="sidebar-brand-text mx-3">Affiliate Panel</div>
        @endcan
    </a>
    <hr class="sidebar-divider my-0">
    @can('isAdmin')
    <li class="nav-item {{ setActive('admin.dashboard') }}">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ setActive(['affiliate.index', 'affiliate.byVendor']) }}">
        <a href="{{ route('affiliate.index') }}" class="nav-link">
            <i class="fas fa-fw fa-users"></i>
            <span>Affiliate</span>
        </a>
    </li>
    <li class="nav-item {{ setActive('transaction.index') }}">
        <a href="{{ route('transaction.index') }}" class="nav-link">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Transaction</span>
        </a>
    </li>
    <li class="nav-item {{ setActive('lead.index') }}">
        <a href="{{ route('lead.index') }}" class="nav-link">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Lead</span>
        </a>
    </li>
    <li class="nav-item {{ setActive(['vendor.index', 'vendor.add', 'vendor.edit']) }}">
        <a href="{{ route('vendor.index') }}" class="nav-link">
            <i class="fas fa-fw fa-building"></i>
            <span>Vendor</span>
        </a>
    </li>
    <li class="nav-item {{ setActive('withdraw.request') }}">
        <a href="{{ route('withdraw.request') }}" class="nav-link">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Withdraw Request</span>
        </a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ setActive(['komisi.index', 'payout.index']) }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#setting" aria-expanded="true" aria-controls="setting">
          <i class="fas fa-fw fa-cog"></i>
          <span>Setting</span>
        </a>
        <div id="setting" class="collapse {{ setDropdownShow(['komisi.index', 'payout.index']) }}" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ setActive('komisi.index') }}" href="{{ route('komisi.index') }}">Komisi</a>
            <a class="collapse-item {{ setActive('payout.index') }}" href="{{ route('payout.index') }}">Minimum Payout</a>
          </div>
        </div>
    </li>
    @endcan

    @can('isAffiliator')
    <li class="nav-item {{ setActive('affiliate.dashboard') }}">
        <a class="nav-link" href="{{route('affiliate.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ setActive('affiliate.vendor') }}">
        <a href="{{ route('affiliate.vendor') }}" class="nav-link">
            <i class="fas fa-fw fa-building"></i>
            <span>Vendor List</span>
        </a>
    </li>
    <li class="nav-item {{ setActive('affiliate.transaction') }}">
        <a href="{{ route('affiliate.transaction') }}" class="nav-link">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Transaction</span>
        </a>
    </li>
    <li class="nav-item {{ setActive('affiliate.lead') }}">
        <a href="{{ route('affiliate.lead') }}" class="nav-link">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Lead</span>
        </a>
    </li>
    
    <li class="nav-item {{ setActive('affiliate.wallet') }}">
        <a href="{{ route('affiliate.wallet') }}" class="nav-link">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>My Wallet</span>
        </a>
    </li>
    <li class="nav-item {{ setActive('affiliate.contactAdmin') }}">
        <a href="{{ route('affiliate.contactAdmin') }}" class="nav-link">
            <i class="fas fa-fw fa-phone-alt"></i>
            <span>Contact Admin</span>
        </a>
    </li>
    @endcan
</ul>