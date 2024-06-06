@extends('main.layouts.admin', [
    'pageTitle' => 'Your personal info',
    'pageSubtitle' => 'Manage your basic information — your name, email, and phone number — to help others find you on IPM, and make it easier to get in touch.'
])

@section('content')
    <div class="row">
        <div class="col-lg-9">
            @component('main.components.portlet', [
                'headText' => 'User',
                'headIcon' => 'flaticon-user',
                'formAction' => route('main.account.profile.update'),
                'formFiles' => true,
                'formMethod' => 'patch',
            ])
                <div class="card p-5 row">
{{--                    <div class="col-md-12 order-md-1">--}}
{{--                        <!--begin::Input group-->--}}
{{--                        <div class="d-flex flex-column mb-7 fv-row">--}}
{{--                            <!--begin::Label-->--}}
{{--                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">--}}
{{--                                <span class="required">Portrait</span>--}}
{{--                            </label>--}}
{{--                            <!--end::Label-->--}}
{{--                            <div class="file-input-preview file-input-preview--sm mx-auto " data-size-ratio="1">--}}
{{--                                <img src="{{ $user->portrait->url }}" data-placeholder="http://via.placeholder.com/480x480">--}}
{{--                            </div>--}}
{{--                            <input type="file" class="form-control form-control-solid" name="portrait" accept="image/gif, image/jpeg, image/png" data-file-preview>--}}
{{--                            @include('manage.components.form-control-feedback', [ 'field' => 'portrait' ])--}}
{{--                        </div>--}}
{{--                        <!--end::Input group-->--}}
{{--                    </div>--}}
                    <div class="col-md-9">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Full name</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="full_name" value="{{ old('full_name', $user->profile->full_name ?? '') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'full_name' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Email</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="email" value="{{ old('email', $user->email ?? '') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'email' ])
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>

                @slot('formActionsLeft')
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
