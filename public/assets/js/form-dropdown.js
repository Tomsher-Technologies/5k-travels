var one_way_sum = 1;

function addOnewayValue(elemId) {
    one_way_sum = (elemId == 'plus') ? parseInt(one_way_sum)+1  : parseInt(one_way_sum)-1;
    var passenger = (one_way_sum > 1) ? ' Passengers' : ' Passenger';
    $('.one_way_final_count').text(`${one_way_sum}` + passenger);
}

$('.oAdult').on('click touchstart', function (event) {
    var elemId = $(this).attr('id');
    var counter =  $('#oAdult').val();
    var parsed = parseInt(counter);
    let result = elemId == "minus" ? parsed - 1 : parsed + 1;
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
    let result = elemId == "minus" ? parsed - 1 : parsed + 1;
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
    let result = elemId == "minus" ? parsed - 1 : parsed + 1;
    if(result >= 0){
        $('#oInfant').val(result);
        addOnewayValue(elemId);
    }
    event.stopPropagation();
    event.preventDefault();
});

















$('.btn-add,.btn-subtract').on('click touchstart', function () {

    const qadult = $('#f-qadult').val();
    const qchild = $('#f-qchild').val();
    const qinfant = $('#f-qinfant').val();

    $('.qstring').text(` ${qadult} Adults - ${qchild} Childs - ${qinfant} Infants`);
    event.stopPropagation();
    event.preventDefault();
});








$('.btn-subtract').on('click touchstart', function () {
    if (i == 1) {
        $('.pcount').val(1);
        addValue(1);

    } else {
        const value = --i;
        $('.pcount').val(`${value}`);
        addValue(value);
    }
    event.stopPropagation();
    event.preventDefault();
});


$('.btn-add-c').on('click touchstart', function () {
    const value = ++i;
    $('.ccount').text(`${value}`);
    addValue(value);
    event.stopPropagation();
    event.preventDefault();
});


$('.btn-subtract-c').on('click touchstart', function () {
    if (i == 1) {
        $('.ccount').text(1);
        addValue(1);
    } else {
        const value = --i;
        $('.ccount').text(`${value}`);
        addValue(value);
    }
    event.stopPropagation();
    event.preventDefault();
});



$('.btn-add-in').on('click touchstart', function () {
    const value = ++i;
    $('.incount').text(`${value}`);
    addValue(value);
    event.stopPropagation();
    event.preventDefault();
});


$('.btn-subtract-in').on('click touchstart', function () {
    if (i == 1) {
        $('.incount').text(1);
        addValue(1);
    } else {
        const value = --i;
        $('.incount').text(`${value}`);
        addValue(value);
    }
    event.stopPropagation();
    event.preventDefault();
});



