<div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
<!--begin::Header main-->
    <div class="d-flex flex-stack flex-grow-1">
        @include(config('settings.KT_THEME_LAYOUT_MAIN').'/admin-header-brand')
        <!--begin::Navbar-->
        @include(config('settings.KT_THEME_LAYOUT_MAIN').'/admin-header-menu')
    </div>
    <!--begin::Separator-->
{{--    <div class="app-header-separator"></div>--}}
    <!--end::Separator-->
</div>
<!--end::Header-->


