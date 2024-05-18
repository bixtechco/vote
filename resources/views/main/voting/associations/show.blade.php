@extends('main.layouts.admin', [ 'pageTitle' => "View Association #{$association->id}" ])

@section('content')
    @component('main.components.portlet', [
        'headText' => 'Association ('. $association->name .')',
        'headIcon' => 'flaticon-user',
        'backUrl' => route('main.voting.associations.list', ['id' => $association->id])
    ])
        @slot('headTools')

        @endslot
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mt-4">
                <div>
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <div class="card-header border-0">
                            <div class="card-title">
                                <h2>Details</h2>
                            </div>
                        </div>
                        <div class="card-body py-0 table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-5">
                                <tbody>
                                <tr>
                                    <td class="min-w-400px">
                                        Name:
                                    </td>
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $association->name }}</td>
                                </tr>
                                <tr>
                                    <td class="min-w-400px">
                                        Description:
                                    </td>
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $association->description }}</td>
                                </tr>
                                <tr>
                                    <td class="min-w-400px">
                                        Members:
                                    </td>
                                    <td class="pe-0 text-gray-600 min-w-200px text-end">{{ $association->associationMembers->first()->member->profile->full_name ?? 'No members' }}</td>
                                </tr>
                                @foreach($association->associationMembers->slice(1) as $member)
                                    <tr>
                                        <td></td>
                                        <td class="pe-0 text-gray-600 min-w-200px text-end">{{ $member->member->profile->full_name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent
@endsection
