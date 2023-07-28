$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});

$(document).ready(function () {
    
    // on load of the page: switch to the currently selected tab
    // var hash = window.location.hash;
    var currentUrl = window.location.href;
    var urlFormatted = new URL(currentUrl);
    var searchType = urlFormatted.searchParams.get("search_type");
   
    if(searchType == "OneWay"){
        $('#searchTab a[href="#oneway_flight"]').tab('show');
    }else if(searchType == "Return"){
        $('#searchTab a[href="#roundtrip"]').tab('show');
    }else if(searchType == "Circle"){
        $('#searchTab a[href="#multi_city"]').tab('show');
    }
    
    
    if(one_way_session){
        $('#oFrom').val(one_way_session.oFrom);
        $('#oTo').val(one_way_session.oTo);

        $('#oFrom_label').val(one_way_session.oFrom_label);
        $('#oTo_label').val(one_way_session.oTo_label);

        $('#oFrom_labels').html(one_way_session.oFrom_label);
        $('#oTo_labels').html(one_way_session.oTo_label);

        $('#oDate').val(one_way_session.oDate).trigger('change');;
    }
    if(return_session){
        $('#rFrom').val(return_session.rFrom);
        $('#rTo').val(return_session.rTo);

        $('#rFrom_label').val(return_session.rFrom_label);
        $('#rTo_label').val(return_session.rTo_label);

        $('#rFrom_labels').html(return_session.rFrom_label);
        $('#rTo_labels').html(return_session.rTo_label);

        $('#rDate').val(return_session.rDate).trigger('change');;
        $('#rReturnDate').val(return_session.rReturnDate).trigger('change');;
    }

    if(multi_session){
        let fromPlacesCount = (multi_session.mFrom).length;
        
        for (let step = 0; step < fromPlacesCount; step++) {
            if(step >=2){
                generateMultiFields(step);
            }
            var mFrom_label = 'mFrom_label'+step;
            var mTo_label ='mTo_label'+step;
            console.log(multi_session+mFrom_label);
            $('#mFrom'+step).val(multi_session.mFrom[step]);
            $('#mTo'+step).val(multi_session.mTo[step]);

            $('#mFrom_label'+step).val(eval(`multi_session.${mFrom_label}`));
            $('#mTo_label'+step).val(eval(`multi_session.${mTo_label}`));

            $('#mFrom_labels'+step).html(eval(`multi_session.${mFrom_label}`));
            $('#mTo_labels'+step).html(eval(`multi_session.${mTo_label}`));

            $('#mDate'+step).val(multi_session.mDate[step]).trigger('change');
        }

        // $('#rFrom').val(return_session.rFrom).trigger('change');
        // $('#rTo').val(return_session.rTo).trigger('change');
        // $('#rDate').val(return_session.rDate).trigger('change');
        // $('#rReturnDate').val(return_session.rReturnDate).trigger('change');
    }

    $('.one_way_cabin button').click(function () {
        event.stopPropagation();
        event.preventDefault();
        $('.one_way_cabin button.active').removeClass("active");
        $(this).addClass("active");
        var cabin = $(this).attr('data-id');
        $('#oClass').val(cabin);
        cabin = (cabin == 'First') ? 'First Class' : cabin;
        $('#oClass_label').html(cabin);
    });

    $('.return_cabin button').click(function () {
        event.stopPropagation();
        event.preventDefault();
        $('.return_cabin button.active').removeClass("active");
        $(this).addClass("active");
        var cabin = $(this).attr('data-id');
        $('#rClass').val(cabin);
        cabin = (cabin == 'First') ? 'First Class' : cabin;
        $('#rClass_label').html(cabin);
    });

    $('.multi_cabin button').click(function () {
        event.stopPropagation();
        event.preventDefault();
        $('.multi_cabin button.active').removeClass("active");
        $(this).addClass("active");
        var cabin = $(this).attr('data-id');
        $('#mClass').val(cabin);
        cabin = (cabin == 'First') ? 'First Class' : cabin;
        $('#mClass_label').html(cabin);
    });
    
});

$(document).on("change", ".travel_date", function(){
    var day = getDay($(this).val());
    $(this).parent().find('span.day_label').text(day);
 });
 
