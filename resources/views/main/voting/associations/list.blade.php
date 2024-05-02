@extends('main.layouts.admin')

@section('content')
    @section('title')
        Associations Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.users.list') }}
    @endsection

    @include('metronic.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search"
                           class="form-control form-control-solid w-250px ps-13" placeholder="Search association"
                           id="mySearchInput"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar align-self-end">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
                    <a href="{{ route('main.voting.associations.create') }}" class="btn btn-primary">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        New Associate
                    </a>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                <table class="table table-striped gy-7 gs-7">
                    <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th colspan="2">Name</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $statusBadgeMap = [
                            Src\People\User::STATUS_ACTIVE => 'success',
                            Src\People\User::STATUS_BANNED => 'danger',
                        ];
                    @endphp
                    @foreach($associations as $association)
                        @php
                            $banUserFormId = "ban-user-{$association->id}-form";
                            $unbanUserFormId = "unban-user-{$association->id}-form";
                            $deleteUserFormId = "delete-user-{$association->id}-form";
                        @endphp
                        <tr>
{{--                            <td width="48">--}}
{{--                                <img class="m--img-rounded" src="{{ $association->portrait->url }}" width="48" height="48">--}}
{{--                            </td>--}}
                            <td>
{{--                                <a href="{{ route('main.voting.associations.show', [ 'id' => $association->id ]) }}">{{ $association->name }}</a>--}}
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                {{ $association->description }}
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                {{ $association->created_by ?? 'N/A' }}
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                {{ $association->updated_by ?? 'N/A' }}
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @component('metronic.components.badge', [ 'type' => $statusBadgeMap[$association->status] ])
                                    {{ $association->status }}
                                @endcomponent
                            </td>
                            <td>
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.account.profile.edit') }}"
                                    title="Edit"
                                >
                                    <i class="la la-edit"></i>
                                </a>
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.people.users.edit-password', ['id' => $association->id]) }}"
                                    title="Change Password"
                                >
                                    <i class="la la-key"></i>
                                </a>
                                @if ($association->isActive())
                                    <button
                                        class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                        title="Ban"
                                        onclick="confirmAction('Ban', 'Are you sure you want to ban this user?', '{{ $banUserFormId }}')"
                                    >
                                        <i class="la la-lock"></i>
                                    </button>
                                    <form
                                        id="{{ $banUserFormId }}"
                                        class="m-form d-none"
                                        method="post"
                                        action="{{ route('manage.people.users.ban', [ 'id' => $association->id ]) }}"
                                        data-confirm="true"
                                        data-confirm-type="warning"
                                        data-confirm-title="Ban <strong>{{ $association->name }}</strong>"
                                        data-confirm-text="You are about to ban this admin."
                                    >
                                        @method('post')
                                        @csrf
                                    </form>
                                @endif
                                @if ($association->isBanned())
                                    <button
                                        class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                        title="Unban"
                                        onclick="confirmAction('Unban', 'Are you sure you want to unban this user?', '{{ $unbanUserFormId }}')"
                                    >
                                        <i class="la la-unlock-alt"></i>
                                    </button>
                                    <form
                                        id="{{ $unbanUserFormId }}"
                                        class="m-form d-none"
                                        method="post"
                                        action="{{ route('manage.people.users.unban', [ 'id' => $association->id ]) }}"
                                        data-confirm="true"
                                        data-confirm-type="warning"
                                        data-confirm-title="Unban <strong>{{ $association->name }}</strong>"
                                        data-confirm-text="You are about to unban this admin."
                                    >
                                        @method('delete')
                                        @csrf
                                    </form>
                                @endif
                                <button
                                    class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                    title="Delete"
                                    onclick="confirmAction('Delete', 'Are you sure you want to delete this user?', '{{ $deleteUserFormId }}')"
                                >
                                    <i class="la la-trash"></i>
                                </button>
                                <form
                                    id="{{ $deleteUserFormId }}"
                                    class="m-form d-none"
                                    method="post"
                                    action="{{ route('manage.people.users.destroy', [ 'id' => $association->id ]) }}"
                                    data-confirm="true"
                                    data-confirm-type="delete"
                                    data-confirm-title="Delete <strong>{{ $association->name }}</strong>"
                                    data-confirm-text="You are about to delete this admin, this procedure is irreversible."
                                >
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
@endsection
