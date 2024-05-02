@extends('main.layouts.app', [ 'pageTitle' => 'Login' ])

@section('page')
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10">
                        <!--begin::Page-->
                        <div class="card">
                            <button id="login-button">Login with Plug Wallet</button>
                            <button id="web-login-button">Login with Web Plug Wallet</button>
                        </div>
                        <!--end::Page-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->

                <!--begin::Footer-->
                <div class="d-flex flex-center flex-wrap px-5">
                    <!--begin::Links-->
                    <div class="d-flex fw-semibold text-primary fs-base">
                        <a href="#" class="px-5" target="_blank">Terms</a>

                        <a href="#" class="px-5" target="_blank">Plans</a>

                        <a href="#" class="px-5" target="_blank">Contact Us</a>
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Body-->

            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url({{ image('misc/auth-bg.png') }})">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <!--begin::Logo-->
                    <a href="{{ route('manage.dashboard') }}" class="mb-12">
                        <img alt="Logo" src="{{ image('logos/custom-1.png') }}" class="h-60px h-lg-75px"/>
                    </a>
                    <!--end::Logo-->

                    <!--begin::Image-->
                    <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{ image('misc/auth-screens.png') }}" alt=""/>
                    <!--end::Image-->

                    <!--begin::Title-->
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                        Fast, Efficient and Productive
                    </h1>
                    <!--end::Title-->

                    <!--begin::Text-->
                    <div class="d-none d-lg-block text-white fs-base text-center">
                        In this kind of post, <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>

                        introduces a person they’ve interviewed <br/> and provides some background information about

                        <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>
                        and their <br/> work following this is a transcript of the interview.
                    </div>
                    <!--end::Text-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Aside-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::App-->
@endsection

@section('style')
    <link href="{{ asset('manage/app.css') }}" rel="stylesheet">
    <style>
        @media (max-width: 500px) {
            #login-button {
                display: block;
                margin: 10px auto;
            }
        }

        card #login-button {
            display: none;
        }
    </style>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script>
    let mobileProvider = null;

    $(document).ready(function () {
        mobileProvider = new window.PlugMobileProvider({
            debug: true,
            walletConnectProjectId: 'e9f67c307e726afb7ea443f9b02c3386',
            window: window,
        });

        mobileProvider.initialize().catch(console.log);

        $('#login-button').click(function () {
            if (mobileProvider) {
                console.log('mobileProvider is defined');
                console.log('isPaired:', mobileProvider.isPaired());

                if (!mobileProvider.isPaired()) {
                    console.log('pair method is called');
                    mobileProvider.pair().then(async () => {
                        const principalId = await mobileProvider.getPrincipal();
                        console.log(`The connected user's principal ID is:`, principalId);

                        $.ajax({
                            url: '/login',
                            method: 'POST',
                            data: {
                                principalId: principalId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                console.log(response);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                    }).catch(console.log);
                }
            } else {
                console.log('mobileProvider is not defined');
            }
        });

        provider = window.ic.plug;

        $('#web-login-button').click(async function () {
            if (provider) {
                console.log('provider is defined');

                console.log('requestConnect method is called');
                try {
                    await window.ic.plug.requestConnect({
                        network: {
                            mainnet: 'http://laravel-icp.bar',
                            testnet: 'http://laravel-icp.bar',
                        },
                    });
                    const principal = await window.ic.plug.agent.getPrincipal();
                    const principalId = principal.toText();
                    console.log(`The connected user's principal ID is:`, principalId);
                    $.ajax({
                        url: '/login',
                        method: 'POST',
                        data: {
                            principalId: JSON.stringify(principalId),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log(response);
                            window.location.href = '/';
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                } catch (e) {
                    console.log(e);
                }
            } else {
                console.log('provider is not defined');
            }
        });
    });
</script>
</body>
</html>
