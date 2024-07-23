@extends('main.layouts.admin', [ 'pageTitle' => "View Association Members of Association #{$association->id}" ])

@section('content')
    @section('title')
        Members Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.users.list') }}
    @endsection

    @include('main.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

    <div class="card p-5">
        @component('main.components.portlet', [
                    'headText' => 'View Association Members',
                    'headIcon' => 'flaticon-user',
                    'backUrl' => route('main.voting.associations.list'),
                ])
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        Members Overview
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card toolbar-->
                <div class="card-toolbar align-self-end">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        @if(auth()->user()->associations()->where('id', $association->id)->first()->pivot->is_admin)
                            <!--begin::Add user-->
                            <a href="{{ route('main.voting.associations.show-add-member', ['id' => $association->id]) }}"
                               class="btn btn-primary mr-3">
                                {!! getIcon('plus', 'fs-2', '', 'i') !!}
                                New Member
                            </a>

                            <form id="importEmailsForm"
                                  action="{{ route('main.voting.associations.import-members', ['id' => $association->id]) }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" class="form-control d-none" id="import" name="import" accept=".xlsx,.xls">
                                <button type="button" class="btn btn-primary" id="showFileInputButton">Import Emails</button>
                            </form>

                        @endif
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-striped gy-7 gs-7">
                        <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            @if(auth()->user()->associations()->where('id', $association->id)->first()->pivot->is_admin)
                                <th>Actions</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($members as $member)
                            @php
                                $deleteUserFormId = "delete-user-{$member->id}-form";
                                $setAdminFormId = "set-admin-{$member->id}-form";
                                $removeAdminFormId = "remove-admin-{$member->id}-form";
                            @endphp
                            <tr>
                                <td>{{$member->member->profile->full_name}}</td>
                                <td>{{$member->member->email}}</td>
                                <td>
                                    @if($member->is_admin)
                                        <span class="badge badge-success">Admin</span>
                                    @else
                                        <span class="badge badge-primary">Member</span>
                                    @endif
                                </td>
                                <td>
                                    @if(auth()->user()->associations()->where('id', $association->id)->first()->pivot->is_admin)
                                        @if(!$member->is_admin)
                                            <button
                                                    class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                    title="Delete"
                                                    onclick="confirmAction('Delete', 'Are you sure you want to remove this user?', '{{ $deleteUserFormId }}')"
                                            >
                                                <i class="la la-trash"></i>
                                            </button>
                                            <form
                                                    id="{{ $deleteUserFormId }}"
                                                    class="m-form d-none"
                                                    method="post"
                                                    action="{{ route('main.voting.associations.remove-member', [ 'id' => $association->id , 'member' => $member->id]) }}"
                                                    data-confirm="true"
                                                    data-confirm-type="delete"
                                                    data-confirm-title="Delete <strong>{{ $member->name }}</strong>"
                                                    data-confirm-text="You are about to delete this user, this procedure is irreversible."
                                            >
                                                @method('delete')
                                                @csrf
                                            </form>
                                            <button
                                                    class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                    title="Set Admin"
                                                    onclick="confirmAction('Set Admin', 'Are you sure you want to set this user as admin?', '{{ $setAdminFormId }}')"
                                            >
                                                <i class="la la-user"></i>
                                            </button>
                                            <form
                                                    id="{{ $setAdminFormId }}"
                                                    class="m-form d-none"
                                                    method="post"
                                                    action="{{ route('main.voting.associations.set-admin', [ 'id' => $association->id , 'memberId' => $member->user_id]) }}"
                                                    data-confirm="true"
                                                    data-confirm-type="delete"
                                                    data-confirm-title="Set <strong>{{ $member->name }} as admin?</strong>"
                                                    data-confirm-text="You are about to set this user as admin."
                                            >
                                                @method('post')
                                                @csrf
                                            </form>
                                        @endif
                                    @endif
                                    @php
                                        $creator = $association->associationMembers()->orderBy('created_at', 'asc')->first();
                                    @endphp

                                    @if(auth()->user()->associations()->where('id', $association->id)->first()->pivot->is_admin)
                                        @if($member->is_admin && $member->id !== $creator->id)
                                            <button
                                                    class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                    title="Remove Admin Role"
                                                    onclick="confirmAction('Remove Admin Role', 'Are you sure you want to remove this user as admin?', '{{ $removeAdminFormId }}')"
                                            >
                                                <i class="la la-user"></i>
                                            </button>
                                            <form
                                                    id="{{ $removeAdminFormId }}"
                                                    class="m-form d-none"
                                                    method="post"
                                                    action="{{ route('main.voting.associations.remove-admin', ['id' => $association->id, 'memberId' => $member->user_id]) }}"
                                                    data-confirm="true"
                                                    data-confirm-type="delete"
                                                    data-confirm-title="Remove <strong>{{ $member->name }} as admin?</strong>"
                                                    data-confirm-text="You are about to remove this user as admin."
                                            >
                                                @method('post')
                                                @csrf
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @foreach($invitations as $invitation)
                            <tr>
                                <td>Invited User</td>
                                <td>{{ $invitation->email }}</td>
                                <td><span class="badge badge-warning">Invitation Sent</span></td>
                                <td></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>

        @endcomponent
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const showFileInputButton = document.getElementById('showFileInputButton');
            const emailFileInput = document.getElementById('import');
            const importEmailsForm = document.getElementById('importEmailsForm');

            showFileInputButton.addEventListener('click', function () {
                emailFileInput.click();
            });

            emailFileInput.addEventListener('change', function () {
                if (emailFileInput.files.length > 0) {
                    importEmailsForm.submit();
                }
            });
        });
    </script>
@endpush
