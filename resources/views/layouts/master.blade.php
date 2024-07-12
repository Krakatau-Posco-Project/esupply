<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head-meta')
    @include('partials.head-style')
    @include('partials.head-script')
    @yield('style')
</head>
{{-- <body class="control-sidebar-slide-open text-sm sidebar-mini sidebar-collapse layout-fixed">  --}}

@php
    $notifpicapprovedirect = $transaction->where('purchase_type', 'Direct Pick Up')->where('pic_approval', 'Pending')->count();

    $notiftluserapproverequest = $pr_trans->where('tl_approval', 'Pending')->count();

    $notiftlgamapproverequest = $transaction->where('purchase_type', 'Purchase Request Proposal')->where('tl_approval', 'Approved')->where('tlgam_approval', 'Pending')->count();
@endphp

<body class="control-sidebar-slide-open text-sm sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- Content Wrapper. -->
        @include('partials.footer')
        @include('partials.foot-script')
    </div>
    <!-- ./wrapper -->
    @yield('script')
    @stack('child-scripts')
</body>

</html>
