$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});

$(document).ready(function () {
    initailizeSelect2(); 

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
        $('#oFrom').val(one_way_session.oFrom).trigger('change');
        $('#oTo').val(one_way_session.oTo).trigger('change');
        $('#oDate').val(one_way_session.oDate).trigger('change');
    }
    if(return_session){
        $('#rFrom').val(return_session.rFrom).trigger('change');
        $('#rTo').val(return_session.rTo).trigger('change');
        $('#rDate').val(return_session.rDate).trigger('change');
        $('#rReturnDate').val(return_session.rReturnDate).trigger('change');
    }

    if(multi_session){
        let fromPlacesCount = (multi_session.mFrom).length;
        for (let step = 0; step < fromPlacesCount; step++) {
            if(step >=2){
                generateMultiFields(step);
            }
            
            $('#mFrom'+step).val(multi_session.mFrom[step]).trigger('change');
            $('#mTo'+step).val(multi_session.mTo[step]).trigger('change');
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


function initailizeSelect2(){
    $('.selectAirportFrom').select2({
        placeholder: 'From',
        selectOnClose: true,
        templateResult: templateResults,
        templateSelection: formatState
    });

    $('.selectAirportTo').select2({
        placeholder: 'To',
        selectOnClose: true,
        templateResult: templateResults,
        templateSelection: formatState
    });

    function templateResults(state) {
        if (!state.id) {
          return state.text;
        }
        var html = '<div class="row"><div class="col-sm-1">'+
        '<i class="fa fa-plane"></i>'+
        '</div><div class="col-sm-10">'+
        '<b>'+$(state.element).attr('data-city')+', '+$(state.element).attr('data-country')+'</b>'+
        '<span class="float-end">'+$(state.element).attr('data-airportCode')+'</span>'+
        '</div><div class="col-sm-10 offset-sm-1"><small>'+$(state.element).attr('data-airportName')+'</small></div></div>';
        return $(html);
    };

    function formatState(state) {
        if (!state.id) {
          return state.text;
        }
        return $(state.element).attr('data-title');
    };

}


$('.selectAirportFrom').on("change", function(e) { 
   $(this).parent().find('span.from_airport').text($(this).find(':selected').attr('data-airportCode')+' - '+$(this).find(':selected').attr('data-airportName'));
 });

$('.selectAirportTo').on("change", function(e) { 
    $(this).parent().find('span.to_airport').text($(this).find(':selected').attr('data-airportCode')+' - '+$(this).find(':selected').attr('data-airportName'));
 });


$("#oFromForm").validate({
    rules: {
        oFrom: 'required',
        oTo: 'required',
        oDate: 'required'
    },
    messages: {
        oFrom: 'This field is required',
        oTo: 'This field is required',
        oDate: 'This field is required',
    },
    errorPlacement: function (error, element) {
        if(element.hasClass('select2')) {
            error.insertAfter(element.next('.select2-container'));
        }else{
            error.appendTo(element.parent("div"));
        }
    },
    submitHandler: function(form) {
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
        rFrom: 'required',
        rTo: 'required',
        rDate: 'required',
        rReturnDate: 'required'
    },
    messages: {
        rFrom: 'This field is required',
        rTo: 'This field is required',
        rDate: 'This field is required',
        rReturnDate: 'This field is required',
    },
    errorPlacement: function (error, element) {
        if(element.hasClass('select2')) {
            error.insertAfter(element.next('.select2-container'));
        }else{
            error.appendTo(element.parent("div"));
        }
    },
    submitHandler: function(form) {
        form.submit();
    }
});

var list = '<option value=""></option>'; 
$.each(airportsList , function(index, val) { 
    list += '<option value="'+val.AirportCode+'" data-city="'+val.City+'" data-country="'+val.Country+'" data-airportCode="'+val.AirportCode+'"  data-airportName="'+val.AirportName+'" data-title="'+val.City+', '+val.Country+'">'+val.City+', '+val.Country+', '+val.AirportCode+', '+val.AirportName+' </option>';
});
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
                                                    <select name="mFrom[]" class="selectAirportFrom col-sm-12 " id="mFrom`+mCount+`">
                                                    `+list+`
                                                    </select>
                                                    <span class="place-label from_airport" id="mFrom_label"></span>
                                                    <div class="plan_icon_posation">
                                                        <i class="fas fa-plane-departure"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="flight_Search_boxed">
                                                    <p>To</p>
                                                    <select name="mTo[]" class="selectAirportTo col-sm-12 " id="mTo`+mCount+`">
                                                    `+list+`
                                                    </select>
                                                    <span class="place-label to_airport" id="mTo_label"></span>
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
                                                            <span class="place-label day_label mDate_label`+mCount+`" id=""></span>
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
        initailizeSelect2();

}
// Remove Button Click 
$(document).on('click', (function (e) {
    if (e.target.id === "remove_multi_city") {
        $(e.target).parent().closest('.multi_city_form').remove()
    }
}) );

$("#mForm").validate({
    rules: {
        'mFrom[]': 'required',
        'mTo[]': 'required',
        'mDate[]': 'required',
    },
    messages: {
        'mFrom[]': 'This field is required',
        'mTo[]': 'This field is required',
        'mDate[]': 'This field is required',
    },
    errorPlacement: function (error, element) {
        if(element.hasClass('select2')) {
            error.insertAfter(element.next('.select2-container'));
        }else{
            error.appendTo(element.parent("div"));
        }
    },
    submitHandler: function(form) {
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
    e.preventDefault();
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
