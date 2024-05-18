@extends('main.layouts.admin', [ 'pageTitle' => "View Joined Voting Sessions Overview" ])

@section('content')
    @section('title')
        Joined Voting Sessions Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.users.list') }}
    @endsection

    @include('main.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

    <div class="card p-5">
        @component('main.components.portlet', [
                    'headText' => 'View Joined Voting Sessions',
                    'headIcon' => 'flaticon-user',
                ])
            <div class="card-body py-4">

                <div class="table-responsive">
                    <table class="table table-striped gy-7 gs-7">
                        <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                            <th>Voting Session Name</th>
                            <th>Voted Candidate</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($votingSessionMembers as $member)
                            <tr>
                                <td>
                                    <a href="{{ route('main.voting.voting-sessions.show', ['id' => $member->association->id, 'votingSession' => $member->votingSession->id]) }}">
                                    {{$member->votingSession->name}}
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $votes = json_decode($member->votes, true);
                                    @endphp
                                    @foreach($votes as $position => $userId)
                                        @php
                                            $votedCandidate = Src\People\User::findOrFail($userId)
                                        @endphp
                                        <p><strong>{{ $position }}:</strong> {{ $votedCandidate->profile->full_name }}</p>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                        @endforeach


                    </table>

                </div>
            </div>

        @endcomponent
    </div>
@endsection