function getDay(value){
    var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    var a = new Date(value);
    return weekday[a.getDay()];
}
loadAutocomplete();
function loadAutocomplete(){
    $(".load_airports").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: ROUTES.autocomplete_airports,
                data: {
                        term : request.term
                },
                dataType: "json",
                success: function(data){
                response(data);
                }
            });
        },
        select: function (event, ui) {
            // Set selection
            $(this).val(ui.item.value); // display the selected text
            $(this).parent().find('span').text(ui.item.airport);
            $(this).parent().find('.airport').val(ui.item.airport);
            return false;
        },
        minLength: 1,
        change: function( event, ui ) {
            if($(this).val() == ''){
                $(this).parent().find('span').text('');
                $(this).parent().find('.airport').val('');
            }
           
        }
        // open: function() {
        //     $("ul.ui-menu").width('300px');
        // }
    });

    $('.load_airports').each(function() {
        $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
            return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<a>" + item.label + "</a>")
            .appendTo(ul);
        };
    });
}
   

$("#oFromForm").validate({
    rules: {
        oFrom: {
            required : true,
            minlength:3
        },
        oTo:{
            required : true,
            minlength:3
        },
        oDate: 'required'
    },
    errorPlacement: function (error, element) {
        if(element.hasClass('select2')) {
            error.insertAfter(element.next('.select2-container'));
        }else{
            error.appendTo(element.parent("div"));
        }
    },
    submitHandler: function(form) {
        $('.ajaxloader').css('display','block');
        form.submit();
    }
});

var one_way_sum = 1;

function addOnewayValue(elemId) {
    one_way_sum = parseInt($('#oAdult').val()) + parseInt($('#oChild').val()) + parseInt($('#oInfant').val());
    var passenger = (one_way_sum > 1) ? ' Passengers' : ' Passenger';
    $('.one_way_final_count').text(`${one_way_sum}` + passenger);
}

$('.oAdult').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#oAdult').val();
    var parsed = parseInt(counter);
    var result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result !=0){
        $('#oAdult').val(result);
        addOnewayValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

$('.oChild').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#oChild').val();
    var parsed = parseInt(counter);
    var result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result >= 0){
        $('#oChild').val(result);
        addOnewayValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

$('.oInfant').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#oInfant').val();
    var parsed = parseInt(counter);
    var result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result >= 0){
        $('#oInfant').val(result);
        addOnewayValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

var return_sum = 1;

function addReturnValue(elemId) {
    return_sum = parseInt($('#rAdult').val()) + parseInt($('#rChild').val()) + parseInt($('#rInfant').val());
    var passenger = (return_sum > 1) ? ' Passengers' : ' Passenger';
    $('.return_final_count').text(`${return_sum}` + passenger);
}

$('.rAdult').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#rAdult').val();
    var parsed = parseInt(counter);
    var result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result !=0){
        $('#rAdult').val(result);
        addReturnValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

$('.rChild').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#rChild').val();
    var parsed = parseInt(counter);
    var result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result >= 0){
        $('#rChild').val(result);
        addReturnValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

$('.rInfant').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#rInfant').val();
    var parsed = parseInt(counter);
    var result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result >= 0){
        $('#rInfant').val(result);
        addReturnValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

var multi_sum = 1;

function addmultiValue(elemId) {
    multi_sum = parseInt($('#mAdult').val()) + parseInt($('#mChild').val()) + parseInt($('#mInfant').val());
    var passenger = (multi_sum > 1) ? ' Passengers' : ' Passenger';
    $('.multi_final_count').text(`${multi_sum}` + passenger);
}

$('.mAdult').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#mAdult').val();
    var parsed = parseInt(counter);
    var result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result !=0){
        $('#mAdult').val(result);
        addmultiValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

$('.mChild').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#mChild').val();
    var parsed = parseInt(counter);
    var result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result >= 0){
        $('#mChild').val(result);
        addmultiValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

$('.mInfant').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#mInfant').val();
    var parsed = parseInt(counter);
    var result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result >= 0){
        $('#mInfant').val(result);
        addmultiValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

$("#rForm").validate({
    rules: {
        rFrom: {
            required : true,
            minlength:3
        },
        rTo: {
            required : true,
            minlength:3
        },
        rDate: 'required',
        rReturnDate: 'required'
    },
   
    errorPlacement: function (error, element) {
        if(element.hasClass('select2')) {
            error.insertAfter(element.next('.select2-container'));
        }else{
            error.appendTo(element.parent("div"));
        }
    },
    submitHandler: function(form) {
        $('.ajaxloader').css('display','block');
        form.submit();
    }
});

var list = '<option value=""></option>'; 

// For Add or Remove Flight Multi City Option Start
let mCity = 2;
$("#addMulticityRow").on('click', (function () {
    generateMultiFields(mCity);
}))

function generateMultiFields(mCount){
    let a = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 5);

    if (document.querySelectorAll('.multi_city_form').length === 5) {
        alert("Max Citry Limit Reached!!")
        return;
    }
    
    mCity = mCity + 1;
    $(".multi_city_form_wrapper").append(`<div class="multi_city_form">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="flight_Search_boxed">
                                                    <p>From</p>
                                                   
                                                    <input type="text" name="mFrom[]"  placeholder="Enter Departure City" class="selectAirportFrom load_airports col-sm-12 " id="mFrom`+mCount+`">
                                                    <input type="hidden"  class="airport" name="mFrom_label`+mCount+`"  id="mFrom_label`+mCount+`">

                                                    <span class="place-label from_airport" id="mFrom_labels`+mCount+`"></span>
                                                    <div class="plan_icon_posation">
                                                        <i class="fas fa-plane-departure"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="flight_Search_boxed">
                                                    <p>To</p>
                                    
                                                    <input type="text" name="mTo[]" placeholder="Enter Destination City" class="selectAirportTo load_airports col-sm-12 " id="mTo`+mCount+`">
                                                    <input type="hidden"  class="airport" name="mTo_label`+mCount+`"  id="mTo_label`+mCount+`">
                                                    <span class="place-label to_airport" id="mTo_labels`+mCount+`"></span>
                                                    <div class="plan_icon_posation">
                                                        <i class="fas fa-plane-departure"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form_search_date">
                                                    <div class="flight_Search_boxed date_flex_area">
                                                        <div class="Journey_date">
                                                            <p>Journey date</p>
                                                            <input type="date" value="" class="travel_date" id="mDate`+mCount+`" name="mDate[]">
                                                            <span class="place-label day_label mDate_labels`+mCount+`" id=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2  col-md-6 col-sm-12 col-12 m-auto">
                                                <div class="multi_form_remove">
                                                    <button type="button"
                                                        id="remove_multi_city">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`);
        loadAutocomplete();
}
// Remove Button Click 
$(document).on('click', (function (e) {
    if (e.target.id === "remove_multi_city") {
        $(e.target).parent().closest('.multi_city_form').remove()
    }
}) );

