@extends('main.layouts.admin', [ 'pageTitle' => "View Joined Voting Sessions Overview" ])

@section('content')
    @section('title')
        Joined Voting Sessions Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.users.list') }}
    @endsection

    @include('main.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

    <div class="row">
        @if (count($votingSessionMembers) > 0)
            @foreach($votingSessionMembers as $member)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal text-center align-content-center">{{ $member->votingSession ? $member->votingSession->name : 'Session Deleted'}}</h4>
                        </div>
                        <div class="card-body">
                            <p>Association: {{ $member->association->name }}</p>
                            <p>Voted Date: {{ $member->created_at->format('Y-m-d') }}</p>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary mb-5" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#votes-{{ $member->id }}" aria-expanded="false"
                                        aria-controls="votes-{{ $member->id }}">
                                    Show Votes
                                </button>
                            </div>
                            <div class="collapse" id="votes-{{ $member->id }}">
                                @php
                                    $votes = json_decode($member->votes, true);
                                @endphp
                                @if($votes)
                                    @foreach($votes as $position => $userId)
                                        @php
                                            $votedCandidate = Src\People\User::findOrFail($userId)
                                        @endphp
                                        <p><strong>{{ $position }}:</strong> {{ $votedCandidate->profile->full_name }}
                                        </p>
                                    @endforeach
                                @else
                                    <p>No votes recorded for this member.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">No voting sessions available</h4>
                    <p>There are no voting sessions available at the moment. Please check back later.</p>
                </div>
            </div>
        @endif
    </div>
@endsection
