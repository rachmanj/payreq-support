<li class="nav-item dropdown">
  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Admin</a>
  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
    {{-- @hasanyrole('superadmin')
    <li><a href="{{ route('bucs.index') }}" class="dropdown-item">BUC</a></li>
    <li><a href="{{ route('account.index') }}" class="dropdown-item">Account List</a></li>
    <li><a href="{{ route('transaksi.index') }}" class="dropdown-item">Transaksi List</a></li>
    @endhasanyrole --}}
    <li><a href="{{ route('users.index') }}" class="dropdown-item">User List</a></li>
    <li><a href="{{ route('roles.index') }}" class="dropdown-item">Roles</a></li>
    <li><a href="{{ route('permissions.index') }}" class="dropdown-item">Permissions</a></li>
  </ul>
</li>