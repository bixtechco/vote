@extends('manage.layouts.admin', [ 'pageTitle' => "Edit Admin #{$user->id}" ])

@section('content')
    <div class="row p-5">
        <div class="col-lg-9">
            @component('manage.components.portlet', [
                'headText' => 'Admin',
                'headIcon' => 'flaticon-user',
                'formAction' => route('manage.people.admins.update', ['id' => $user->id]),
                'formFiles' => true,
                'formMethod' => 'patch',
            ])
                @php
                    $roles = \Src\Auth\Role::getAdminRoles()
                @endphp

                <div class="card p-5 row">
                    <div class="col-md-3 order-md-1 p-5">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                <span class="required">Portrait</span>
                            </label>
                            <!--end::Label-->
                            <div class="file-input-preview file-input-preview--sm mx-auto " data-size-ratio="1">
                                <img src="{{ $user->profile->portrait_url }}" data-placeholder="http://via.placeholder.com/480x480">
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
                            <label class="required fs-6 fw-semibold form-label mb-2">Full name</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="full_name" value="{{ old('full_name', $user->profile->full_name) }}">
                            @include('manage.components.form-control-feedback', [ 'field' => 'full_name' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Email</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="email" value="{{ old('email', $user->email) }}">
                            @include('manage.components.form-control-feedback', [ 'field' => 'email' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Role</label>
                            <!--end::Label-->
                            <div class="row px-3">
                                @foreach($roles as $role)
                                    <div class="form-check form-check-custom form-check-primary form-check-solid form-check-sm col-sm-6">
                                        <input class="form-check-input" 
                                        type="radio"
                                        name="role"
                                        class="form_admin_role"
                                        value="{{ $role->name }}"
                                        id="{{$role->name}}"
                                        {{ old('role', $user->role->name) === $role->name ? 'checked' : '' }}>
                        
                                        <!--begin::Label-->
                                        <label class="form-check-label text-gray-700 fw-bold text-nowrap" for="{{$role->name}}">{{ $role->name }}</label>
                                        <!--end::Label-->
                                    </div>
                                @endforeach
                            </div>
                            @include('manage.components.form-control-feedback', [ 'field' => 'role' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Admin Abilities</label>
                            <!--end::Label-->
                            <div class="row px-3">
                                @foreach($abilities as $ability)
                                    <div class="form-check form-check-custom form-check-primary form-check-solid form-check-sm mb-3 col-sm-6">
                                        <input class="form-check-input"
                                        type="checkbox"
                                        name="abilities[]"
                                        value="{{ $ability }}"
                                        id="{{ $ability }}"
                                        {{ old('abilities') !== null && in_array($ability, old('abilities')) ? 'checked' : '' }}
                                        >                    
                                        <label class="form-check-label text-gray-700 fw-bold text-nowrap text-capitalize" for="{{ $ability }}">{{ $ability }}</label>
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
