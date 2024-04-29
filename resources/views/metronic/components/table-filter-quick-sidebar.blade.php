@component('metronic.components.quick-sidebar', [
    'id' => $id,
])
    @php
        $para = isset($para) ? $para : 'id';
        $formAction = isset($user_id) && isset($para) ? route(Route::currentRouteName(), [$para => $user_id]) : route(Route::currentRouteName());
        $formMethod = 'get';
    @endphp
    {{-- @component('metronic.components.portlet', [
    'unair' => true,
    'headText' => 'Filter Records',
    'headIcon' => '',
    'formAction' => isset($user_id) && isset($para) ? route(Route::currentRouteName(), [$para => $user_id]) : route(Route::currentRouteName()),
    'formMethod' => 'get',
    'formXlColOffset' => 0,
])
        {{ $slot }}

        @slot('formActionsLeft')
            <button
                type="submit"
                class="btn btn-info"
            >
                <i class="la la-filter"></i>
                Filter
            </button>
        @endslot

    @endcomponent --}}
    <form method="{{ $formMethod === 'get' ? 'get' : 'post' }}" action="{{ $formAction }}" class="w-100">
        <div class="card w-100 rounded-0 h-100">
            <!--begin::Card header-->
            <div class="card-header pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <span class="fs-4 fw-bold text-gray-900 me-1 lh-1">Filters: </span>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="{{$id}}-close">
                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                {{ $slot }}
            </div>
            <!--end::Card body-->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
            </div>
        </div>
    </form>
@endcomponent
