@extends('main.layouts.admin')

@section('content')
    @section('title')
        Associations Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.users.list') }}
    @endsection

    @include('main.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

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
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $statusBadgeMap = [
                            Src\Voting\Association::STATUS_ACTIVE => 'success',
                            Src\Voting\Association::STATUS_INACTIVE => 'danger',
                        ];
                    @endphp
                    @foreach($associations as $association)
                        @php
                            $banUserFormId = "ban-user-{$association->id}-form";
                            $unbanUserFormId = "unban-user-{$association->id}-form";
                            $deleteUserFormId = "delete-user-{$association->id}-form";
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('main.voting.associations.show', [ 'id' => $association->id ]) }}">{{ $association->name }}</a>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                {!! $association->description !!}
                            </td>
                            @php
                            $creator = \Src\People\User::find($association->created_by);
                            @endphp
                            <td style="text-align: center; vertical-align: middle;">
                                {{ $creator->profile->full_name}}
                            </td>
                            @php
                            $updater = \Src\People\User::find($association->updated_by);
                            @endphp
                            <td style="text-align: center; vertical-align: middle;">
                                {{ $updater->profile->full_name ?? 'N/A' }}
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @component('main.components.badge', [ 'type' => $statusBadgeMap[$association->status] ])
                                    {{ Src\Voting\Association::STATUSES[$association->status]['name'] }}
                                @endcomponent
                            </td>
                            <td>
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('main.voting.associations.edit', ['id' => $association->id]) }}"
                                    title="Edit"
                                >
                                    <i class="la la-edit"></i>
                                </a>
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('main.voting.associations.view-members', ['id' => $association->id]) }}"
                                    title="View All Association Members"
                                >
                                    <i class="la la-users"></i>
                                </a>
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('main.voting.voting-sessions.list', ['id' => $association->id]) }}"
                                    title="View All Voting Sessions"
                                >
                                    <i class="la la-list"></i>
                                </a>
                                @if ($association->isActive())
                                    <button
                                        class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                        title="Inactive"
                                        onclick="confirmAction('Inactive', 'Are you sure you want to inactive this user?', '{{ $banUserFormId }}')"
                                    >
                                        <i class="la la-lock"></i>
                                    </button>
                                    <form
                                        id="{{ $banUserFormId }}"
                                        class="m-form d-none"
                                        method="post"
                                        action="{{ route('main.voting.associations.inactive', [ 'id' => $association->id ]) }}"
                                        data-confirm="true"
                                        data-confirm-type="warning"
                                        data-confirm-title="Inactive <strong>{{ $association->name }}</strong>"
                                        data-confirm-text="You are about to inactive this admin."
                                    >
                                        @method('post')
                                        @csrf
                                    </form>
                                @endif
                                @if ($association->isInactive())
                                    <button
                                        class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                        title="Unban"
                                        onclick="confirmAction('Active', 'Are you sure you want to active this user?', '{{ $unbanUserFormId }}')"
                                    >
                                        <i class="la la-unlock-alt"></i>
                                    </button>
                                    <form
                                        id="{{ $unbanUserFormId }}"
                                        class="m-form d-none"
                                        method="post"
                                        action="{{ route('main.voting.associations.active', [ 'id' => $association->id ]) }}"
                                        data-confirm="true"
                                        data-confirm-type="warning"
                                        data-confirm-title="Active <strong>{{ $association->name }}</strong>"
                                        data-confirm-text="You are about to active this associate."
                                    >
                                        @method('post')
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
                                    action="{{ route('main.voting.associations.destroy', [ 'id' => $association->id ]) }}"
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
