@extends('web.layouts.app')

@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div id="mount-id">
        <button disabled onclick="createSession()" class="checkoutButton">
            Check out
        </button>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection
@push('header')
    <script src="https://paypage.sandbox.ngenius-payments.com/hosted-sessions/sdk.js"></script>

    <script>
        /* Method call to mount the card input on your website */
        const hostedSessionApiKey = "{{ env('NETWORK_API_KEY') }}";
        const outletRef = "{{ env('NETWORK_REFERENCE') }}";
        const language = "en";
        const style = {
            main: {
                borderStyle: 'solid',
                borderColor: '#5d8f3a73',
                borderRadius: "20px",
                padding: '15px',
                margin: '15px',
                boxShadow: "0 0 17px 1px rgb(93 143 58 / 59%)",
            } /* the style for the main wrapper div around the card input*/ ,
            base: {
                fontUrl: "https://fonts.gstatic.com/s/manrope/v15/xn7gYHE41ni1AdIRggqxSuXd.woff2",
                fontFamily: "Manrope,sans-serif"
            } /* this is the default styles that comes with it */ ,
            input: {
                borderStyle: 'solid',
                borderColor: '#b0d38c',
                borderWidth: "0 0 1px 0"
            } /* custom style options for the input fields */ ,
            invalid: {} /* custom input invalid styles */
        };
        $(document).ready(function() {
            window.NI.mountCardInput('mount-id', {
                style: style,
                apiKey: hostedSessionApiKey,
                outletRef: outletRef,
                onSuccess: onSuccess,
                onFail: onFail,
                onChangeValidStatus: (function(_ref) {
                    var isCVVValid = _ref.isCVVValid,
                        isExpiryValid = _ref.isExpiryValid,
                        isNameValid = _ref.isNameValid,
                        isPanValid = _ref.isPanValid;

                    if( 
                        isCVVValid, isExpiryValid, isNameValid, isPanValid
                     ){
                        $('.checkoutButton').attr('disabled',false)
                    }

                    console.log(isCVVValid, isExpiryValid, isNameValid, isPanValid);
                })
            });
        });

        let sessionId;
        async function createSession() {
            try {
                const response = await window.NI.generateSessionId();
                sessionId = response.session_id;
            } catch (err) {
                console.error(err);
            }
        }

        function onSuccess() {
            console.log("onSuccess");
        }

        function onFail() {
            $('.checkoutButton').attr('disabled',true)
            console.log("onFail");
        }
    </script>

    <style>
        #mount-id iframe {
            min-height: 300px
        }
    </style>
@endpush
