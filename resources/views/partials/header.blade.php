    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link"></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">

                <ul class="navbar-nav ml-auto">
                    <!-- Messages Dropdown Menu -->
                    <!-- Notifications Dropdown Menu -->

                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            @if (auth()->user()->is_GA_TL_ATL())
                            <span class="badge badge-danger navbar-badge">
                                {{  $notiftlgamapproverequest }}
                            </span>
                            @endif

                            @if (auth()->user()->isPIC())
                            <span class="badge badge-danger navbar-badge">
                                {{  $notifpicapprovedirect }}
                            </span>
                            @endif

                            @if (auth()->user()->isApprover())
                            <span class="badge badge-danger navbar-badge">
                                {{  $notiftluserapproverequest }}
                            </span>
                            @endif

                            @if (auth()->user()->isAdmin())
                            <span class="badge badge-danger navbar-badge">
                                {{  $notifpicapprovedirect  + $notiftluserapproverequest + $notiftlgamapproverequest }}
                            </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                            @if ((auth()->user()->is_GA_TL_ATL()) or (auth()->user()->isAdmin()))
                            <a href="{{ route('approval.pending_ga') }}" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> {{ $notiftlgamapproverequest }} Purchase Request
                                Approvals {!! (auth()->user()->isAdmin()) ? '<span class="text-red">(GA TL)</span>' : '' !!}
                            </a>
                            @endif

                            @if ((auth()->user()->isPIC()) or (auth()->user()->isAdmin()))
                            <a href="{{ route('approval.pic') }}" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> {{ $notifpicapprovedirect }} Direct Pick Up
                                Approvals
                            </a>
                            @endif

                            @if ((auth()->user()->isApprover()) or (auth()->user()->isAdmin()))
                            <a href="{{ route('approval.pending') }}" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> {{ $notiftluserapproverequest }} Purchase Request
                                Approvals {!! (auth()->user()->isAdmin()) ? '<span class="text-red">(TL)</span>' : '' !!}
                            </a>
                            @endif
                            <div class="dropdown-divider"></div>

                        </div>
                    </li>

                    <li class="nav-item">
                        <a data-toggle="modal" data-target="#logoutModal" href="#" type="submit"
                            class="btn btn-sm"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @if ($count_cart_direct > 0)
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Please checkout your Direct Pickup Request before log out.
                    </div>
                    {{-- Please checkout your Direct Pickup Request before log out! --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
                @else
                <div class="modal-body">Are you sure you want to logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('logoutpage') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Logout</button>
                    </form>

                </div>
                @endif

            </div>
        </div>
    </div>
