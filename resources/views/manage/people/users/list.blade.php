@extends('manage.layouts.admin')

@php
    $redirectFrom = request()->get('redirectFrom') ?? false;
@endphp


@section('content')
    @component('manage.components.portlet', [
        'headText' => 'Users',
        'headIcon' => 'flaticon-people',
        'backUrl' => $redirectFrom
    ])
    @section('title')
        Users Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.users.list') }}
    @endsection

    @include('manage.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

    <div class="card">
         <!--begin::Card header-->
         <div class="card-header border-0 pt-6 flex-column">
            <!--begin::Card title-->
            <form>
               @csrf
            </form>
            <!--begin::Card title-->
            @include('manage.components.table-filter', [ 'target' => 'users-filter-quick-sidebar' ])
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                <table class="table table-striped gy-7 gs-7">
                    <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th colspan="2">User</th>
                        <th>Email</th>
                        <th>Phone</th>
                        @if (request('association'))
                            <th>Role</th>
                        @endif
                        <th>Status</th>
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
                    @foreach($users as $user)
                    @php
                        $banUserFormId = "ban-user-{$user->id}-form";
                        $unbanUserFormId = "unban-user-{$user->id}-form";
                        $deleteUserFormId = "delete-user-{$user->id}-form";
                        $verifyUserFormId = "verify-user-{$user->id}-form";
                    @endphp
                        <tr>
                            <td width="48">
                                <img class="m--img-rounded" src="{{ $user->portrait->url }}" width="48" height="48">
                            </td>
                            <td>
                                <a>{{ $user->profile->full_name }}</a>
                                @if ($user->isAuthed())
                                    @component('manage.components.badge', ['type' => 'info', 'rounded' => true])
                                        You
                                    @endcomponent
                                @endif
                                <br>
                                <span>Affiliate ID: {{ $user->affiliate_id }}</span>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <a class="m-link" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                {{ $user->formatted_phone_number }}
                            </td>
                            @if (request('association'))
                                @php
                                    $roleBadgeMap = [
                                        0 => 'primary', 1 => 'info',
                                    ];
                                    $isAdmin = $user->associations()->where('id', request('association'))->first();
                                @endphp
                                <td>
                                    @if ($isAdmin)
                                        @component('manage.components.badge', [ 'type' => $roleBadgeMap[$isAdmin->pivot->is_admin] ])
                                            {{$isAdmin->pivot->is_admin == 1 ? 'Admin' : 'Member'}}
                                        @endcomponent
                                    @endif
                                </td>
                            @endif
                            <td style="text-align: center; vertical-align: middle;">
                                @component('manage.components.badge', [ 'type' => $statusBadgeMap[$user->status] ])
                                    {{ $user->status }}
                                @endcomponent
                            </td>
                            <td>
                                {{-- <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.people.users.show', ['id' => $user->id]) }}"
                                    title="Details"
                                >
                                    <i class="la la-eye"></i>
                                </a> --}}
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.voting.associations.list', ['user' => $user->id]) }}"
                                    title="Associations"
                                >
                                    <i class="la la-user"></i>
                                </a>
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.voting.voting-sessions.list', ['user' => $user->id]) }}"
                                    title="Voting Sessions"
                                >
                                    <i class="la la-book"></i>
                                </a>
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
                                @if($user->isVerifying())
                                    <button
                                        class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                        title="Verify"
                                        onclick="confirmAction('Verify', 'Are you sure you want to verify this user?', '{{$verifyUserFormId}}')"
                                    >
                                        <i class="la la-check"></i>
                                    </button>
                                    <form
                                        id="{{ $verifyUserFormId }}"
                                        class="m-form d-none"
                                        method="post"
                                        action="{{ route('manage.people.users.verify', [ 'id' => $user->id ]) }}"
                                        data-confirm="true"
                                        data-confirm-type="warning"
                                        data-confirm-title="Verify <strong>{{ $user->profile->full_name }}</strong>"
                                        data-confirm-text="You are about to verify this user."
                                    >
                                        @method('post')
                                        @csrf
                                    </form>
                                @endIf
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.people.users.edit', [ 'id' => $user->id ]) }}"
                                    title="Edit"
                                >
                                    <i class="la la-edit"></i>
                                </a>
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.people.users.edit-password', [ 'id' => $user->id ]) }}"
                                    title="Change Password"
                                >
                                    <i class="la la-key"></i>
                                </a>
                                @if ($user->isActive())
                                    <button
                                        class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                        title="Ban"
                                        onclick="confirmAction('Ban', 'Are you sure you want to ban this user?', '{{$banUserFormId}}')"
                                    >
                                        <i class="la la-lock"></i>
                                    </button>
                                    <form
                                        id="{{ $banUserFormId }}"
                                        class="m-form d-none"
                                        method="post"
                                        action="{{ route('manage.people.users.ban', [ 'id' => $user->id ]) }}"
                                        data-confirm="true"
                                        data-confirm-type="warning"
                                        data-confirm-title="Ban <strong>{{ $user->profile->full_name }}</strong>"
                                        data-confirm-text="You are about to ban this user."
                                    >
                                        @method('post')
                                        @csrf
                                    </form>
                                @endif
                                @if ($user->isBanned())
                                    <button
                                        class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                        title="Unban"
                                        onclick="confirmAction('Unban', 'Are you sure you want to unban this user?', '{{$unbanUserFormId}}')"
                                        form="{{ $unbanUserFormId }}"
                                    >
                                        <i class="la la-unlock-alt"></i>
                                    </button>
                                    <form
                                        id="{{ $unbanUserFormId }}"
                                        class="m-form d-none"
                                        method="post"
                                        action="{{ route('manage.people.users.unban', [ 'id' => $user->id ]) }}"
                                        data-confirm="true"
                                        data-confirm-type="warning"
                                        data-confirm-title="Unban <strong>{{ $user->profile->full_name }}</strong>"
                                        data-confirm-text="You are about to unban this user."
                                    >
                                        @method('delete')
                                        @csrf
                                    </form>
                                @endif
                                <button
                                    class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                    title="Delete"
                                    onclick="confirmAction('Delete', 'Are you sure you want to delete this user?', '{{$deleteUserFormId}}')"
                                >
                                    <i class="la la-trash"></i>
                                </button>
                                <form
                                    id="{{ $deleteUserFormId }}"
                                    class="m-form d-none"
                                    method="post"
                                    action="{{ route('manage.people.users.destroy', [ 'id' => $user->id ]) }}"
                                    data-confirm="true"
                                    data-confirm-type="delete"
                                    data-confirm-title="Delete <strong>{{ $user->profile->full_name }}</strong>"
                                    data-confirm-text="You are about to delete this user, this procedure is irreversible."
                                >
                                    @method('delete')
                                    @csrf
                                </form>
                            @endif
                            </td>
                        </tr>
                    @endforeach
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
