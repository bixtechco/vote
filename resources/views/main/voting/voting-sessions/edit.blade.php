@extends('main.layouts.admin', [ 'pageTitle' => "Edit Voting Session" ])

@section('content')
    <div class="row p-5">
        <div class="col-lg-12">
            @component('main.components.portlet', [
                'headText' => "Edit Voting Session #{$votingSession->name}",                'headIcon' => 'flaticon-user',
                'formAction' => route('main.voting.voting-sessions.update', ['id' => $association->id, 'votingSession' => $votingSession->id]),
                'formFiles' => true,
                'formMethod' => 'patch',
                'backUrl' => route('main.voting.voting-sessions.list', ['id' => $association->id]),
            ])

                <div class="card p-5 row justify-content-center align-content-center">
                    <div class="col-md-9">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Name *</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="name"
                                   value="{{ old('name', $votingSession->name) }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'name' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Description</label>
                            <!--end::Label-->
                            <textarea id="editor" class="form-control form-control-solid"
                                      name="description">{{ old('description', $votingSession->description) }}</textarea>
                            @include('main.components.form-control-feedback', [ 'field' => 'description' ])
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Year</label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" name="year"
                                   value="{{ old('year', $votingSession->year) }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'year' ])
                        </div>
                        <!--end::Input group-->
                        <div class="repeater">
                            <div data-repeater-list="role_candidate_ids">
                                @foreach(json_decode($votingSession->role_candidate_ids, true) as $positionName => $candidateIds)
                                    <div data-repeater-item>
                                        <div class="d-flex flex-column mb-7 fv-row">
                                            <label class="required fs-6 fw-semibold form-label mb-2">Position Name
                                                *</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   name="role_candidate_ids[][position_name]"
                                                   value="{{ $positionName }}">
                                            @include('main.components.form-control-feedback', [ 'field' => 'position_name' ])
                                        </div>
                                        <div class="d-flex flex-column mb-7 fv-row">
                                            <label class="required fs-6 fw-semibold form-label mb-2">Users *</label>
                                            <select class="form-control form-control-solid"
                                                    name="role_candidate_ids[][candidate_ids]"
                                                    multiple="multiple">
                                                @foreach($users as $user)
                                                    <option value="{{ $user->user_id }}"
                                                            {{ in_array($user->user_id, $candidateIds) ? 'selected' : '' }}>
                                                        {{ $user->member->profile->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @include('main.components.form-control-feedback', [ 'field' => 'candidate_ids' ])
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                            <button data-repeater-delete type="button" class="btn btn-danger">Delete
                                            </button>
                                            <button data-repeater-create type="button" class="btn btn-primary">Add
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Start Date</label>
                            <!--end::Label-->
                            <input type="date" class="form-control form-control-solid" name="start_date"
                                   value="{{ old('start_date', date('Y-m-d', strtotime($votingSession->start_date))) }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'start_date' ])
                        </div>

                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">End Date</label>
                            <!--end::Label-->
                            <input type="date" class="form-control form-control-solid" name="end_date"
                                   value="{{ old('end_date', date('Y-m-d', strtotime($votingSession->end_date))) }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'end_date' ])
                        </div>


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script>
        CKEDITOR.replace('editor');

        $(document).ready(function () {
            function initializeRepeater() {
                $('.repeater').repeater({
                    initEmpty: false,
                    defaultValues: {
                        'position_name': '',
                        'user_ids': ''
                    },
                    show: function () {
                        $(this).slideDown();
                    },
                    hide: function (deleteElement) {
                        if (confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    },
                });
            }

            initializeRepeater();

            $('.repeater').on('click', '[data-repeater-create]', function(){
                initializeRepeater();
            });
        });
    </script>
@endpush
