@extends('main.layouts.admin', [ 'pageTitle' => "Add a Member to #Associaite {$association->id}" ])

@section('content')
    <div class="row p-5">
        <div class="col-lg-12">
            @component('main.components.portlet', [
                'headText' => 'Association',
                'headIcon' => 'flaticon-user',
                'formAction' => route('main.voting.associations.add-member', ['id' => $association->id]),
                'formFiles' => true,
                'formMethod' => 'post',
                'backUrl' => route('main.voting.associations.view-members', ['id' => $association->id]),
            ])

                <div class="card p-5 row justify-content-center align-content-center">
                    <div class="col-md-9">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">Email</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="email" value="{{ old('email') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'email' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">Principal ID</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="principal_id" value="{{ old('principal_id') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'principal_id' ])
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
