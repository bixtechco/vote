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
                            <a class="menu-link active" href="{{ route('manage.dashboard') }}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">Default</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <div class="menu-item">
                            <div class="menu-content">
                                <a class="btn btn-flex btn-color-primary d-flex flex-stack fs-base p-0 ms-2 mb-2 toggle collapsible collapsed"
                                   data-bs-toggle="collapse" href="#kt_app_sidebar_menu_dashboards_collapse"
                                   data-kt-toggle-text="Show Less">
                                    <span data-kt-toggle-text-target="true">Show 12 More</span>
                                    <i class="ki-outline ki-minus-square toggle-on fs-2 me-0"></i>
                                    <i class="ki-outline ki-plus-square toggle-off fs-2 me-0"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
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
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <span class="menu-link">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Users</span>
													<span class="menu-arrow"></span>
												</span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{route('manage.people.users.list')}}">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
                                        <span class="menu-title">User List</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link" href="{{route('manage.people.admins.list')}}">
															<span class="menu-bullet">
																<span class="bullet bullet-dot"></span>
															</span>
                                        <span class="menu-title">Admin list</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->

                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            </div>
            <!--end::Sidebar menu-->
            <!--begin::Teames-->
            <div class="app-sidebar-menu-secondary menu menu-rounded menu-column px-3">
                <!--begin::Heading-->
                <div class="menu-item menu-labels">
                    <div class="menu-content d-flex flex-stack fw-bold text-gray-600 text-uppercase fs-7">
                        <span class="menu-heading ps-1">Labels</span>
                        <!--begin::Link-->
                        <a class="menu-btn ps-2" href="authentication/layouts/corporate/sign-in.html">
                            <i class="ki-outline ki-plus-square fs-2 text-success"></i>
                        </a>
                        <!--end::Link-->
                    </div>
                </div>
                <!--end::Heading-->
                <!--begin::Separator-->
                <div class="app-sidebar-separator separator mx-4 mt-2 mb-2"></div>
                <!--end::Separator-->
                <!--begin::Menu Item-->
                <div class="menu-item">
                    <!--begin::Menu link-->
                    <a class="menu-link" href="apps/projects/project.html">
                        <!--begin::Bullet-->
                        <span class="menu-icon ps-2">
												<span class="bullet bullet-dot h-10px w-10px bg-primary"></span>
											</span>
                        <!--end::Bullet-->
                        <!--begin::Title-->
                        <span class="menu-title text-gray-700 fw-bold fs-6">Google Ads</span>
                        <!--end::Title-->
                        <!--begin::Badge-->
                        <span class="menu-badge">
												<span class="badge badge-secondary">6</span>
											</span>
                        <!--end::Badge-->
                    </a>
                    <!--end::Menu link-->
                </div>
                <!--end::Menu Item-->
                <!--begin::Menu Item-->
                <div class="menu-item">
                    <!--begin::Menu link-->
                    <a class="menu-link" href="apps/projects/project.html">
                        <!--begin::Bullet-->
                        <span class="menu-icon ps-2">
												<span class="bullet bullet-dot h-10px w-10px bg-success"></span>
											</span>
                        <!--end::Bullet-->
                        <!--begin::Title-->
                        <span class="menu-title text-gray-700 fw-bold fs-6">AirStoke App</span>
                        <!--end::Title-->
                        <!--begin::Badge-->
                        <span class="menu-badge">
												<span class="badge badge-secondary">2</span>
											</span>
                        <!--end::Badge-->
                    </a>
                    <!--end::Menu link-->
                </div>
                <!--end::Menu Item-->
                <!--begin::Menu Item-->
                <div class="menu-item">
                    <!--begin::Menu link-->
                    <a class="menu-link" href="apps/projects/project.html">
                        <!--begin::Bullet-->
                        <span class="menu-icon ps-2">
												<span class="bullet bullet-dot h-10px w-10px bg-warning"></span>
											</span>
                        <!--end::Bullet-->
                        <!--begin::Title-->
                        <span class="menu-title text-gray-700 fw-bold fs-6">Internal Tasks</span>
                        <!--end::Title-->
                        <!--begin::Badge-->
                        <span class="menu-badge">
												<span class="badge badge-secondary">37</span>
											</span>
                        <!--end::Badge-->
                    </a>
                    <!--end::Menu link-->
                </div>
                <!--end::Menu Item-->
                <!--begin::Menu Item-->
                <div class="menu-item">
                    <!--begin::Menu link-->
                    <a class="menu-link" href="apps/projects/project.html">
                        <!--begin::Bullet-->
                        <span class="menu-icon ps-2">
												<span class="bullet bullet-dot h-10px w-10px bg-danger"></span>
											</span>
                        <!--end::Bullet-->
                        <!--begin::Title-->
                        <span class="menu-title text-gray-700 fw-bold fs-6">Fitnes App</span>
                        <!--end::Title-->
                        <!--begin::Badge-->
                        <span class="menu-badge">
												<span class="badge badge-secondary">4</span>
											</span>
                        <!--end::Badge-->
                    </a>
                    <!--end::Menu link-->
                </div>
                <!--end::Menu Item-->
                <!--begin::Collapsible items-->
                <div class="menu-inner flex-column collapse" id="kt_app_sidebar_menu_projects_collapse">
                    <!--begin::Menu Item-->
                    <div class="menu-item">
                        <!--begin::Menu link-->
                        <a class="menu-link" href="apps/projects/project.html">
                            <!--begin::Bullet-->
                            <span class="menu-icon ps-2">
													<span class="bullet bullet-dot h-10px w-10px bg-info"></span>
												</span>
                            <!--end::Bullet-->
                            <!--begin::Title-->
                            <span class="menu-title text-gray-700 fw-bold fs-6">Oppo CRM</span>
                            <!--end::Title-->
                            <!--begin::Badge-->
                            <span class="menu-badge">
													<span class="badge badge-secondary">12</span>
												</span>
                            <!--end::Badge-->
                        </a>
                        <!--end::Menu link-->
                    </div>
                    <!--end::Menu Item-->
                    <!--begin::Menu Item-->
                    <div class="menu-item">
                        <!--begin::Menu link-->
                        <a class="menu-link" href="apps/projects/project.html">
                            <!--begin::Bullet-->
                            <span class="menu-icon ps-2">
													<span class="bullet bullet-dot h-10px w-10px bg-warning"></span>
												</span>
                            <!--end::Bullet-->
                            <!--begin::Title-->
                            <span class="menu-title text-gray-700 fw-bold fs-6">Finance Dispatch</span>
                            <!--end::Title-->
                            <!--begin::Badge-->
                            <span class="menu-badge">
													<span class="badge badge-secondary">25</span>
												</span>
                            <!--end::Badge-->
                        </a>
                        <!--end::Menu link-->
                    </div>
                    <!--end::Menu Item-->
                </div>
                <!--end::Collapsible items-->
                <!--begin::Collapse toggle-->
                <div class="menu-item">
                    <!--begin::Toggle-->
                    <a class="menu-link menu-collapse-toggle toggle collapsible collapsed" data-bs-toggle="collapse"
                       href="#kt_app_sidebar_menu_projects_collapse" data-kt-toggle-text="Show less">
											<span class="menu-icon ps-2">
												<i class="ki-outline ki-down toggle-off fs-4 text-gray-700 me-0"></i>
												<i class="ki-outline ki-up toggle-on fs-4 text-gray-700 me-0"></i>
											</span>
                        <!--begin::Title-->
                        <span class="menu-title text-gray-600 fw-semibold"
                              data-kt-toggle-text-target="true">Show more</span>
                        <!--end::Title-->
                    </a>
                    <!--end::Toggle-->
                </div>
                <!--end::Collapse toggle-->
            </div>
            <!--end::Teames-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Sidebar-->
