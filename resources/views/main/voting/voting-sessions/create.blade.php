@extends('main.layouts.admin', [ 'pageTitle' => "Create Association" ])

@section('content')
    <div class="row p-5">
        <div class="col-lg-12">
            @component('main.components.portlet', [
                'headText' => 'Create a Voting Session',
                'headIcon' => 'flaticon-user',
                'formAction' => route('main.voting.voting-sessions.store', ['id' => $association->id]),
                'formFiles' => true,
                'formMethod' => 'post',
                'backUrl' => route('main.voting.voting-sessions.list', ['id' => $association->id]),
            ])

                <div class="card p-5 row justify-content-center align-content-center">
                    <div class="col-md-9">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="required fs-6 fw-semibold form-label mb-2">Name *</label>
                            <input type="text" class="form-control form-control-solid" name="name"
                                   value="{{ old('name') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'name' ])
                        </div>
                        <!--end::Input group-->

                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="required fs-6 fw-semibold form-label mb-2">Description</label>
                            <textarea id="editor" class="form-control form-control-solid"
                                      name="description">{{ old('description') }}</textarea>
                            @include('main.components.form-control-feedback', [ 'field' => 'description' ])
                        </div>
                        <!--end::Input group-->

                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="required fs-6 fw-semibold form-label mb-2">Year</label>
                            <input type="text" class="form-control form-control-solid" name="year"
                                   value="{{ old('year') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'year' ])
                        </div>
                        <!--end::Input group-->

                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="required fs-6 fw-semibold form-label mb-2">Start Date</label>
                            <input type="date" class="form-control form-control-solid" name="start_date"
                                   value="{{ old('start_date') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'start_date' ])
                        </div>

                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="required fs-6 fw-semibold form-label mb-2">End Date</label>
                            <input type="date" class="form-control form-control-solid" name="end_date"
                                   value="{{ old('end_date') }}">
                            @include('main.components.form-control-feedback', [ 'field' => 'end_date' ])
                        </div>
                        <hr>

                        <div class="repeater">
                            <div data-repeater-list="role_candidate_ids">
                                <div data-repeater-item>
                                    <div class="card p-3 mb-3">
                                        <div class="d-flex flex-column mb-7 fv-row">
                                            <label class="required fs-6 fw-semibold form-label mb-2">Position Name
                                                *</label>
                                            <input type="text" class="form-control form-control-solid position_name"
                                                   name="role_candidate_ids[][position_name]"
                                                   value="{{ old('position_name') }}">
                                            @include('main.components.form-control-feedback', [ 'field' => 'position_name' ])
                                        </div>
                                        <div class="d-flex flex-column mb-7 fv-row">
                                            <label class="required fs-6 fw-semibold form-label mb-2">Users *</label>
                                            <select class="form-control form-control-solid select2 candidate_ids"
                                                    name="role_candidate_ids[][candidate_ids][]" multiple="multiple">
                                                <option value="">====Please Select====</option>
                                                @foreach($users as $user)
                                                    <option
                                                        value="{{ $user->user_id }}">{{ $user->member->profile->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @include('main.components.form-control-feedback', [ 'field' => 'candidate_ids' ])
                                        </div>
                                        <div class="d-flex flex-column mb-7 fv-row">
                                            <label class="required fs-6 fw-semibold form-label mb-2">Number of Winners
                                                *</label>
                                            <input type="number" class="form-control form-control-solid winner_qty"
                                                   name="role_candidate_ids[][winner_qty]"
                                                   value="{{ old('winner_qty', 1) }}" min="1">
                                            @include('main.components.form-control-feedback', [ 'field' => 'winner_qty' ])
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                            <button data-repeater-delete type="button" class="btn btn-danger">Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button data-repeater-create type="button" class="btn btn-primary">Add</button>
                            </div>
                        </div>

                    </div>
                    @slot('formActionsLeft')
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    @endslot
                </div>
            @endcomponent
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        CKEDITOR.replace('editor');

        $(document).ready(function () {
            function initializeSelect2(container) {
                container.find('.select2').each(function () {
                    var $this = $(this);
                    if ($this.data('select2')) {
                        $this.select2('destroy');
                    }
                    $this.select2();
                });
            }

            function initializeRepeater(repeaterElement) {
                repeaterElement.repeater({
                    initEmpty: false,
                    defaultValues: {
                        'position_name': '',
                        'candidate_ids': [],
                    },
                    show: function () {
                        $(this).slideDown();
                        initializeSelect2($(this));
                    },
                    hide: function (deleteElement) {
                        if (confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    },
                    isFirstItemUndeletable: true
                });
            }

            $('.repeater').each(function () {
                initializeRepeater($(this));
            });

            initializeSelect2($(document));

            $(document).on('click', '[data-repeater-create]', function () {
                var repeater = $(this).closest('.repeater');
                setTimeout(function () {
                    initializeSelect2(repeater);
                }, 100);
            });
        });
    </script>
@endpush
