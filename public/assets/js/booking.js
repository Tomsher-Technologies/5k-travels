$(document).on('click', '.addToCart', function () {

    var form = $(this);
    var formURL = form.data('action');

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.ajaxloader').css('display', 'block');

    $.ajax({
        type: "GET",
        url: config.routes.checklogin,
        success: function (data) {
            var resp = JSON.parse(data);
            console.log(resp.status);
            $('.ajaxloader').css('display', 'none');
            if (resp.status == true) {
                $.ajax({
                    type: "POST",
                    url: formURL,
                    data: {
                        'search_id': form.data('search_id'),
                        'LFID': form.data('lfid'),
                        'FareTypeID': form.data('faretypeid'),
                    },
                    success: function (data) {
                        $('.ajaxloader').css('display', 'none');
                        var resp = JSON.parse(data);
                        if (resp.status == true) {

                            $('<form/>', { action: config.routes.flydubai_ancillary, method: 'GET' }).append(
                                $('<input>', { type: 'hidden', name: 'search_id', value: form.data('search_id') }),
                                $('<input>', { type: 'hidden', name: 'LFID', value: form.data('lfid') }),
                                $('<input>', { type: 'hidden', name: 'FareTypeID', value: form.data('faretypeid') }),
                            ).appendTo('body').submit();

                        } else {
                            swal({
                                title: "Not Available",
                                text: "Flights fare may have changed. Please refresh the page.",
                                icon: "warning"
                            }).then(function () {
                                // window.location.reload();
                            });
                        }
                    }
                });
            } else {
                new bootstrap.Modal(document.getElementById("common_author-forms"), {}).show();
            }
        }
    });
});

$(document).on('click', '#addToCart', function (e) {

    e.preventDefault();

    var form = $(this);
    var formURL = form.attr('action');

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.ajaxloader').css('display', 'block');
    $.ajax({
        type: "POST",
        url: formURL,
        data: form.serialize(),
        success: function (data) {
            $('.ajaxloader').css('display', 'none');
            var resp = JSON.parse(data);
            if (resp.status == true) {
                // console.log(data);
                var data = resp.data;
                $('<form/>', { action: config.routes.flydubai_ancillary, method: 'GET' }).append(
                    $('<input>', { type: 'hidden', name: 'search_id', value: data.search_id }),
                    $('<input>', { type: 'hidden', name: 'dep_LFID', value: data.dep_LFID }),
                    $('<input>', { type: 'hidden', name: 'rtn_LFID', value: data.rtn_LFID }),
                    $('<input>', { type: 'hidden', name: 'dep_FareTypeID', value: data.dep_FareTypeID }),
                    $('<input>', { type: 'hidden', name: 'rtn_FareTypeID', value: data.rtn_FareTypeID }),
                    $('<input>', { type: 'hidden', name: 'dep_solnid', value: data.dep_solnid }),
                    $('<input>', { type: 'hidden', name: 'rtn_solnid', value: data.rtn_solnid }),
                ).appendTo('body').submit();

            } else {
                swal({
                    title: "Not Available",
                    text: "Flights fare may have changed. Please refresh the page.",
                    icon: "warning"
                }).then(function () {
                    // window.location.reload();
                });
            }
        }
    });

});