$("#mForm").validate({
    rules: {
        'mFrom[]': {
            required : true,
            minlength:3
        },
        'mTo[]': {
            required : true,
            minlength:3
        },
        'mDate[]': 'required',
    },
    errorPlacement: function (error, element) {
        if(element.hasClass('select2')) {
            error.insertAfter(element.next('.select2-container'));
        }else{
            error.appendTo(element.parent("div"));
        }
    },
    submitHandler: function(form) {
        $('.ajaxloader').css('display','block');
        form.submit();
    }
});


$('.stopFilter').click(function () {
    var str ="";
    $('.stopFilter:checked').each(function()
    {
        str+= $(this).val()+",";
    });
    var type = $('#search_typeResult').val();
    if(type == "OneWay"){
        $('#ostop_filter').val(str);
    }else if(type == "Return"){
        $('#rstop_filter').val(str);
    }else if(type == "Circle"){
        $('#mstop_filter').val(str);
    }
    submitSearch();
});


$('.airlineFilter').click(function () {
    var airstr ="";
    $('.airlineFilter:checked').each(function()
    {
        airstr+= $(this).val()+",";
    });
    var type = $('#search_typeResult').val();
    if(type == "OneWay"){
        $('#oairline_filter').val(airstr);
    }else if(type == "Return"){
        $('#rairline_filter').val(airstr);
    }else if(type == "Circle"){
        $('#mairline_filter').val(airstr);
    }
    submitSearch();
});


$('.refundFilter').click(function () {
    var refundstr ="";
    $('.refundFilter:checked').each(function()
    {
        refundstr+= $(this).val()+",";
    });
   
    var type = $('#search_typeResult').val();
    if(type == "OneWay"){
        $('#orefund_filter').val(refundstr);
    }else if(type == "Return"){
        $('#rrefund_filter').val(refundstr);
    }else if(type == "Circle"){
        $('#mrefund_filter').val(refundstr);
    }
    submitSearch();
});

