@extends('main.layouts.admin', [ 'pageTitle' => "Create Association" ])

@section('content')
    <div class="row p-5">
        <div class="col-lg-12">
            @component('main.components.portlet', [
                'headText' => 'Association',
                'headIcon' => 'flaticon-user',
                'formAction' => route('main.voting.associations.store'),
                'formFiles' => true,
                'formMethod' => 'post',
                'backUrl' => route('main.voting.associations.list'),
            ])

                <div class="card p-5 row justify-content-center align-content-center">
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
                            <textarea id="editor" class="form-control form-control-solid" name="description">{{ old('description') }}</textarea>
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
@push('scripts')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endpush
