@extends('manage.layouts.admin')

@section('content')

    @component('manage.components.portlet', [
        'headText' => 'Admins',
        'headIcon' => 'flaticon-people',
    ])

    @section('title')
        Admins Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.admins.list') }}
    @endsection
    @include('manage.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6 flex-column">
            <!--begin::Card title-->
            {{-- <form>
               @csrf
            </form> --}}
            <!--begin::Card title-->
            @include('manage.components.table-filter', [ 'target' => 'users-filter-quick-sidebar' ])

            <!--begin::Card toolbar-->
            <div class="card-toolbar align-self-end">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
                    <a href="{{ route('manage.people.admins.create') }}" class="btn btn-primary">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        New Admin
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
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px" colspan="2">User</th>
                        <th class="min-w-125px">Email</th>
                        <th class="min-w-125px">Role</th>
                        <th class="min-w-125px">Status</th>
                        <th class="text-end min-w-70px">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    @php
                        $roleBadgeMap = [
                          Src\Auth\Role::SYSTEM_ROOT => 'danger',
                          Src\Auth\Role::SYSTEM_ADMINISTRATOR => 'brand',
                          Src\Auth\Role::SYSTEM_USER => 'info',
                        ];

                        $statusBadgeMap = [
                            Src\People\User::STATUS_ACTIVE => 'success',
                            Src\People\User::STATUS_BANNED => 'danger',
                        ];
                    @endphp
                    @foreach($users as $user)
                        @php
                            $banUserFormId = "ban-user-{$user->id}-form";
                            $unbanUserFormId = "unban-user-{$user->id}-form";
                            $deleteUserFormId = "delete-user-{$user->id}-form";
                        @endphp
                        <tr>
                            <td width="48">
                                <img
                                    class="m--img-rounded"
                                    src="{{ $user->portrait->url }}"
                                    width="48"
                                    height="48"
                                >
                            </td>
                            <td>
                                {{ $user->profile->full_name }}
                                @if ($user->isAuthed())
                                    @component('manage.components.badge', [ 'type' => 'info', 'rounded' => true ])
                                        You
                                    @endcomponent
                                @endif
                            </td>
                            <td>
                                <a class="m-link" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </td>
                            <td class="m--font-{{ $roleBadgeMap[$user->role->name] }}">
                                @include('manage.components.badge--dot', [ 'type' => $roleBadgeMap[$user->role->name] ])
                                {{ $user->role->name }}
                            </td>
                            <td>
                                @component('manage.components.badge', [ 'type' => $statusBadgeMap[$user->status] ])
                                    {{ $user->status }}
                                @endcomponent
                            </td>
                            {{-- <td>
                                @if ($user->isAuthed())
                                    <a
                                        class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                        href="{{ route('manage.account.profile.edit') }}"
                                        title="Edit"
                                    >
                                        <i class="la la-edit"></i>
                                    </a>
                                    <a
                                        class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                        href="{{ route('manage.account.profile.edit-password') }}"
                                        title="Change Password"
                                    >
                                        <i class="la la-key"></i>
                                    </a>
                                @else
                                    <a
                                        class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                        href="{{ route('manage.people.admins.edit', [ 'id' => $user->id ]) }}"
                                        title="Edit"
                                    >
                                        <i class="la la-edit"></i>
                                    </a>
                                    <a
                                        class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                        href="{{ route('manage.people.admins.edit-password', [ 'id' => $user->id ]) }}"
                                        title="Change Password"
                                    >
                                        <i class="la la-key"></i>
                                    </a>
                                    @if ($user->isActive())
                                        <button
                                            class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                            title="Ban"
                                            onclick="confirmAction('Ban', 'Are you sure you want to ban this admin?', '{{ $banUserFormId }}')"
                                        >
                                            <i class="la la-lock"></i>
                                        </button>
                                        <form
                                            id="{{ $banUserFormId }}"
                                            class="m-form d-none"
                                            method="post"
                                            action="{{ route('manage.people.admins.ban', [ 'id' => $user->id ]) }}"
                                            data-confirm="true"
                                            data-confirm-type="warning"
                                            data-confirm-title="Ban <strong>{{ $user->profile->full_name }}</strong>"
                                            data-confirm-text="You are about to ban this admin."
                                        >
                                            @method('post')
                                            @csrf
                                        </form>
                                    @endif
                                    @if ($user->isBanned())
                                        <button
                                            class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                            title="Unban"
                                            onclick="confirmAction('Unban', 'Are you sure you want to unban this admin?', '{{ $unbanUserFormId }}')"
                                        >
                                            <i class="la la-unlock-alt"></i>
                                        </button>
                                        <form
                                            id="{{ $unbanUserFormId }}"
                                            class="m-form d-none"
                                            method="post"
                                            action="{{ route('manage.people.admins.unban', [ 'id' => $user->id ]) }}"
                                            data-confirm="true"
                                            data-confirm-type="warning"
                                            data-confirm-title="Unban <strong>{{ $user->profile->full_name }}</strong>"
                                            data-confirm-text="You are about to unban this admin."
                                        >
                                            @method('delete')
                                            @csrf
                                        </form>
                                    @endif
                                    <button
                                        class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                        title="Delete"
                                        onclick="confirmAction('Delete', 'Are you sure you want to delete this admin?', '{{$deleteUserFormId}}')"
                                    >
                                        <i class="la la-trash"></i>
                                    </button>
                                    <form
                                        id="{{ $deleteUserFormId }}"
                                        class="m-form d-none"
                                        method="post"
                                        action="{{ route('manage.people.admins.destroy', [ 'id' => $user->id ]) }}"
                                        data-confirm="true"
                                        data-confirm-type="delete"
                                        data-confirm-title="Delete <strong>{{ $user->profile->full_name }}</strong>"
                                        data-confirm-text="You are about to delete this admin, this procedure is irreversible."
                                    >
                                        @method('delete')
                                        @csrf
                                    </form>
                                @endif
                            </td> --}}
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions
                                    <i class="ki-outline ki-down fs-5 ms-1"></i>         
                                </a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                                    @if ($user->isAuthed())
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3" href="{{ route('manage.account.profile.edit') }}" title="Edit">
                                                Edit Profile
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3" href="{{ route('manage.account.profile.edit-password') }}" title="Change Password">
                                                Change Password
                                            </a>
                                        </div>
                                    @else
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3" href="{{ route('manage.people.admins.edit', [ 'id' => $user->id ]) }}" title="Edit">
                                                Edit Profile
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3" href="{{ route('manage.people.admins.edit-password', [ 'id' => $user->id ]) }}" title="Change Password">
                                                Change Password
                                            </a>
                                        </div>
                                        @if ($user->isActive())
                                            <div class="menu-item px-3">
                                                <a class="menu-link px-3" href="#" title="Ban" onclick="confirmAction('Ban', 'Are you sure you want to ban this admin?', '{{ $banUserFormId }}')">
                                                    Ban
                                                </a>
                                            </div>
                                            <form id="{{ $banUserFormId }}" class="m-form d-none" method="post" action="{{ route('manage.people.admins.ban', [ 'id' => $user->id ]) }}" data-confirm="true" data-confirm-type="warning" data-confirm-title="Ban <strong>{{ $user->profile->full_name }}</strong>" data-confirm-text="You are about to ban this admin.">
                                                @method('post')
                                                @csrf
                                            </form>
                                        @endif
                                        @if ($user->isBanned())
                                            <div class="menu-item px-3">
                                                <a class="menu-link px-3" href="#" title="Unban" onclick="confirmAction('Unban', 'Are you sure you want to unban this admin?', '{{ $unbanUserFormId }}')">
                                                    Unban
                                                </a>
                                            </div>
                                            <form id="{{ $unbanUserFormId }}" class="m-form d-none" method="post" action="{{ route('manage.people.admins.unban', [ 'id' => $user->id ]) }}" data-confirm="true" data-confirm-type="warning" data-confirm-title="Unban <strong>{{ $user->profile->full_name }}</strong>" data-confirm-text="You are about to unban this admin.">
                                                @method('delete')
                                                @csrf
                                            </form>
                                        @endif
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3" href="#" title="Delete" onclick="confirmAction('Delete', 'Are you sure you want to delete this admin?', '{{ $deleteUserFormId }}')">
                                                Delete
                                            </a>
                                        </div>
                                        <form id="{{ $deleteUserFormId }}" class="m-form d-none" method="post" action="{{ route('manage.people.admins.destroy', [ 'id' => $user->id ]) }}" data-confirm="true" data-confirm-type="delete" data-confirm-title="Delete <strong>{{ $user->profile->full_name }}</strong>" data-confirm-text="You are about to delete this admin, this procedure is irreversible.">
                                            @method('delete')
                                            @csrf
                                        </form>
                                    @endif
                                </div>
                                <!--end::Menu-->
                            </td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    @include('manage.components.pagination', [ 'results' => $users ])
                                    @include('manage.components.pagination-counter', ['results' => $users])
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    @endcomponent
@endsection

@push('quick-sidebar')
    @component('manage.components.table-filter-quick-sidebar', [
        'id' => 'users-filter-quick-sidebar'
    ])
        <fieldset>
            <div class="mb-10">
                <label class="form-label">Search</label>
                <input type="text" class="form-control form-control-solid" name="search"
                    value="{{ request('search') }}">
            </div>
            <div class="mb-10">
                <label class="form-label">Status</label>
                <div class="form-check form-check-custom form-check-solid mb-2">
                    <input class="form-check-input" type="checkbox" name="status[]"
                        value="{{ \Src\People\User::STATUS_ACTIVE }}"
                        {{ in_array(\Src\People\User::STATUS_ACTIVE, request('status', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="statusActive">
                        Active
                    </label>
                </div>

                <div class="form-check form-check-custom form-check-solid mb-2">
                    <input class="form-check-input" type="checkbox" name="status[]"
                        value="{{ \Src\People\User::STATUS_BANNED }}"
                        {{ in_array(\Src\People\User::STATUS_BANNED, request('status', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="statusBanned">
                        Banned
                    </label>
                </div>
            </div>
        </fieldset>
    @endcomponent
@endpush


