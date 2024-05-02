@extends('main.layouts.admin', [ 'pageTitle' => "Edit Association #{$association->id}" ])

@section('content')
    <div class="row p-5">
        <div class="col-lg-9">
            @component('main.components.portlet', [
                'headText' => 'Association',
                'headIcon' => 'flaticon-user',
                'formAction' => route('main.voting.associations.update', ['id' => $association->id]),
                'formFiles' => true,
                'formMethod' => 'patch',
            ])

                <div class="card p-5 row">
{{--                    <div class="col-md-3 order-md-1 p-5">--}}
{{--                        <!--begin::Input group-->--}}
{{--                        <div class="d-flex flex-column mb-7 fv-row">--}}
{{--                            <!--begin::Label-->--}}
{{--                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">--}}
{{--                                <span class="required">Portrait</span>--}}
{{--                            </label>--}}
{{--                            <!--end::Label-->--}}
{{--                            <div class="file-input-preview file-input-preview--sm mx-auto " data-size-ratio="1">--}}
{{--                                <img src="{{ $association->profile->portrait_url }}" data-placeholder="http://via.placeholder.com/480x480">--}}
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
                            <label class="required fs-6 fw-semibold form-label mb-2">Name *</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $association->name) }}">
                            @include('manage.components.form-control-feedback', [ 'field' => 'name' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Description</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="description" value="{{ old('description', $association->description) }}">
                            @include('manage.components.form-control-feedback', [ 'field' => 'description' ])
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
