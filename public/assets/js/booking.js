// $(document).on('click', '.addToCart', function () {

//     var form = $(this);
//     var formURL = form.data('action');

//     var search_id = form.data('search_id');
//     var LFID = form.data('lfid');
//     var FareTypeID = form.data('faretypeid');

//     $.ajaxSetup({
//         headers: {
//           'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
//         }
//       });
//     $.ajax({
//         type: "POST",
//         url: formURL,
//         data: {

//             search_id: form.data('search_id'),
//             LFID: form.data('lfid'),
//             FareTypeID: form.data('faretypeid'),
//         }, // serializes the form's elements.
//         success: function (data) {
//             alert(data); // show response from the php script.
//         }
//     });

// });