function submitSearch(str){
    var type = $('#search_typeResult').val();
    if(type == "OneWay"){
       $('#oFromForm').submit();
    }else if(type == "Return"){
        $('#rForm').submit();
    }else if(type == "Circle"){
        $('#mForm').submit();
    }
}

$('#searchTab a').click(function(e) {
    // e.preventDefault();
    $(this).tab('show');
});

$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;
});
  
function returnCheckFilter(){
    $('#rstop_filter').val('');
    $('#rairline_filter').val('');
    $('#rrefund_filter').val('');
    return true;
}
function oneWayCheckFilter(){
    $('#ostop_filter').val('');
    $('#oairline_filter').val('');
    $('#orefund_filter').val('');
    return true;
}
function multiCheckFilter(){
    $('#mstop_filter').val('');
    $('#mairline_filter').val('');
    $('#mrefund_filter').val('');
    return true;
}

$(document).on('click','.viewFlightDetails',function(){
    var id = $(this).attr('data-id');
    if($('#detialsView_'+id).hasClass('show')){
        $('#detialsView_'+id).removeClass('show');
    }else{
        $('.ajaxloader').css('display','block');
        var viewdata = { "_token": "{{ csrf_token() }}",
                        id : $(this).attr('data-id'),
                        session_id : $(this).attr('data-session_id'),
                        search_type : $(this).attr('data-search_type'),
                        fareCode : $(this).attr('data-fareCode')
                    }   
        $.ajax({
            url: ROUTES.flight_view_details,
            data: viewdata,
            success: function(response) {
                $('.ajaxloader').css('display','none');
                var resp = JSON.parse(response);
                if(resp.status == true){
                    $('#detialsView_'+id).html(resp.data);
                    $('#detialsView_'+id).addClass('show');
                    $('html, body').animate({
                        scrollTop: $('#detialsView_'+id).offset().top
                    }, 1000);
                }else{
                    swal({
                        title: "Not Available", 
                        text: "Flights fare may have changed. Please refresh the page.", 
                        icon: "warning"
                    }).then(function() {
                        window.location.reload();
                    });
                }
               
            }
        });
    }
});

$(document).on('click','.viewDomFlightDetails',function(){
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    var viewdata = { "_token": "{{ csrf_token() }}",
                        id : $(this).attr('data-id'),
                        session_id : $(this).attr('data-session_id'),
                        search_type : $(this).attr('data-search_type'),
                        fareCode : $(this).attr('data-fareCode')
                    }  

    if(type == 'return'){
        if($('#detialsDomReturnView_'+id).hasClass('show')){
            $('#detialsDomReturnView_'+id).removeClass('show');
        }else{
            $('.ajaxloader').css('display','block');
             
            $.ajax({
                url: ROUTES.flight_view_details,
                data: viewdata,
                success: function(response) {
                    $('.ajaxloader').css('display','none');
                    var resp = JSON.parse(response);
                    if(resp.status == true){
                        $('#detialsDomReturnView_'+id).html(resp.data);
                        $('#detialsDomReturnView_'+id).addClass('show');
                        $('html, body').animate({
                            scrollTop: $('#detialsDomReturnView_'+id).offset().top
                        }, 1000);
                    }else{
                        swal({
                            title: "Not Available", 
                            text: "Flights fare may have changed. Please refresh the page.", 
                            icon: "warning"
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                   
                }
            });
        }
    }else{
        if($('#detialsDomDepView_'+id).hasClass('show')){
            $('#detialsDomDepView_'+id).removeClass('show');
        }else{
            $('.ajaxloader').css('display','block');
             
            $.ajax({
                url: ROUTES.flight_view_details,
                data: viewdata,
                success: function(response) {
                    $('.ajaxloader').css('display','none');
                    var resp = JSON.parse(response);
                    if(resp.status == true){
                        $('#detialsDomDepView_'+id).html(resp.data);
                        $('#detialsDomDepView_'+id).addClass('show');
                        $('html, body').animate({
                            scrollTop: $('#detialsDomDepView_'+id).offset().top
                        }, 1000);
                    }else{
                        swal({
                            title: "Not Available", 
                            text: "Flights fare may have changed. Please refresh the page.", 
                            icon: "warning"
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                   
                }
            });
        }
    }
    
});

