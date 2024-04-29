@extends('metronic.layouts.admin', [
    'pageTitle' => 'Add Admin',
    'pageSubtitle' => 'Manage your basic information — your name, email, and phone number — to help others find you on IPM, and make it easier to get in touch.'
])

@section('content')
    <div class="row p-5">
        <div class="col-lg-9">
            @component('metronic.components.portlet', [
                'headText' => 'Admin',
                'headIcon' => 'flaticon-user',
                'formAction' => route('manage.people.admins.store'),
                'formFiles' => true,
                'formId' => 'form_create_admin'
            ])
                @php
                    $roles = \Src\Auth\Role::getAdminRoles()
                @endphp

                <div class="row">
                    <div class="col-md-3 order-md-1">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                <span class="required">Portrait</span>
                            </label>
                            <!--end::Label-->
                            <div class="file-input-preview file-input-preview--sm mx-auto " data-size-ratio="1">
                                <img src="http://via.placeholder.com/480x480" data-placeholder="http://via.placeholder.com/480x480">
                            </div>
                            <input type="file" class="form-control form-control-solid" name="portrait" accept="image/gif, image/jpeg, image/png" data-file-preview>
                            @include('manage.components.form-control-feedback', [ 'field' => 'portrait' ])
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="col-md-9">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Full name *</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="full_name" value="{{ old('full_name') }}">
                            @include('manage.components.form-control-feedback', [ 'field' => 'full_name' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Email *</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="email" value="{{ old('email') }}">
                            @include('manage.components.form-control-feedback', [ 'field' => 'email' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Role *</label>
                            <!--end::Label-->
                            <div class="m-radio-inline">
                                @foreach($roles as $role)
                                    <label class="m-radio m-radio--solid m-radio--brand">
                                        <input
                                            type="radio"
                                            name="role"
                                            class="form_admin_role"
                                            value="{{ $role->name }}"
                                            {{ old('role', $loop->first ? $role->name : null) === $role->name ? 'checked' : '' }}
                                        >
                                        {{ $role->name }}
                                        <span></span>
                                    </label>
                                @endforeach
                            </div>
                            @include('manage.components.form-control-feedback', [ 'field' => 'role' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">New Password *</label>
                            <!--end::Label-->
                            <input type="password" class="form-control form-control-solid" name="password">
                            <p class="m-form__help">Your password must be at least 8 characters long. To make it stronger, use upper and lower case letters, numbers and symbols. Space( ), quote(\', ") and slash(\) aren't allowed.</p>
                            @include('manage.components.form-control-feedback', [ 'field' => 'password' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Password Confirmation *</label>
                            <!--end::Label-->
                            <input type="password" class="form-control form-control-solid" name="password_confirmation">
                            <p class="m-form__help">Retype the new password you entered.</p>
                            @include('manage.components.form-control-feedback', [ 'field' => 'password_confirmation' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Admin Abilities *</label>
                            <!--end::Label-->
                            <div class="row">
                                @foreach($abilities as $ability)
                                    <div class="col-sm-4 m-form__group-sub">
                                        <input
                                            type="checkbox"
                                            name="abilities[]"
                                            value="{{ $ability }}"
                                            id="{{ $ability }}"
                                            {{ old('abilities') !== null && in_array($ability, old('abilities')) ? 'checked' : '' }}
                                        >
                                        <label class="form-control-label capitalize" for="{{ $ability }}">{{ $ability }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @include('manage.components.form-control-feedback', [ 'field' => 'abilities' ])
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
