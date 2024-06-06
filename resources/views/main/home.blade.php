@extends('main.layouts.admin', [ 'pageTitle' => "Home" ])

@section('content')
    <div class="row">
        @if (count($unvotedSessions) > 0)
            @foreach($unvotedSessions as $session)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal text-center align-content-center">{{ $session->name }}</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>{!! $session->description !!}</li>
                            </ul>
                            <a href="{{ route('main.voting.voting-sessions.show', ['id' => $session->association_id, 'votingSession' => $session->id]) }}" class="btn btn-lg btn-block btn-primary">Show Voting Session</a>
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
