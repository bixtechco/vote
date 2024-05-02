@extends('metronic.layouts.admin')

@section('content')

    @section('title')
        Admins Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.admins.list') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            @include('metronic.components.table-filter', [ 'target' => 'users-filter-quick-sidebar' ])
            <form>
                @csrf
            </form>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
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
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th colspan="2">User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
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
                                @component('metronic.components.badge', [ 'type' => $statusBadgeMap[$user->status] ])
                                    {{ $user->status }}
                                @endcomponent
                            </td>
                            <td>
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
                                            form="{{ $banUserFormId }}"
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
                                            form="{{ $unbanUserFormId }}"
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
                                        form="{{ $deleteUserFormId }}"
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
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

@endsection