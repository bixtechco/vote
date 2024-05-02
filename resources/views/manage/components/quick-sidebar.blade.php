{{-- <aside --}}
    {{-- id="{{ $id }}" --}}
    {{-- class="m-quick-sidebar m-quick-sidebar--skin-light m-form__actions--solid" --}}
{{-- > --}}
{{--    <button--}}
{{--        id="{{ $id }}__close"--}}
{{--        class="btn m-quick-sidebar__close"--}}
{{--    >--}}
{{--        <i class="la la-close"></i>--}}
{{--    </button>--}}
    {{-- {{ $slot }} --}}
{{-- </aside> --}}

<div
    id="{{ $id }}"
    class="bg-white"
    data-kt-drawer="true"
    data-kt-drawer-activate="true"
    data-kt-drawer-toggle="#{{ $id }}-toggler"
    data-kt-drawer-close="#{{ $id }}-close"
    data-kt-drawer-width="350px"
>
    {{ $slot }}
</div>
