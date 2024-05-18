@extends('main.layouts.admin')

@section('content')
    @component('main.components.portlet', [
        'headText' => 'Voting Session ('. $votingSession->name .')',
        'headIcon' => 'flaticon-people',
        'backUrl' => route('main.voting.voting-sessions.list', ['id' => $association->id, 'votingSession' => $votingSession->id])
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
                                        <a href="{{ route('main.voting.associations.list', ['search' => $votingSession->association->name, 'redirectFrom' => route('manage.voting.voting-sessions.show', ['id' => $votingSession->id])]) }}"
                                           class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $votingSession->association->name }}</a>
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
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">{{ \Carbon\Carbon::parse($votingSession->start_date)->format('d M Y, h:i a') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="min-w-400px">
                                        End Date:
                                    </td>
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">{{ \Carbon\Carbon::parse($votingSession->end_date)->format('d M Y, h:i a') ?? '-' }}</td>
                                </tr>
                                {{--                                <tr>--}}
                                {{--                                    <td class="min-w-400px">--}}
                                {{--                                        Members Voted--}}
                                {{--                                    </td>--}}
                                {{--                                    @foreach($votingSessionMembers as $member)--}}
                                {{--                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $member->member->profile->full_name ?? '-' }}</td>--}}
                                {{--                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $member->member->email ?? '-' }}</td>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </tr>--}}
                                {{--                                <tr>--}}
                                {{--                                    <td class="min-w-400px">--}}
                                {{--                                        Members Not Voted--}}
                                {{--                                    </td>--}}
                                {{--                                    @foreach($usersNotVoted as $member)--}}
                                {{--                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $member->member->profile->full_name ?? '-' }}</td>--}}
                                {{--                                        <td class="pe-0 text-gray-600 text-end min-w-200px">{{ $member->member->email ?? '-' }}</td>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </tr>--}}
                                <tr>
                                    <td class="min-w-400px">
                                        Status:
                                    </td>
                                    <td class="pe-0 text-gray-600 text-end min-w-200px">
                                        <span
                                            class="badge badge-light-{{Src\Voting\VotingSession::STATUSES[$votingSession->status]['color']}} me-1">{{Src\Voting\VotingSession::STATUSES[$votingSession->status]['name']}}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($votingSession->winner_ids != null && $votingSession->isActive())
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <div class="card-header border-0">
                            <div class="card-title">
                                <h2>Winner</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0 pb-5">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed gy-5"
                                       id="kt_table_users_login_session">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                    <tr class="text-start text-muted text-uppercase gs-0">
                                        <th class="min-w-100px">Position</th>
                                        <th>Candidates</th>
                                        @if (($association->associationMembers->firstWhere('user_id', auth()->user()->id) && $association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin))
                                            <th>Votes Received</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                    @foreach($candidates as $position => $candidatesInPosition)
                                        @foreach($candidatesInPosition as $candidate)
                                            <tr>
                                                <td>{{ $position }}</td>
                                                <td>{{ $candidate['user']->profile->full_name }}</td>
                                                <td>{{ $candidate['votes'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                    @else
                                        <tbody class="fs-6 fw-semibold text-gray-600">
                                        @foreach($candidates as $position => $candidatesInPosition)
                                            @foreach($candidatesInPosition as $candidate)
                                                <tr>
                                                    <td>{{ $position }}</td>
                                                    <td>{{ $candidate['user']->profile->full_name }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (($association->associationMembers->firstWhere('user_id', auth()->user()->id) && $association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin))
                        <div class="card pt-4 mb-6 mb-xl-9" style="max-height: 500px; overflow-y: auto;">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h2>Members Haven't Vote</h2>
                                </div>
                            </div>
                            <div class="card-body py-0">
                                <div class="table-responsive">
                                    <table
                                        class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5"
                                        id="kt_table_users_logs">
                                        <tbody>
                                        @foreach($usersNotVoted as $member)
                                            <tr>
                                                <td>{{ $member->member->profile->full_name ?? '-' }}</td>
                                            </tr>
                                            @if (count($usersNotVoted) === 0)
                                                <tr>
                                                    <td>No members haven't voted</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card pt-4 mb-6 mb-xl-9" style="max-height: 500px; overflow-y: auto;">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h2>Members Voted</h2>
                                </div>
                            </div>
                            <div class="card-body py-0">
                                <div class="table-responsive">
                                    <table
                                        class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5"
                                        id="kt_table_users_logs">
                                        <tbody>
                                        @foreach($votingSessionMembers as $member)
                                            <tr>
                                                <td>{{ $member->member->profile->full_name ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endcomponent
@endsection

