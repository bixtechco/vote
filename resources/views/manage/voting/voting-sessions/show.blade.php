@extends('manage.layouts.admin')

@section('content')
    @component('manage.components.portlet', [
        'headText' => 'Voting Session ('. $votingSession->name .')',
        'headIcon' => 'flaticon-people',
        'backUrl' => route('manage.voting.voting-sessions.list')
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
                                            Association: 
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            <a href="{{ route('manage.voting.associations.list', ['search' => $votingSession->association->name, 'redirectFrom' => route('manage.voting.voting-sessions.show', ['id' => $votingSession->id])]) }}" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $votingSession->association->name }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Name: 
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $votingSession->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Year: 
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $votingSession->year }}</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Start Date: 
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ optional($votingSession->start_date)->format('d M Y, h:i a') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            End Date: 
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ optional($votingSession->end_date)->format('d M Y, h:i a') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Members Voted
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $data['total_members_voted'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            Status: 
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">
                                            <span class="badge badge-light-{{Src\Voting\VotingSession::STATUSES[$votingSession->status]['color']}} me-1">{{Src\Voting\VotingSession::STATUSES[$votingSession->status]['name']}}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <div class="card-header border-0">
                            <div class="card-title">
                                <h2>Votes</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0 pb-5">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th class="min-w-100px">Position</th>
                                            <th>Candidates</th>
                                            @if ($votingSession->status !== Src\Voting\VotingSession::STATUS_COMPLETED)
                                                <th>Winner</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        @foreach ($data['candidates'] as $role => $candidates)
                                            <tr>
                                                <td>
                                                    {{ $role }}
                                                </td>
                                                <td>
                                                    @foreach ($candidates as $candidate)
                                                        <div>{{optional($candidate->profile)->full_name ?? $candidate->email}} - {{$data['vote_counts'][$role][$candidate->id]}} / {{$totalMembers}}</div>
                                                    @endforeach
                                                </td>
                                                @if ($votingSession->status !== Src\Voting\VotingSession::STATUS_COMPLETED)
                                                    <td>
                                                        @if (isset($winners[$role]))
                                                            @foreach ($winners[$role] as $winner)
                                                                <div>{{optional($winner->profile)->full_name ?? $winner->email}}<div>
                                                            @endforeach
                                                            @if (count($winners[$role]) > 1)
                                                                <div class="badge badge-light-danger">Tie</div>
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card pt-4 mb-6 mb-xl-9" style="max-height: 500px; overflow-y: auto;">
                        <div class="card-header border-0">
                            <div class="card-title">
                                <h2>Members Haven't Vote</h2>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5" id="kt_table_users_logs">
                                    <tbody>
                                        @foreach ($data['members_not_voted'] as $member)
                                            <tr>
                                                <td>{{ optional($member->profile)->full_name ?? $member->email }}</td>
                                            </tr>
                                        @endforeach

                                        @if (count($data['members_not_voted']) === 0)
                                            <tr>
                                                <td>No members haven't voted</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent
@endsection

