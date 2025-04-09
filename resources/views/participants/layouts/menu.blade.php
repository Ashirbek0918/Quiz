<div class="page-sidebar">
    <a class="logo-box" href="#">
        <span><img src="{{ asset('assets/images/logo-white.png')}}" alt=""></span>
        <i class="ion-aperture" id="fixed-sidebar-toggle-button"></i>
        <i class="ion-ios-close-empty" id="sidebar-toggle-button-close"></i>
    </a>
    <div class="page-sidebar-inner">
        <div class="page-sidebar-menu">
            <ul class="accordion-menu">

                <li @if(request()->routeIs('participants.exams.*')) class="active" @endif >
                    <a href="{{ route('participants.exams.index') }}"><i class="fa fa-bank"></i>
                        <span>Testlar</span><span></span></a>
                </li>

            </ul>
        </div>
        <!--================================-->
        <!-- Sidebar Information Summary -->
        <!--================================-->

    </div>
    <!--================================-->
    <!-- Sidebar Footer Start -->
    <!--================================-->
{{--    <div class="sidebar-footer">--}}
{{--        <a class="pull-left" href="page-profile.html" data-toggle="tooltip" data-placement="top"--}}
{{--           data-original-title="Profile">--}}
{{--            <i class="icon-user"></i></a>--}}
{{--        <a class="pull-left" href="page-singin.html" data-toggle="tooltip" data-placement="top"--}}
{{--           data-original-title="{{__('auth.logOut')}}">--}}
{{--            <i class="icon-power"></i></a>--}}
{{--    </div>--}}
    <!--/ Sidebar Footer End -->
</div>
