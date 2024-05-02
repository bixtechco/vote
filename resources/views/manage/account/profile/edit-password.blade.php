@extends('manage.layouts.admin', [ 'pageTitle' => "Edit Password" ])

@section('content')
    <div class="row p-5">
        <div class="col-lg-9">
            @component('manage.components.portlet', [
                'headText' => 'Password',
                'headIcon' => 'flaticon-lock',
                'formAction' => route('manage.account.profile.update-password'),
                'formMethod' => 'patch',
            ])
                <div class="card p-5 row">
                    <div class="col-md-9 p-5">
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
