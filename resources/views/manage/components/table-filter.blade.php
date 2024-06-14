@php
$hasFilters = $filters->isNotEmpty();
@endphp
<section class="table-filter w-100">
    <div class="d-flex justify-content-between align-items-center">
        <div class="">
            @if($hasFilters)
                <div class="m-list-badge m-list-badge--light-bg my-2 d-inline-flex align-items-center gap-10">
                    <h4 class="m-list-badge__label">Filters:</h4>
                    <ul class="list-inline m-list-badge__items m-0">
                        @foreach($filters as $filter => $param)
                            @php
                                $routeFilterRouteParameters = $filters->except($filter)->map(function($param) {
                                    return $param['value'];
                                });
                                {{isset($id)?$removeFilterRoute=route(Route::currentRouteName(), [ 'id' => $id],hash_expand($routeFilterRouteParameters->all())):
                                $removeFilterRoute = route(Route::currentRouteName(), hash_expand($routeFilterRouteParameters->all()));
                            }}
                            @endphp
                            <li
                                class="list-inline-item m-list-badge__item btn btn-outline"
                            >
                                {{ $param['title'] }}: {{ $param['formattedValue'] }}
                                <a
                                    class="ml-2"
                                    href="{{ $removeFilterRoute }}"
                                >
                                    <i class="la la-times"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="text-right">
            {{-- <button
                id="{{ $target }}-toggler"
                class="btn btn-outline"
                type="button"
            >
                <i class="la la-filter"></i> Filter
            </button> --}}

            <button id="{{ $target }}-toggler" type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="ki-outline ki-filter fs-2"></i>        Filter
            </button>

            @if($hasFilters)
                <a
                    class="btn btn-secondary"
                    href="{{ isset($id)?route(Route::currentRouteName(), [ 'id' => $id]):route(Route::currentRouteName()) }}"
                >
                    <i class="la la-times"></i> Clear
                </a>
            @endif
        </div>
    </div>
</section>

<div class="separator my-5 w-100"></div>

