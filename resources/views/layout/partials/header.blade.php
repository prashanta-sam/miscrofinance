<!-- resources/views/includes/header.blade.php -->
  <!--start wrapper-->
  @php
      $user = Auth::user();
     // dd($user->role);
  @endphp
  <div class="wrapper">
        <header class="top-header">
            <nav class="navbar navbar-expand gap-3 align-items-center">
            <div class="mobile-toggle-icon fs-3">
                <i class="bi bi-list"></i>
                </div>
                <div class="top-navbar-right ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item search-toggle-icon">
                    <a class="nav-link" href="#">
                        <div class="">
                        <i class="bi bi-search"></i>
                        </div>
                    </a>
                </li>


                <li class="nav-item dropdown dropdown-user-setting">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                    <div class="user-setting d-flex align-items-center">
                        <img src="{{ url('/').'/' }}assets/images/avatars/avatar-1.png" class="user-img" alt="">
                    </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                        <div class="d-flex align-items-center">
                            <img src="{{ url('/').'/'}}assets/images/avatars/avatar-1.png" alt="" class="rounded-circle" width="54" height="54">
                            <div class="ms-3">
                                <h6 class="mb-0 dropdown-user-name">{{ $user->name }}</h6>
                                <small class="mb-0 dropdown-user-designation text-secondary">{{ $user->role }}</small>
                            </div>
                        </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                        @if($user->role=='admin')
                            <li>
                                <a class="dropdown-item"   href="{{ route('edit_user', ['user' => Crypt::encryptString($user->id)]) }}">
                                    <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-gear-fill"></i></div>
                                    <div class="ms-3"><span>Setting</span></div>
                                    </div>
                                </a>
                            </li>
                        @endif

                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout_user') }}">
                                <div class="d-flex align-items-center">
                                <div class=""><i class="bi bi-lock-fill"></i></div>
                                <div class="ms-3"><span>Logout</span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                </ul>
                </div>
            </nav>
        </header>


        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
              <div>
                <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
              </div>
              <div>
                <h4 class="logo-text">Snacked</h4>
              </div>
              <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
              </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
              <li>
                <a href="{{ route('dashboard') }}">
                  <div class="parent-icon"><i class="bi bi-house-fill"></i>
                  </div>
                  <div class="menu-title">Dashboard</div>
                </a>
                {{-- <ul>
                  <li> <a href="index.html"><i class="bi bi-circle"></i>Default</a>
                  </li>
                  <li> <a href="index2.html"><i class="bi bi-circle"></i>Alternate</a>
                  </li>
                </ul> --}}
              </li>
              @if($user->role=='admin')
              <li>
                <a href="javascript:;" class="has-arrow">
                  <div class="parent-icon"><i class="bi bi-grid-fill"></i>
                  </div>
                  <div class="menu-title">Employee</div>
                </a>
                <ul>
                  <li><a href="{{ route('add_user') }}"><i class="bi bi-circle"></i>Add Employee</a>
                  </li>
                  <li> <a href="{{ route('list_user') }}"><i class="bi bi-circle"></i>Employee List</a>
                  </li>
                </ul>
              </li>
              @endif
              <li>
                <a href="javascript:;" class="has-arrow">
                  <div class="parent-icon"><i class="bi bi-grid-fill"></i>
                  </div>
                  <div class="menu-title">Customer</div>
                </a>
                <ul>
                  <li><a href="{{ route('add_customer') }}"><i class="bi bi-circle"></i>Add Customer</a>
                  </li>
                  <li> <a href="{{ route('list_customer') }}"><i class="bi bi-circle"></i>Customer List</a>
                  </li>
                </ul>
              </li>
              <li>
                <a href="javascript:;" class="has-arrow">
                  <div class="parent-icon"><i class="bi bi-grid-fill"></i>
                  </div>
                  <div class="menu-title">Loans</div>
                </a>
                <ul>
                  <li>
                    {{-- <a href="{{ route('add_loan') }}"><i class="bi bi-circle"></i>Add Loan</a> --}}
                    {{-- <a href="{{ route('add_loan',['user' => Crypt::encryptString('all')]) }}"><i class="bi bi-circle"></i>Add Loan</a> --}}

                  </li>
                  <li> <a href="{{ route('list_loan') }}"><i class="bi bi-circle"></i>List of loan </a>
                  </li>
                </ul>

              </li>
              <li>
                <a href="javascript:;" class="has-arrow">
                  <div class="parent-icon"><i class="bi bi-grid-fill"></i>
                  </div>
                  <div class="menu-title">Collection</div>
                </a>
                <ul>
                  <li>
                  </li>
                  <li> <a href="{{ route('list_rd') }}"><i class="bi bi-circle"></i>List of daily </a>
                  </li>
                </ul>

              </li>
              {{-- <li class="menu-label">UI Elements</li>
              <li>
                <a href="widgets.html">
                  <div class="parent-icon"><i class="bi bi-droplet-fill"></i>
                  </div>
                  <div class="menu-title">Widgets</div>
                </a>
              </li> --}}

            </ul>
            <!--end navigation-->
         </aside>
         <!--end sidebar -->
