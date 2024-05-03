@extends('manage.layouts.admin')

@section('content')
    @component('manage.components.portlet', [
        'headText' => 'Association',
        'headIcon' => 'flaticon-people',
        'backUrl' => route('manage.voting.associations.list')
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
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{$association->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Description: 
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{!! $association->description ?? '-' !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Created By: 
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ optional($association->createdBy->profile)->full_name ?? $association->createdBy->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Created At: 
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $association->created_at->format('d M Y, h:i a') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent
@endsection

