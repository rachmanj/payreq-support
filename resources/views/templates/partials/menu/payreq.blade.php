<li class="nav-item dropdown">
  <a id="dropdownPayreq" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">PayReq</a>
  <ul aria-labelledby="dropdownPayreq" class="dropdown-menu border-0 shadow">
    @hasanyrole('superadmin|admin_accounting')
    <li><a href="{{ route('approved.index') }}" class="dropdown-item">Approved</a></li>
    <li><a href="{{ route('realization.index') }}" class="dropdown-item">Realization</a></li>
    @endhasanyrole
    <li><a href="{{ route('outgoing.index') }}" class="dropdown-item">Outgoing</a></li>
    <li><a href="{{ route('verify.index') }}" class="dropdown-item">Verification</a></li>
  </ul>
</li>