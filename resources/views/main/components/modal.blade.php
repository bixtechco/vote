@php
    $submitButton = $submitButton ?? 'Submit';
    $formAction = $formAction ?? false;
    $formMethod = $formMethod ?? 'post';
@endphp
@if ($formAction)
    <div class="modal position-absolute" id="{{ $id  }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form
                    id="create-sale-source-form"
                    class="m-form d-none"
                    method="post"
                    action="{{ route('manage.order.orders.create.sale.source') }}"
                    data-confirm="true"
                    data-confirm-type="create"
                    data-confirm-title="Create a new sale source"
                    data-confirm-text="This procedure is irreversible."
                >
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{$title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body" id="{{ $id }}ModalBody">
                        {{ $slot }}
                    </div>
                    <div class="modal-footer">
                        <button id="cancelButton" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{$submitButton}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="modal position-absolute" id="{{ $id  }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="{{ $id }}ModalBody">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">{{$submitButton}}</button>
                </div>
            </div>
        </div>
    </div>
@endif
