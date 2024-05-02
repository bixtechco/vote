@extends('main.layouts.admin', [ 'pageTitle' => "Create Association" ])

@section('content')
    <div class="row p-5">
        <div class="col-lg-9">
            @component('main.components.portlet', [
                'headText' => 'Association',
                'headIcon' => 'flaticon-user',
                'formAction' => route('main.voting.associations.store'),
                'formFiles' => true,
                'formMethod' => 'post',
            ])

                <div class="card p-5 row">
                    <div class="col-md-9">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Name *</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'name' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Description</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="description" value="{{ old('description') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'description' ])
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
