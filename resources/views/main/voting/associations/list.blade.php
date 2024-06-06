@extends('main.layouts.admin')

@section('content')
    @section('title')
        Associations Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.users.list') }}
    @endsection

    @include('main.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

    <div class="card p-0">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    Associations Overview
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
        <div class="card-body p-2">
            <!--begin::Table-->
            <div class="row">
                @php
                    $statusBadgeMap = [
                        Src\Voting\Association::STATUS_ACTIVE => 'success',
                        Src\Voting\Association::STATUS_INACTIVE => 'danger',
                    ];
                @endphp
                @foreach($associations as $association)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header">
                                <h4 class="card-title">{{ $association->name }}</h4>
                            </div>
                            <div class="card-body">
                                <p>{!! $association->description !!}</p>
                                <p>Created
                                    by: {{ \Src\People\User::find($association->created_by)->profile->full_name }}</p>
                                <p>Updated
                                    by: {{ \Src\People\User::find($association->updated_by)->profile->full_name ?? 'N/A' }}</p>
                                <p>Status:
                                    <span class="badge badge-{{ $statusBadgeMap[$association->status] }}">
                                        {{ Src\Voting\Association::STATUSES[$association->status]['name'] }}
                                    </span>
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item"
                                           href="{{ route('main.voting.associations.edit', ['id' => $association->id]) }}">Edit</a>
                                        <a class="dropdown-item"
                                           href="{{ route('main.voting.associations.view-members', ['id' => $association->id]) }}">View
                                            All Association Members</a>
                                        <a class="dropdown-item"
                                           href="{{ route('main.voting.voting-sessions.list', ['id' => $association->id]) }}">View
                                            All Voting Sessions</a>
                                        @if ($association->isActive())
                                            <a class="dropdown-item" href="#"
                                               onclick="confirmAction('Inactive', 'Are you sure you want to inactive this user?', 'ban-user-{{ $association->id }}-form')">Inactive</a>
                                            <form id="ban-user-{{ $association->id }}-form" method="POST"
                                                  action="{{ route('main.voting.associations.inactive', ['id' => $association->id]) }}"
                                                  class="d-none">
                                                @csrf
                                            </form>
                                        @endif
                                        @if ($association->isInactive())
                                            <a class="dropdown-item" href="#"
                                               onclick="confirmAction('Active', 'Are you sure you want to active this user?', 'unban-user-{{ $association->id }}-form')">Active</a>
                                            <form id="unban-user-{{ $association->id }}-form" method="POST"
                                                  action="{{ route('main.voting.associations.active', ['id' => $association->id]) }}"
                                                  class="d-none">
                                                @csrf
                                            </form>
                                        @endif
                                        <a class="dropdown-item" href="#"
                                           onclick="confirmAction('Delete', 'Are you sure you want to delete this user?', 'delete-user-{{ $association->id }}-form')">Delete</a>
                                        <form id="delete-user-{{ $association->id }}-form" method="POST"
                                              action="{{ route('main.voting.associations.destroy', ['id' => $association->id]) }}"
                                              class="d-none">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
@endsection


