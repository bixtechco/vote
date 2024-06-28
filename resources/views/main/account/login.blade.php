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
                    {{--                    <!--begin::Wrapper-->--}}
                    <div class="w-lg-500px p-10">
                        <!--begin::Page-->
                        <input type="hidden" id="token" value="{{ $token }}">
                        <button id="login-button" class="login-button custom-btn" style="display: none">
                                <span>Login with Plug Wallet</span>
                            </button>
                            <button id="web-login-button" class="web-login-button custom-btn"><span>Login with Plug Wallet</span></button>
                        <!--end::Page-->
                    </div>
                    {{--                    <!--end::Wrapper-->--}}
                </div>
                {{--                <!--end::Form-->--}}

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
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                 style="background-image: url({{ image('misc/auth-bg.png') }})">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <!--begin::Logo-->
                    <a href="{{ route('manage.dashboard') }}" class="mb-12">
                        <img alt="Logo" src="{{ image('logos/custom-1.png') }}" class="h-60px h-lg-75px"/>
                    </a>
                    <!--end::Logo-->

                    <!--begin::Image-->
                    <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
                         src="{{ image('misc/auth-screens.png') }}" alt=""/>
                    <!--end::Image-->

                    <!--begin::Title-->
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                        Fast, Efficient and Productive
                    </h1>
                    <!--end::Title-->

                    <!--begin::Text-->
                    <div class="d-none d-lg-block text-white fs-base text-center">
                        In this kind of post, <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the
                            blogger</a>

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

<style>
    .custom-btn {
        width: 100%;
        height: 100%;
        color: #fff;
        border-radius: 5px;
        padding: 10px 25px;
        font-family: 'Lato', sans-serif;
        font-weight: 500;
        background: transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
        box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
        7px 7px 20px 0px rgba(0,0,0,.1),
        4px 4px 5px 0px rgba(0,0,0,.1);
        outline: none;
    }

    @media (max-width: 500px) {
        .login-button {
            display: block !important;
            margin: 10px auto;
        }

        .web-login-button {
            display: none !important;
            margin: 10px auto;
        }
    }

    @media (min-width: 501px) {
        .web-login-button {
            display: block !important;
        }
    }

    .web-login-button {
        background: rgb(22,9,240);
        background: linear-gradient(0deg, rgba(22,9,240,1) 0%, rgba(49,110,244,1) 100%);
        color: #fff;
        border: none;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .web-login-button:after {
        position: absolute;
        content: " ";
        top: 0;
        left: 0;
        z-index: -1;
        width: 100%;
        height: 100%;
        transition: all 0.3s ease;
        -webkit-transform: scale(.1);
        transform: scale(.1);
    }
    .web-login-button:hover {
        color: #fff;
        border: none;
        background: transparent;
    }
    .web-login-button:hover:after {
        background: rgb(0,3,255);
        background: linear-gradient(0deg, rgba(2,126,251,1) 0%,  rgba(0,3,255,1)100%);
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    .login-button {
        background: rgb(22,9,240);
        background: linear-gradient(0deg, rgba(22,9,240,1) 0%, rgba(49,110,244,1) 100%);
        color: #fff;
        border: none;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .login-button:after {
        position: absolute;
        content: " ";
        top: 0;
        left: 0;
        z-index: -1;
        width: 100%;
        height: 100%;
        transition: all 0.3s ease;
        -webkit-transform: scale(.1);
        transform: scale(.1);
    }
    .login-button:hover {
        color: #fff;
        border: none;
        background: transparent;
    }
    .login-button:hover:after {
        background: rgb(0,3,255);
        background: linear-gradient(0deg, rgba(2,126,251,1) 0%,  rgba(0,3,255,1)100%);
        -webkit-transform: scale(1);
        transform: scale(1);
    }


</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>

<script>
    let mobileProvider = null;
    const plugWalletHomepage = "https://plugwallet.ooo";

    $(document).ready(function () {
        mobileProvider = new window.PlugMobileProvider({
            debug: true,
            walletConnectProjectId: 'e9f67c307e726afb7ea443f9b02c3386',
            window: window,
        });

        mobileProvider.initialize().then(() => {
            mobileProvider.disconnect();
        }).catch(console.log);

        $('#login-button').click(function () {
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
                        const principal = await agent.getPrincipal();
                        const principalId = principal.toText();
                        console.log(`The connected user's principal ID is:`, principalId);
                        const token = $('#token').val();

                        $.ajax({
                            url: '/login',
                            method: 'POST',
                            data: {
                                principalId: JSON.stringify(principalId),
                                token: token,
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
                    }).catch(error => {
                        console.log('Error during pairing:', error);
                    });
                }
            } else {
                console.log('mobileProvider is not defined');
                window.open(plugWalletHomepage, '_blank');
            }
        });

        $('#web-login-button').click(async function () {
            if (window.ic && window.ic.plug) {
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
                    const token = $('#token').val();

                    $.ajax({
                        url: '/login',
                        method: 'POST',
                        data: {
                            principalId: JSON.stringify(principalId),
                            token: token,

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
                window.open(plugWalletHomepage, '_blank');
            }
        });
    });
</script>
