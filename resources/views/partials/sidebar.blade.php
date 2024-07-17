<style>
    .user-panel img {
        height: 2.1rem !important;
        width: 2.1rem;
    }
</style>
{{-- @php
    if ($_SESSION['clinic_priv'] == 3) {
        //nurse
        $linkvisit = '/?nurse=' . $_SESSION['nurse_slug'];
    } elseif ($_SESSION['clinic_priv'] == 4) {
        //doctor
        $linkvisit = '/?doc=' . $_SESSION['doc_slug'];
    } else {
        //administrator / administrator
        $linkvisit = '';
    }
@endphp --}}


<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <center><img src="{{ asset('pic/') . '/logokp.png' }}" alt="Krakatau Posco" class="brand-image" style="height: 23px;"></center>
        <br>
        <center><span class="brand-text font-weight-bold text-dark text-md">GAM E-General Service</span></center>
    </a>
    <!-- Sidebar -->
    <div class="sidebar os-theme-light">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{-- <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image"> --}}
                {{-- <img src="{{ asset('pic/default.jpg') }}" class="img-circle elevation-2" alt="User Image"> --}}
                {{-- @if (auth()->user()->pp)
                    <img src="{{ asset('storage/pp/') }}/{{ auth()->user()->pp }}" class="img-circle elevation-2"
                        alt="User Image">
                @else --}}
                <img src="{{ asset('pic/default.jpg') }}" class="img-circle elevation-2" alt="User Image">
                {{-- @endif --}}

            </div>

            <div class="info" style="font-size: 0.65rem; line-height:0.5rem">
                <a href="" class="d-block" style="font-size: 0.9rem;">{{ auth()->user()->name }}</a>
                <br>
                <span class="text-dark">{{ auth()->user()->orgunit }}</span>
            </div>
        </div>
        <span id="myloginid" style="display: none">{{ auth()->user()->id_user_me }}</span>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar  flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Main
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.stock') }}" class="nav-link {{ request()->is('stock*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>
                            Item Stock
                        </p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ url('/visit') }}
                    "
                        class="nav-link {{ request()->is('visit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>
                            Purchase Request
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item {{ request()->is('pr*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('pr*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cart-shopping"></i>
                        <p>
                            Purchase Request
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('purchase.history') }}" class="nav-link {{ request()->is('pr/history*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transaction History</p>
                            </a>
                        </li>
                        {{-- @canany(['direct']) --}}
                        <li class="nav-item">
                            <a href="{{ route('purchase.direct') }}" class="nav-link {{ request()->is('pr/direct*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Direct Pick up</p>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        <li class="nav-item">
                            <a href="{{ route('purchase.propose') }}" class="nav-link {{ request()->is('pr/propose*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Request Proposal</p>
                            </a>

                        </li>
                    </ul>
                </li>
                @canany(['pic', 'tluser', 'tlgam', 'admin'])
                    <li class="nav-item {{ request()->is('approval*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('approval*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <p>
                                Approval
                                <i class="right fas fa-angle-left"></i>
                                @if (auth()->user()->priv == 'pic')
                                    @if ($notifpicapprovedirect == 0)
                                    @else
                                        <span class="badge badge-danger right">{{ $notifpicapprovedirect }}</span>
                                    @endif
                                @elseif (auth()->user()->priv == 'admin')
                                    @if ($notifpicapprovedirect + $notiftlgamapproverequest + $notiftluserapproverequest == 0)
                                    @else
                                        <span class="badge badge-danger right">{{ $notifpicapprovedirect + $notiftlgamapproverequest + $notiftluserapproverequest }}</span>
                                    @endif
                                @elseif (auth()->user()->isApprover())
                                    @if ($notiftluserapproverequest == 0)
                                    @else
                                        <span class="badge badge-danger right">{{ $notiftluserapproverequest }}</span>
                                    @endif
                                @else
                                @endif

                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @canany(['pic', 'admin'])
                                <li class="nav-item">
                                    <a href="{{ route('approval.pic') }}" class="nav-link {{ request()->is('approval/pic*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>PIC</p>
                                        @if ($notifpicapprovedirect == 0)
                                        @else
                                            <span class="badge badge-danger right">{{ $notifpicapprovedirect }}</span>
                                        @endif
                                    </a>

                                </li>
                            @endcanany

                            @if (auth()->user()->isApprover())
                            <li class="nav-item">
                                <a href="{{ route('approval.pending') }}" class="nav-link {{ request()->is('approval/pending') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending TL</p>
                                    @if ($notiftluserapproverequest == 0)
                                    @else
                                        <span class="badge badge-danger right">{{ $notiftluserapproverequest }}</span>
                                    @endif
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->is_GA_TL_ATL())
                            <li class="nav-item">
                                <a href="{{ route('approval.pending_ga') }}" class="nav-link {{ request()->is('approval/pending_ga*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending GA TL</p>
                                    @if ($notiftlgamapproverequest == 0)
                                    @else
                                        <span class="badge badge-danger right">{{ $notiftlgamapproverequest }}</span>
                                    @endif
                                </a>
                            </li>
                            @endif

                        </ul>
                    </li>
                @endcanany

                @canany(['pic', 'admin'])
                    <li class="nav-item  {{ request()->is('admin*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Administrator
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.direct') }}" class="nav-link {{ request()->is('admin/direct*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Direct Pick up</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{ route('admin.pr') }}" class="nav-link {{ request()->is('admin/pr*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase Request Proposal</p>
                                </a>

                            </li>
                            {{-- <li class="nav-item">
                                <a href="#" class="nav-link ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Update Stock</p>
                                </a>

                            </li> --}}

                            <li class="nav-item">
                                <a href="{{ route('admin.masteritem') }}" class="nav-link  {{ request()->is('admin/masteritem*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Item Master Data</p>
                                </a>

                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.user') }}" class="nav-link  {{ request()->is('admin/user*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>User</p>
                                </a>

                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.picteam') }}" class="nav-link  {{ request()->is('admin/picteam*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>PIC Team</p>
                                </a>

                            </li>
                        </ul>
                    </li>
                @endcanany
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    {{-- {{ $getmenu }} --}}
</aside>
{{-- {{ $getmenu }} --}}
