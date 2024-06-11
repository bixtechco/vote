@extends('manage.layouts.app')
@section('page')
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            @include('manage/layouts/admin-header')
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                @include('manage/layouts/admin-aside')
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Toolbar-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    <!--end::Content wrapper-->
                    @include('manage/layouts/admin-footer')
                </div>
                <!--end:::Main-->
                <!--begin::aside-->
                {{-- <div id="kt_app_aside" class="app-aside flex-column" data-kt-drawer="true" data-kt-drawer-name="app-aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_aside_mobile_toggle">
                    <!--begin::Wrapper-->
                    <div id="kt_app_aside_wrapper" class="d-flex flex-column align-items-center hover-scroll-y mt-lg-n3 py-5 py-lg-0 gap-4" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_aside_wrapper" data-kt-scroll-offset="5px">
                        <a href="apps/calendar.html" class="btn btn-icon btn-color-primary bg-hover-body h-45px w-45px flex-shrink-0" data-bs-toggle="tooltip" title="Calendar" data-bs-custom-class="tooltip-inverse">
                            <i class="ki-outline ki-calendar fs-2x"></i>
                        </a>
                        <a href="account/overview.html" class="btn btn-icon btn-color-warning bg-hover-body h-45px w-45px flex-shrink-0" data-bs-toggle="tooltip" title="Profile" data-bs-custom-class="tooltip-inverse">
                            <i class="ki-outline ki-address-book fs-2x"></i>
                        </a>
                        <a href="apps/ecommerce/catalog/products.html" class="btn btn-icon btn-color-success bg-hover-body h-45px w-45px flex-shrink-0" data-bs-toggle="tooltip" title="Messages" data-bs-custom-class="tooltip-inverse">
                            <i class="ki-outline ki-tablet-ok fs-2x"></i>
                        </a>
                        <a href="apps/inbox/listing.html" class="btn btn-icon btn-color-dark bg-hover-body h-45px w-45px flex-shrink-0" data-bs-toggle="tooltip" title="Products" data-bs-custom-class="tooltip-inverse">
                            <i class="ki-outline ki-calendar-add fs-2x"></i>
                        </a>
                    </div>
                    <!--end::Wrapper-->
                </div> --}}
                <!--end::aside-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

{{--    <!--begin::Scrolltop-->--}}
{{--    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">{!! getIcon('arrow-up', '') !!}</div>--}}
{{--    <!--end::Scrolltop-->--}}


@endsection
