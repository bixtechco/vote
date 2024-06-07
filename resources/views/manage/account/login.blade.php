@extends('manage.layouts.app', [ 'pageTitle' => 'Login' ])

@section('page')
        <!--begin::App-->
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">
                <!--begin::Body-->
                <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                    <!--begin::Form-->
                    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                        <!--begin::Wrapper-->
                        <div class="w-lg-500px p-10">
                            <!--begin::Page-->
                            <!--begin::Form-->
                            <form method="POST" class="form w-100" id="kt_sign_in_form" data-kt-redirect-url="{{ route('manage.dashboard') }}"  action="{{ route('manage.account.login') }}">
                                @csrf
                                <!--begin::Heading-->
                                <div class="text-center mb-11">
                                    <!--begin::Title-->
                                    <h1 class="text-gray-900 fw-bolder mb-3">
                                        Sign In
                                    </h1>
                                    <!--end::Title-->

                                    <!--begin::Subtitle-->
                                    <div class="text-gray-500 fw-semibold fs-6">
                                        ADMIN ACCESS
                                    </div>
                                    <!--end::Subtitle--->
                                </div>
                                <!--begin::Heading-->

                                <!--begin::Input group--->
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <input
                                        class="form-control bg-transparent"
                                        type="text"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="Email"
                                        autocomplete="off"
                                        autofocus
                                    >
                                    <!--end::Email-->
                                </div>

                                <!--end::Input group--->
                                <div class="fv-row mb-3">
                                    <!--begin::Password-->
                                    <input
                                        class="form-control bg-transparent"
                                        type="password"
                                        name="password"
                                        placeholder="Password"
                                    >
                                    <!--end::Password-->
                                </div>
                                <!--end::Input group--->

                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                    <div class="col">
                                        <label class="m-checkbox m-checkbox--focus">
                                            <input
                                                type="checkbox"
                                                name="remember"
                                                {{ old('remember') ? 'checked' : '' }}
                                            >
                                            Remember me
                                            <span class="m-checkbox__indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Submit button-->
                                <div class="d-grid mb-10">
                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                        Sign In
                                    </button>
                                </div>
                                <!--end::Submit button-->
                            </form>
                            <!--end::Form-->
                            <!--end::Page-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Form-->

                    <!--begin::Footer-->
                    <div class="d-flex flex-center flex-wrap px-5">
                        <!--begin::Links-->
                        <div class="d-flex fw-semibold text-primary fs-base">
                            <a href="#" class="px-5" target="_blank">Terms</a>

                            <a href="#" class="px-5" target="_blank">Plans</a>

                            <a href="#" class="px-5" target="_blank">Contact Us</a>
                        </div>
                        <!--end::Links-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Body-->

                <!--begin::Aside-->
                <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{ image('misc/auth-img.png') }})">
                    {{-- <!--begin::Content-->
                    <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                        <!--begin::Logo-->
                        <a href="{{ route('manage.dashboard') }}" class="mb-12">
                            <img alt="Logo" src="{{ image('logos/custom-1.png') }}" class="h-60px h-lg-75px"/>
                        </a>
                        <!--end::Logo-->

                        <!--begin::Image-->
                        <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{ image('misc/auth-screens.png') }}" alt=""/>
                        <!--end::Image-->

                        <!--begin::Title-->
                        <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                            Fast, Efficient and Productive
                        </h1>
                        <!--end::Title-->

                        <!--begin::Text-->
                        <div class="d-none d-lg-block text-white fs-base text-center">
                            In this kind of post, <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>

                            introduces a person they’ve interviewed <br/> and provides some background information about

                            <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>
                            and their <br/> work following this is a transcript of the interview.
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Content--> --}}
                </div>
                <!--end::Aside-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::App-->
@endsection

@section('style')
    <link href="{{ asset('manage/app.css') }}" rel="stylesheet">
@stop
