@extends('manage.layouts.admin')

@php
    $redirectFrom = request()->get('redirectFrom') ?? false;
@endphp

@section('content')
    @component('manage.components.portlet', [
        'headText' => 'Voting Sessions',
        'headIcon' => 'flaticon-people',
        'backUrl' => $redirectFrom

    ])
    @section('title')
        Voting Sessions Overview
    @endsection

    @include('manage.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
            @include('manage.components.table-filter', [ 'target' => 'users-filter-quick-sidebar' ])

        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px" colspan="2">Association</th>
                        <th class="min-w-125px">Name</th>
                        <th class="min-w-125px">Status</th>
                        <th class="text-end min-w-70px">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    @foreach($votingSessions as $votingSession)
                        <tr>
                            <td colspan="2">
                                <a href="{{ route('manage.voting.associations.list', ['search' => $votingSession->association->name, 'redirectFrom' => route('manage.voting.voting-sessions.list') ]) }}" class="text-gray-800 text-hover-primary fw-bold mb-3">{{ $votingSession->association->name }}</a>
                            </td>
                            <td>
                                {{ $votingSession->name }}
                            </td>
                            <td>
                                @component('manage.components.badge', [ 'type' => Src\Voting\VotingSession::STATUSES[$votingSession->status]['color'] ])
                                    {{ Src\Voting\VotingSession::STATUSES[$votingSession->status]['name'] }}
                                @endcomponent
                            </td>

                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions
                                    <i class="ki-outline ki-down fs-5 ms-1"></i>         
                                </a>
                                                    <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a class="menu-link px-3"href="{{ route('manage.voting.voting-sessions.show', [ 'id' => $votingSession->id ]) }}"
                                            title="Edit">
                                            Edit
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    
                                    <!--begin::Menu item-->
                                    {{-- <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-kt-customer-table-filter="delete_row">
                                            Delete
                                        </a>
                                    </div> --}}
                                    <!--end::Menu item-->
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
                                @include('manage.components.pagination', [ 'results' => $votingSessions ])
                                @include('manage.components.pagination-counter', ['results' => $votingSessions])
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
