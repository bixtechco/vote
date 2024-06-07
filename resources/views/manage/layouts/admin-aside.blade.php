<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
     data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper">
        <div class="hover-scroll-y my-5 my-lg-2 mx-4" data-kt-scroll="true"
             data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper"
             data-kt-scroll-offset="5px">
            <!--begin::Sidebar menu-->
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                 class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3 mb-5">
                <!--begin:Menu item-->
                <div class="menu-item here show menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link {{ Request::routeIs('manage.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>

                        <a href="{{ route('manage.dashboard') }}" class="menu-title">Dashboards</a>
                        {{-- <span class="menu-arrow"></span> --}}
                    </span>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Request::routeIs('manage.people.users.*') || Request::routeIs('manage.people.admins.*') ? 'show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-gift fs-2"></i>
											</span>
											<span class="menu-title">User Management</span>
											<span class="menu-arrow"></span>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ Request::routeIs('manage.people.users.*') ? 'active' : '' }}" href="{{route('manage.people.users.list')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">User List</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link {{ Request::routeIs('manage.people.admins.*') ? 'active' : '' }}" href="{{route('manage.people.admins.list')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Admin list</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <div class="menu-item here show menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link {{ Request::routeIs('manage.voting.associations.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-people fs-2"></i>
                        </span>

                        <a href="{{ route('manage.voting.associations.list') }}" class="menu-title">Associations</a>
                        {{-- <span class="menu-arrow"></span> --}}
                    </span>
                    <!--end:Menu link-->
                </div>

                <div class="menu-item here show menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link {{ Request::routeIs('manage.voting.voting-sessions.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-notepad fs-2"></i>
                        </span>

                        <a href="{{ route('manage.voting.voting-sessions.list') }}" class="menu-title">Voting Sessions</a>
                        {{-- <span class="menu-arrow"></span> --}}
                    </span>
                    <!--end:Menu link-->
                </div>
            </div>
            <!--end::Sidebar menu-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Sidebar-->
