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
                        {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                        <input type="text" data-kt-user-table-filter="search"
                               class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search voting sessions"
                               id="mySearchInput"/>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card toolbar-->
                @if($association->associationMembers->firstWhere('user_id', auth()->user()->id) && $association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin)
                    <div class="card-toolbar align-self-end">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
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
                <div class="table-responsive">
                    <table class="table table-striped gy-7 gs-7">
                        <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                            <th>Name</th>
                            <th>Description</th>
                            <th>Year</th>
                            <th style="white-space: nowrap">Created By</th>
                            <th>Status</th>
                            <th style="text-align: center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
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
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('main.voting.voting-sessions.show', ['id' => $association->id, 'votingSession' => $session->id]) }}"
                                           class="text-gray-800 text-hover-primary fw-bolder me-3 mb-2">
                                            {{ $session->name }}
                                        </a>
                                    </div>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {!! $session->description !!}
                                </td>
                                <td>
                                    {{ $session->year }}
                                </td>
                                @php
                                    $creator = \Src\People\User::find($session->created_by);
                                @endphp
                                <td style="text-align: center; vertical-align: middle;">
                                    {{ $creator->profile->full_name }}
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    @component('main.components.badge', [ 'type' => $statusBadgeMap[$session->status] ])
                                        {{ Src\Voting\VotingSession::STATUSES[$session->status]['name'] }}
                                    @endcomponent
                                </td>
                                <td style="text-align: center; width: 30%">
                                    <a
                                        class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                        href="{{ route('main.voting.voting-sessions.edit', ['id' => $association->id, 'votingSession' => $session->id]) }}"
                                        title="Edit"
                                    >
                                        <i class="la la-edit"></i>
                                    </a>
                                    @if (($association->associationMembers->firstWhere('user_id', auth()->user()->id) && $association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin) && $session->winner_ids == null && $session->isActive())
                                        <button
                                            class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                            title="Close Vote"
                                            onclick="confirmAction('Close vote', 'Are you sure you want to close vote for this voting session?', '{{ $closeFormId }}')"
                                        >
                                            <i class="la la-hand-o-up"></i>
                                        </button>
                                        <form
                                            id="{{ $closeFormId }}"
                                            class="m-form d-none"
                                            method="post"
                                            action="{{ route('main.voting.voting-sessions.close-vote', [ 'id' => $association->id, 'votingSession' => $session->id ]) }}"
                                            data-confirm="true"
                                            data-confirm-type="warning"
                                            data-confirm-title="Close Form <strong>{{ $session->name }}</strong>"
                                            data-confirm-text="You are about to close this voting session."
                                        >
                                            @method('post')
                                            @csrf
                                        </form>
                                    @endif
                                    @if ($session->votingSessionMembers->where('user_id', auth()->user()->id)->isEmpty() && $session->isActive())
                                        <button
                                            id="{{ $voteFormId }}"
                                            class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                            title="Vote"
                                            data-bs-toggle="modal"
                                            data-bs-target="#{{ $modalId }}"
                                        >
                                            <i class="la la-check"></i>
                                        </button>
                                    @endif
                                    @if ($session->isDraft())
                                        <button
                                            class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                            title="Inactive"
                                            onclick="confirmAction('Inactive', 'Are you sure you want to inactive this user?', '{{ $banUserFormId }}')"
                                        >
                                            <i class="la la-lock"></i>
                                        </button>
                                        <form
                                            id="{{ $banUserFormId }}"
                                            class="m-form d-none"
                                            method="post"
                                            action="{{ route('main.voting.voting-sessions.inactive', [ 'id' => $association->id, 'votingSession' => $session->id ]) }}"
                                            data-confirm="true"
                                            data-confirm-type="warning"
                                            data-confirm-title="Inactive <strong>{{ $session->name }}</strong>"
                                            data-confirm-text="You are about to inactive this admin."
                                        >
                                            @method('post')
                                            @csrf
                                        </form>
                                        <button
                                            class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                            title="Unban"
                                            onclick="confirmAction('Active', 'Are you sure you want to active this user?', '{{ $unbanUserFormId }}')"
                                        >
                                            <i class="la la-unlock-alt"></i>
                                        </button>
                                        <form
                                            id="{{ $unbanUserFormId }}"
                                            class="m-form d-none"
                                            method="post"
                                            action="{{ route('main.voting.voting-sessions.active', [ 'id' => $association->id, 'votingSession' => $session->id ]) }}"
                                            data-confirm="true"
                                            data-confirm-type="warning"
                                            data-confirm-title="Active <strong>{{ $session->name }}</strong>"
                                            data-confirm-text="You are about to active this associate."
                                        >
                                            @method('post')
                                            @csrf
                                        </form>
                                    @endif
                                    @if ($session->isActive())
                                        <button
                                            class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                            title="Inactive"
                                            onclick="confirmAction('Inactive', 'Are you sure you want to inactive this user?', '{{ $banUserFormId }}')"
                                        >
                                            <i class="la la-lock"></i>
                                        </button>
                                        <form
                                            id="{{ $banUserFormId }}"
                                            class="m-form d-none"
                                            method="post"
                                            action="{{ route('main.voting.voting-sessions.inactive', [ 'id' => $association->id, 'votingSession' => $session->id ]) }}"
                                            data-confirm="true"
                                            data-confirm-type="warning"
                                            data-confirm-title="Inactive <strong>{{ $session->name }}</strong>"
                                            data-confirm-text="You are about to inactive this admin."
                                        >
                                            @method('post')
                                            @csrf
                                        </form>
                                    @endif
                                    @if ($session->isInactive())
                                        <button
                                            class="btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill"
                                            title="Unban"
                                            onclick="confirmAction('Active', 'Are you sure you want to active this user?', '{{ $unbanUserFormId }}')"
                                        >
                                            <i class="la la-unlock-alt"></i>
                                        </button>
                                        <form
                                            id="{{ $unbanUserFormId }}"
                                            class="m-form d-none"
                                            method="post"
                                            action="{{ route('main.voting.voting-sessions.active', [ 'id' => $association->id, 'votingSession' => $session->id ]) }}"
                                            data-confirm="true"
                                            data-confirm-type="warning"
                                            data-confirm-title="Active <strong>{{ $session->name }}</strong>"
                                            data-confirm-text="You are about to active this associate."
                                        >
                                            @method('post')
                                            @csrf
                                        </form>
                                    @endif
                                    <button
                                        class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                        title="Delete"
                                        onclick="confirmAction('Delete', 'Are you sure you want to delete this user?', '{{ $deleteUserFormId }}')"
                                    >
                                        <i class="la la-trash"></i>
                                    </button>
                                    <form
                                        id="{{ $deleteUserFormId }}"
                                        class="m-form d-none"
                                        method="post"
                                        action="{{ route('main.voting.voting-sessions.destroy', [ 'id' => $association->id , 'votingSession' => $session->id]) }}"
                                        data-confirm="true"
                                        data-confirm-type="delete"
                                        data-confirm-title="Delete <strong>{{ $session->name }}</strong>"
                                        data-confirm-text="You are about to delete this admin, this procedure is irreversible."
                                    >
                                        @method('delete')
                                        @csrf
                                    </form>
                                </td>
                            </tr>
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

                    </table>

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
