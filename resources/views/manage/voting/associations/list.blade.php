@extends('manage.layouts.admin')

@section('content')
    @section('title')
        Associations Overview
    @endsection

    @include('manage.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

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
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
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
                        <th colspan="2">Description</th>
                        <th>Created By</th>
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
                        <tr>
                            <td colspan="2">
                                {{ $association->name }}
                            </td>
                            <td colspan="2">{!! $association->description !!}</td>
                            <td>{{ $association->createdBy->email }}</td>
                            <td>
                                @component('manage.components.badge', [ 'type' => $statusBadgeMap[$association->status] ])
                                    {{ Src\Voting\Association::STATUSES[$association->status]['name'] }}
                                @endcomponent
                            </td>
                            <td>
                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.voting.associations.show', [ 'id' => $association->id ]) }}"
                                    title="Details"
                                >
                                    <i class="la la-eye"></i>
                                </a>

                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.people.users.list', [ 'association' => $association->id ]) }}"
                                    title="Association Members"
                                >
                                    <i class="la la-user"></i>
                                </a>

                                <a
                                    class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                    href="{{ route('manage.voting.voting-sessions.list', [ 'association' => $association->id ]) }}"
                                    title="Voting Sessions"
                                >
                                    <i class="la la-book"></i>
                                </a>
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
