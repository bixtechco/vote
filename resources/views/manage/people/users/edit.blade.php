@extends('manage.layouts.admin', [ 'pageTitle' => "Edit User #{$user->id}" ])

@section('content')
    <div class="row">
        <div class="col-lg-9">
            @component('manage.components.portlet', [
                'headText' => 'User',
                'headIcon' => 'flaticon-user',
                'formAction' => route('manage.people.users.update', ['id' => $user->id]),
                'formFiles' => true,
                'formMethod' => 'patch',
            ])
                @php
                    $authedUserAccessibleRoles = auth()->guard('web')->user()->getAccessibleRoles();
                    $roles = \Src\Auth\Role::whereIn('name', $authedUserAccessibleRoles)->get()
                @endphp

                <div class="card p-5 row">
                    <div class="col-md-12 p-5">
                        <fieldset class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group {{ $errors->has('full_name') ? 'has-danger' : '' }}">
                                <label class="form-control-label">Full name *</label>
                                <input
                                    type="text"
                                    name="full_name"
                                    class="form-control"
                                    value="{{ old('full_name', $user->profile->full_name) }}"
                                >
                                @include('manage.components.form-control-feedback', [ 'field' => 'full_name' ])
                            </div>
                            <div class="form-group m-form__group {{ $errors->has('email') ? 'has-danger' : '' }}">
                                <label class="form-control-label">Email *</label>
                                <input
                                    type="text"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email', $user->email) }}"
                                >
                                @include('manage.components.form-control-feedback', [ 'field' => 'email' ])
                            </div>
                        </fieldset>
                    </div>
                </div>

                @slot('formActionsLeft')
                    <button
                        type="submit"
                        class="btn btn-brand"
                    >
                        Submit
                    </button>
                    <button
                        type="reset"
                        class="btn btn-secondary"
                    >
                        Reset
                    </button>
                @endslot

                @slot('formActionsRight')
                    <a
                        class="btn btn-link m-link m--font-bold text-muted"
                        href="{{ route('manage.people.users.list') }}"
                    >
                        Cancel
                    </a>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
