@php
    $start_time = microtime(true);
@endphp

<div class="tab-pane fade" id="nav-seats" role="tabpanel" aria-labelledby="nav-seats-tab">
    <div class="row" id="setatscontent">

        <div class="lod">
            <div class="loading"></div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        console.time("add");
        $.ajax({
            type: "GET",
            url: "{{ route('flydubai.seathtml') }}",
            cache: false,
            data: {
                search_id: '{!! request()->search_id !!}'
            },
            contentType: false,
            success: function(data) {
                if (data.success) {
                    $("#setatscontent").append(data.html);
                    $('.lod').hide();
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log("XHR", xhr);
                console.log("status", textStatus);
                console.log("Error in", errorThrown);
            }
        });
        console.timeEnd("add");
    })
</script>

<style>
    #nav-seats {
        position: relative;
    }

    #setatscontent {
        min-height: 250px
    }

    .lod {
        display: flex;
        justify-content: space-around;
        align-items: center;
        background: #ffffff59;
        position: absolute;
        height: 100%;
        width: 100%;
        z-index: 999;
    }

    .loading {
        border-radius: 50%;
        width: 80px;
        height: 80px;
        border: 0.25rem solid rgb(169 207 130);
        border-top-color: #5d8f3a;
        -webkit-animation: spin 1s infinite linear;
        animation: spin 1s infinite linear;
    }

    @-webkit-keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes pulse {
        50% {
            background: white;
        }
    }

    @keyframes pulse {
        50% {
            background: white;
        }
    }
</style>
@php
    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
@endphp
seat: {{ $execution_time }}
