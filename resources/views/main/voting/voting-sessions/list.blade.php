@extends('main.layouts.admin')

@section('content')
    @section('title')
        Voting Sessions Overview
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.people.users.list') }}
    @endsection

    @include('main.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

    <div class="card p-5">
        @component('main.components.portlet', [
            'headText' => "View Voting Sessions of Association #{$association->name}",
            'headIcon' => 'flaticon-user',
            'backUrl' => route('main.voting.associations.list'),

        ])
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        Voting Sessions Overview
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                @if($association->associationMembers->firstWhere('user_id', auth()->user()->id) && $association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin)
                    <div class="card-toolbar d-flex justify-content-end">
                        <!--begin::Toolbar-->
                        <div class="d-flex" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <a href="{{ route('main.voting.voting-sessions.create', ['id' => $association->id]) }}"
                               class="btn btn-primary">
                                {!! getIcon('plus', 'fs-2', '', 'i') !!}
                                New Voting Session
                            </a>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            @endif


            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div class="row">
                    @php
                        $statusBadgeMap = [
                            Src\Voting\VotingSession::STATUS_ACTIVE => 'success',
                            Src\Voting\VotingSession::STATUS_INACTIVE => 'danger',
                            Src\Voting\VotingSession::STATUS_DRAFT => 'warning',
                        ];
                    @endphp
                    @php
                        $voteFormId = 'default_vote_form_id';
                    @endphp
                    @foreach($votingSessions as $session)
                        @php
                            $banUserFormId = "ban-user-{$session->id}-form";
                            $unbanUserFormId = "unban-user-{$session->id}-form";
                            $deleteUserFormId = "delete-user-{$session->id}-form";
                            $closeFormId = "close-user-{$session->id}-form";
                            $voteFormId = "vote-{$session->id}-form";
                            $modalId = "vote-modal-{$session->id}";
                        @endphp
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $session->name }}</h4>
                                </div>
                                <div class="card-body">
                                    <p>{!! $session->description !!}</p>
                                    <p>Year: {{ $session->year }}</p>
                                    <p>Created
                                        by: {{ \Src\People\User::find($session->created_by)->profile->full_name }}</p>
                                    <p>Status:
                                        <span class="badge badge-{{ $statusBadgeMap[$session->status] }}">
                                        {{ Src\Voting\VotingSession::STATUSES[$session->status]['name'] }}
                                    </span>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item"
                                                   href="{{ route('main.voting.voting-sessions.edit', ['id' => $association->id, 'votingSession' => $session->id]) }}">Edit</a>
                                            </li>
                                            @if ($session->isActive())
                                                <li>
                                                    <form id="ban-user-{{ $session->id }}-form" method="POST"
                                                          action="{{ route('main.voting.voting-sessions.inactive', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                                        @csrf
                                                        <button type="button" class="dropdown-item"
                                                                onclick="window.confirmAction('Inactive', 'Are you sure you want to inactive this user?', 'ban-user-{{ $session->id }}-form')">
                                                            Inactive
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if ($session->isInactive())
                                                <li>
                                                    <form id="unban-user-{{ $session->id }}-form" method="POST"
                                                          action="{{ route('main.voting.voting-sessions.active', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                                        @csrf
                                                        <button type="button" class="dropdown-item"
                                                                onclick="window.confirmAction('Active', 'Are you sure you want to active this user?', 'unban-user-{{ $session->id }}-form')">
                                                            Active
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if ($session->isDraft())
                                                <li>
                                                    <form id="unban-user-{{ $session->id }}-form" method="POST"
                                                          action="{{ route('main.voting.voting-sessions.active', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                                        @csrf
                                                        <button type="button" class="dropdown-item"
                                                                onclick="window.confirmAction('Active', 'Are you sure you want to active this user?', 'unban-user-{{ $session->id }}-form')">
                                                            Active
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li>
                                                <form id="delete-user-{{ $session->id }}-form" method="POST"
                                                      action="{{ route('main.voting.voting-sessions.destroy', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="dropdown-item"
                                                            onclick="window.confirmAction('Delete', 'Are you sure you want to delete this user?', 'delete-user-{{ $session->id }}-form')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </li>
                                            @if (($association->associationMembers->firstWhere('user_id', auth()->user()->id) && $association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin) && $session->winner_ids == null && $session->isActive())
                                                <li>
                                                    <form id="close-user-{{ $session->id }}-form" method="POST"
                                                          action="{{ route('main.voting.voting-sessions.close-vote', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                                        @csrf
                                                        <button type="button" class="dropdown-item"
                                                                onclick="window.confirmAction('Close vote', 'Are you sure you want to close vote for this voting session?', 'close-user-{{ $session->id }}-form')">
                                                            Close Vote
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if ($session->votingSessionMembers->where('user_id', auth()->user()->id)->isEmpty() && $session->isActive())
                                                <li>
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#vote-modal-{{ $session->id }}">Vote
                                                    </button>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="voteModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow-lg">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="voteModalLabel">Vote</h5>
                                        <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <form
                                            id="{{ $voteFormId }}"
                                            class="m-form vote-form"
                                            method="post"
                                            action="{{ route('main.voting.voting-sessions.vote', [ 'id' => $association->id, 'votingSession' => $session->id ]) }}"
                                        >
                                            @csrf
                                            <input type="hidden" id="block_index" name="block_index" value="">

                                            @php
                                                $roleCandidates = json_decode($session->role_candidate_ids, true);
                                            @endphp

                                            @foreach($roleCandidates as $role => $candidates)
                                                <div class="mb-3">
                                                    <label for="{{ $role }}" class="form-label">{{ $role }}</label>
                                                    <select id="{{ $role }}" name="votes[{{ $role }}]"
                                                            class="form-select">
                                                        @foreach($candidates as $candidate)
                                                            @php
                                                                $user = \Src\People\User::find($candidate);
                                                            @endphp
                                                            <option
                                                                value="{{ $candidate }}">{{ $user->profile->full_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach

                                            <div class="modal-footer bg-light border-0">
                                                <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close
                                                </button>
                                                <button
                                                    class="btn btn-warning"
                                                    title="Vote"
                                                    type="submit"
                                                >
                                                    <i class="la la-check"></i> Vote
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--end::Table-->
            </div>
        @endcomponent
        <!--end::Card body-->
    </div>
@endsection
@push('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        $(document).ready(function () {
            const isMobile = PlugMobileProvider.isMobileBrowser();
            if (isMobile) {
                let mobileProvider = null;

                mobileProvider = new window.PlugMobileProvider({
                    debug: true,
                    walletConnectProjectId: 'e9f67c307e726afb7ea443f9b02c3386',
                    window: window,
                });

                mobileProvider.initialize().then(() => {
                    mobileProvider.disconnect();
                }).catch(console.log);

                $('.vote-form').on('submit', function (event) {
                    event.preventDefault();

                    if (mobileProvider) {
                        console.log('mobileProvider is defined');
                        console.log('isPaired:', mobileProvider.isPaired());

                        if (!mobileProvider.isPaired()) {
                            console.log('pair method is called');
                            mobileProvider.pair().then(async () => {
                                const agent = await mobileProvider.createAgent({
                                    host: 'http://127.0.0.1:4943',
                                    targets: ['bd3sg-teaaa-aaaaa-qaaba-cai']
                                });

                                console.log('Submitting form...');
                                const blockIndex = voteResult[0].toString();
                                console.log('Block index:', blockIndex);

                                const formData = new FormData(event.target);
                                formData.append('block_index', blockIndex);

                                const response = await fetch(event.target.action, {
                                    method: 'POST',
                                    body: formData,
                                });

                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }

                                const data = await response.json();
                                console.log('Response data:', data);
                                window.location.reload();
                            }).catch(error => {
                                console.log('Error during pairing:', error);
                            });
                        }
                    } else {
                        console.log('mobileProvider is not defined');
                    }
                });

                provider = window.ic.plug;

            } else {
                const backendCanisterId = 'bd3sg-teaaa-aaaaa-qaaba-cai';
                const backendInterfaceFactory = ({IDL}) => {
                    return IDL.Service({
                        'vote': IDL.Func([], [IDL.Opt(IDL.Nat64)], []),
                    });
                };

                let backendActor;

                const onConnectionUpdate = async () => {
                    console.log('Updating connection...');
                    try {
                        backendActor = await window.ic.plug.createActor({
                            canisterId: backendCanisterId,
                            interfaceFactory: backendInterfaceFactory,
                        });
                        console.log('Actor created:', backendActor);
                    } catch (error) {
                        console.error('Error creating actor:', error);
                    }
                };

                $('.vote-form').on('submit', async function (event) {
                    event.preventDefault();

                    console.log('Vote button clicked');
                    try {
                        await window.ic.plug.requestConnect({
                            host: 'http://127.0.0.1:4943',
                            whitelist: [backendCanisterId],
                            onConnectionUpdate,
                        });

                        await onConnectionUpdate();
                        console.log('Connected to Internet Computer');

                        console.log('Calling vote function...');
                        const voteResult = await backendActor.vote();
                        console.log('Vote result:', voteResult);

                        if (voteResult !== null) {
                            console.log('Submitting form...');
                            const blockIndex = voteResult[0].toString();
                            console.log('Block index:', blockIndex);

                            const formData = new FormData(event.target);
                            formData.append('block_index', blockIndex);

                            const response = await fetch(event.target.action, {
                                method: 'POST',
                                body: formData,
                            });

                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }

                            const data = await response.json();
                            console.log('Response data:', data);
                            window.location.reload();
                        } else {
                            throw new Error('Vote failed: Empty or invalid result');
                        }
                    } catch (error) {
                        console.error('Vote failed:', error);
                    }
                });
            }
        });
    </script>
@endpush
