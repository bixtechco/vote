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
                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-home-2 fs-2"></i>
											</span>
											<span class="menu-title">Dashboards</span>
											<span class="menu-arrow"></span>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Request::routeIs('main.main.home') ? 'active' : '' }}"
                               href="{{ route('main.main.home') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Home</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Request::routeIs('main.voting.associations.*') ? 'show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link {{ Request::routeIs('main.voting.associations.*') ? 'active' : '' }}">
                    <span class="menu-icon">
                        <i class="ki-outline ki-gift fs-2"></i>
                    </span>
                    <span class="menu-title">Associations Management</span>
                    <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Request::routeIs('main.voting.associations.*') ? 'active' : '' }}" href="{{route('main.voting.associations.list')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Association List</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <!--begin:Menu link-->
                    <a class="menu-link {{ Request::routeIs('main.voting.voting-sessions.history') ? 'active' : '' }}"
                       href="{{route('main.voting.voting-sessions.history')}}">
                    <span class="menu-icon">
                        <i class="ki-outline ki-save-2 fs-2"></i>
                    </span>
                        <span class="menu-title">History</span>
                    </a>
                    <!--end:Menu link-->
                </div>

                <!--end:Menu item-->
            </div>
            <!--end::Sidebar menu-->
            <!--begin::Teames-->
            <!--end::Teames-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Sidebar-->
