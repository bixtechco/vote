@extends('main.layouts.admin')

@section('content')
@section('title')
Voting Sessions Overview
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render('manage.people.users.list') }}
@endsection

@include('main.components.modal', ['id' => 'modal', 'title' => 'Confirm Action', 'submitButton' => 'Confirm', 'slot' => 'Are you sure you want to perform this action?'])

<div class="card p-0">
    @component('main.components.portlet', [
    'headText' => "View Voting Sessions of Association #{$association->name}",
    'headIcon' => 'flaticon-user',
    'backUrl' => route('main.voting.associations.list'),
])
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6 d-flex justify-content-between">
        <div class="card-title">
            <h3>Voting Sessions Overview</h3>
        </div>
        @if($association->associationMembers->firstWhere('user_id', auth()->user()->id) && $association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin)
            <div class="card-toolbar">
                <a href="{{ route('main.voting.voting-sessions.create', ['id' => $association->id]) }}"
                    class="btn btn-primary">
                    {!! getIcon('plus', 'fs-2', '', 'i') !!}
                    New Voting Session
                </a>
            </div>
        @endif
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-2">
        <div class="row">
            @php
                $statusBadgeMap = [
                    Src\Voting\VotingSession::STATUS_ACTIVE => 'success',
                    Src\Voting\VotingSession::STATUS_INACTIVE => 'danger',
                    Src\Voting\VotingSession::STATUS_DRAFT => 'warning',
                ];
            @endphp
            @foreach($votingSessions as $session)
                        @php
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
                                    <p>Created by: {{ \Src\People\User::find($session->created_by)->profile->full_name }}</p>
                                    <p>Status:
                                        <span class="badge badge-{{ $statusBadgeMap[$session->status] }}">
                                            {{ Src\Voting\VotingSession::STATUSES[$session->status]['name'] }}
                                        </span>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between">
                                        @if ($session->votingSessionMembers->where('user_id', auth()->user()->id)->isEmpty() && $session->isActive())
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                                Vote
                                            </button>
                                        @endif
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('main.voting.voting-sessions.show', ['id' => $association->id, 'votingSession' => $session->id]) }}">View</a>
                                            </li>
                                            @if ($association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin)
                                                <li><a class="dropdown-item"
                                                        href="{{ route('main.voting.voting-sessions.edit', ['id' => $association->id, 'votingSession' => $session->id]) }}">Edit</a>
                                                </li>
                                                <li>
                                                    <form id="delete-user-{{ $session->id }}-form" method="POST"
                                                        action="{{ route('main.voting.voting-sessions.destroy', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="dropdown-item"
                                                            onclick="window.confirmAction('Delete', 'Are you sure you want to delete this session?', 'delete-user-{{ $session->id }}-form')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if ($association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin && $session->isActive())
                                                <li>
                                                    <form id="ban-user-{{ $session->id }}-form" method="POST"
                                                        action="{{ route('main.voting.voting-sessions.inactive', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                                        @csrf
                                                        <button type="button" class="dropdown-item"
                                                            onclick="window.confirmAction('Inactive', 'Are you sure you want to deactivate this session?', 'ban-user-{{ $session->id }}-form')">
                                                            Inactive
                                                        </button>
                                                    </form>
                                                </li>
                                            @elseif ($association->associationMembers->firstWhere('user_id', auth()->user()->id)->is_admin && $session->isInactive())
                                                <li>
                                                    <form id="activate-user-{{ $session->id }}-form" method="POST"
                                                        action="{{ route('main.voting.voting-sessions.active', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                                        @csrf
                                                        <button type="button" class="dropdown-item"
                                                            onclick="window.confirmAction('Active', 'Are you sure you want to activate this session?', 'activate-user-{{ $session->id }}-form')">
                                                            Active
                                                        </button>
                                                    </form>
                                                </li>
                                            @else ($association->associationMembers->firstWhere('user_id', au
                                                   t            h()->user()->id)->is_admin && $session->isDraft())
                                                                <li>
                                                                    <form id="activate-user-{{ $session->id }}-form" method="POST"
                                                                        action="{{ route('main.voting.voting-sessions.active', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                                                        @csrf
                                                                        <button type="button" class="dropdown-item"
                                                                            onclick="window.confirmAction('Active', 'Are you sure you want to activate this session?', 'activate-user-{{ $session->id }}-form')">
                                                                            Active
                                                                        </button>
                                                                    </form>
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
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <form id="{{ $voteFormId }}" class="m-form vote-form" method="post"
                                            action="{{ route('main.voting.voting-sessions.vote', ['id' => $association->id, 'votingSession' => $session->id]) }}">
                                            @csrf
                                            <input type="hidden" id="block_index" name="block_index" value="">
                                            @php
                                                $roleCandidates = json_decode($session->role_candidate_ids, true);
                                            @endphp
                                            @foreach($roleCandidates as $role => $candidates)
                                                                    <div class="mb-3">
                                                                        <label for="{{ $role }}" class="form-label">{{ $role }}</label>
                                                                        <select id="{{ $role }}" name="votes[{{ $role }}]" class="form-select">
                                                                            @foreach($candidates as $candidate)
                                                                                                            @php
                                                                                                                $user = \Src\People\User::find($candidate);
                                                                                                            @endphp
                                                                                                            <option value="{{ $candidate }}">{{ $user->profile->full_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                            @endforeach
                                            <div class="modal-footer bg-light border-0">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-warning" title="Vote" type="button"
                                                    onclick="showConfirmationModal('{{ $voteFormId }}')">
                                                    <i class="la la-check"></i> Vote
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
            @endforeach
            <!-- Confirmation Modal -->
            <div id="card-confirmation" class="card-confirmation" style="display: none;">
                <span class="title">⚠️ Confirm Action</span>
                <p class="description">
                    Are you sure you want to perform a token burning process? This action is irreversible and will cost
                    0.0001 ICP.
                </p>
                <a class="prefs">
                    <a href="https://internetcomputer.org/icp-tokens">Read token burning policies</a>
                </a>
                <div class="actions">
                    <button class="decline" data-bs-dismiss="modal">
                        Reject
                    </button>
                    <button class="valid" id="confirmActionButton">
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card body-->
    @endcomponent
</div>
@endsection
<style>
    .card-confirmation {
        width: 370px !important;
        background: white;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        flex-direction: column;
        justify-content: space-between;
        padding: 40px;
        border-radius: 40px;
        background-color: hsl(120deg 20% 95%);
        box-shadow: 17px 17px 34px 0px rgb(124, 134, 124),
            inset -8px -8px 16px 0px rgba(117, 133, 117, 0.7),
            inset 0px 14px 28px 0px hsl(120deg 20% 95%);
        z-index: 9999;
        text-align: center;
    }

    .card-confirmation .title {
        color: black;
        font-size: 2rem;
        font-weight: 600;
    }

    .card-confirmation .description {
        color: black;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .card-confirmation .prefs {
        color: blue;
        font-size: .8em;
        margin-bottom: 20px;
    }

    .card-confirmation .actions {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-confirmation button {
        color: white;
        border: none;
        background: none;
        padding: 20px;
        border-radius: 15px;
        cursor: pointer;
        font-size: 1.2em;
        font-weight: bold;
    }

    .card-confirmation .decline {
        color: rgb(255, 0, 0);
        box-shadow: 4px 4px 8px 0px rgb(134, 124, 124),
            inset -8px -8px 16px 0px rgba(92, 92, 92, 0.7),
            inset 0px 14px 28px 0px hsl(120deg 20% 95%);
    }

    .card-confirmation .valid {
        color: rgb(0, 156, 0);
        box-shadow: 4px 4px 8px 0px rgb(124, 134, 125),
            inset -8px -8px 16px 0px rgba(121, 121, 121, 0.7),
            inset 0px 14px 28px 0px hsl(120deg 20% 95%);
    }

    .card-confirmation .decline:hover {
        color: white;
        background-color: rgb(255, 0, 0);
        box-shadow: 4px 4px 8px 0px rgb(134, 124, 124),
            inset -8px -8px 16px 0px rgba(134, 20, 20, 0.7),
            inset 0px 14px 28px 0px hsl(120deg 20% 95%);
    }

    .card-confirmation .valid:hover {
        color: white;
        background-color: rgb(0, 156, 0);
        box-shadow: 4px 4px 8px 0px rgb(124, 134, 125),
            inset -8px -8px 16px 0px rgba(47, 134, 20, 0.7),
            inset 0px 14px 28px 0px hsl(120deg 20% 95%);
    }
</style>
@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
       $(document).ready(function () {
    const backendCanisterId = 'bd3sg-teaaa-aaaaa-qaaba-cai';

    const backendInterfaceFactory = ({ IDL }) => {
        return IDL.Service({
            'vote': IDL.Func([IDL.Text], [IDL.Opt(IDL.Nat64)], []),
        });
    };

    let backendActor;

    const initializeActor = async () => {
        try {
            await window.agentInitialized;
            backendActor = await window.Actor.createActor(backendInterfaceFactory, {
                agent: window.agent,
                canisterId: backendCanisterId,
            });
            console.log('Actor created:', backendActor);
        } catch (error) {
            console.error('Error creating actor:', error);
        }
    };

    initializeActor();

    window.showConfirmationModal = function (formId) {
        $('.modal').modal('hide');
        $('#card-confirmation').data('formId', formId).fadeIn();
    };

    $('#confirmActionButton').on('click', async function () {
    const formId = $('#card-confirmation').data('formId');
    const form = $('#' + formId);

    const formData = new FormData(form[0]);

    try {
        const response = await fetch(form.attr('action'), {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        console.log('Response data:', data);

        if (data.success) {
            const details = data.details; 
            console.log('Details:', details);

            const voteResult = await backendActor.vote(details);
            console.log('Vote result:', voteResult);

            if (voteResult !== null) {
                console.log('Submitting form...');
                const blockIndex = BigInt(voteResult[0].toString());
                console.log('Block index:', blockIndex);

                formData.append('block_index', blockIndex);

                const finalResponse = await fetch(form.attr('action'), {
                    method: 'POST',
                    body: formData,
                });

                if (!finalResponse.ok) {
                    throw new Error('Network response was not ok');
                }

                const finalData = await finalResponse.json();
                console.log('Final response data:', finalData);
                window.location.reload();
            } else {
                throw new Error('Vote failed: Empty or invalid result');
            }
        } else {
            throw new Error('Initial form submission failed');
        }
    } catch (error) {
        console.error('Vote failed:', error);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message,
        });

        $('.modal').modal('hide');
        $('#card-confirmation').fadeOut();
    }

    $('.decline').on('click', function () {
        $('#card-confirmation').fadeOut();
    });
});

    </script>
@endpush

