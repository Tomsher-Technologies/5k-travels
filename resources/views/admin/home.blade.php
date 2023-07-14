@extends('admin.layouts.app')

@section('content')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Dashboard</h3>
            </div>
            <div class="title_right">

            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-sm-12 mb-15">
                <div class="col-sm-6 ">
                   
                    <input type="text" name="date_range" id="date_range" class="form-control w-50 pointer"
                        placeholder="DD/MM/YYYY - DD/MM/YYYY" value="">
                </div>
                <div class="col-sm-6 text-right">

                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 2%;">
            <div class="animated flipInY col-lg-2 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-plane"></i> </div>
                    <div class="count" id="booking_count">0</div>

                    <h3>Bookings</h3>
                    <!-- <p>Lorem ipsum psdea itgum rixt.</p> -->
                </div>
            </div>

            <div class="animated flipInY col-lg-2 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-users"></i> </div>
                    <div class="count" id="user_count">0</div>

                    <h3>New Users</h3>
                    <!-- <p>Lorem ipsum psdea itgum rixt.</p> -->
                </div>
            </div>

            <div class="animated flipInY col-lg-2 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-user"></i> </div>
                    <div class="count" id="agent_count">0</div>

                    <h3>New Agents</h3>
                    <!-- <p>Lorem ipsum psdea itgum rixt.</p> -->
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-4 col-sm-6 ">
                <div class="x_panel tile ">
                    
                    <div class="x_content">
                        <div id="all_users"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-6 ">
                <div class="x_panel tile ">
                    
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5 style="color:black"><b>Flight Bookings</b></h5>
                            </div>
                            <div class="col-sm-6 d-flex">
                                <select class="form-control w-50 pointer" name="agents" id="agents">
                                    @if($agents)
                                        <option value="" >Select Agent</option>
                                        @foreach ($agents as $agent )
                                            <option value="{{ $agent->id }}">{{ ucfirst(strtolower($agent->name)) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="text" name="flightdate_range" id="flightdate_range" class="form-control pointer w-40 ml-10 input-right " readonly placeholder="Select Year" value="{{ date('Y') }}">
                            </div>
                        </div>
                        <div id="monthChart" style="margin-top: 40px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('header')
<link href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection

@section('footer')
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/highcharts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    var today = getToday();

    function getToday() {
        var d = new Date();

        var month = d.getMonth() + 1;
        var day = d.getDate();

        var output = d.getFullYear() + '-' +
            (('' + month).length < 2 ? '0' : '') + month + '-' +
            (('' + day).length < 2 ? '0' : '') + day;

        return output;
    }

    getCounts(today, today);
    OverallSystemUsers();
    flightBookings('')

    $('#date_range').daterangepicker({
        // timePickerSeconds: true,
        autoApply: false,
        //startDate: "${defaultStart}",
        //endDate: "${defaultEnd}",
        // timePicker: true,
        locale: {
            format: 'DD/MM/YYYY'
        },
        ranges: {
            'Past 24 Hours': [moment().subtract(1, 'days'), moment()],
            'Today': [moment().startOf('day'), moment().endOf('day')],
            'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                'month')],
        }
    });
    $("#flightdate_range").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });
   

    $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        getCounts(startDate, endDate);
    });

    function getCounts(startDate, endDate) {
        $.ajax({
            url: "{{ route('dashboard-counts')}}",
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}",
                "start": startDate,
                "end": endDate
            },
            success: function(response) {
                var resp = JSON.parse(response);

                $('#booking_count').html(resp.data.bookings);
                $('#user_count').html(resp.data.users);
                $('#agent_count').html(resp.data.agents);
            }
        });
    }
    var all_usersChart =  Highcharts.chart('all_users', {
                                chart: {
                                    type: 'pie',
                                    options3d: {
                                        enabled: true,
                                        alpha: 45
                                    },
                                    height:'480px'
                                },
                                title: {
                                    text: 'Overall System Users',
                                    align: 'left'
                                },
                                plotOptions: {
                                    pie: {
                                        innerSize: 250,
                                        depth: 45,
                                        showInLegend: true,
                                        dataLabels: {
                                            enabled: true
                                        }
                                    }
                                },
                                series: [{
                                    name: 'Count',
                                    data: []
                                    
                                    // [
                                    //     ['Users', 16],
                                    //     ['Agents', 12],
                                    // ]
                                }],
                                credits: {
                                    enabled: false
                                }
                            });

    function OverallSystemUsers(){
        $.ajax({
            url: "{{ route('allusers-counts')}}",
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                var resp = JSON.parse(response);
                console.log(resp.data[0]);
                all_usersChart.series[0].setData([['Users', resp.data[0].user],['Agents', resp.data[0].agent]], true);
            }
        });  
    }

    var monthChart = Highcharts.chart('monthChart', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '',
                                align: 'left'
                            },
                            xAxis: {
                                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
                            },

                            plotOptions: {
                                series: {
                                    pointWidth: 20
                                }
                            },

                            series: [{
                                name:'Total Bookings',
                                color: 'green',
                                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0]
                            }]
    });

    $('#flightdate_range').datepicker().on('changeDate', function (ev) {
        $('#flightdate_range').datepicker('hide');
        var year = $(this).val();
        flightBookings(year)
    });

    function flightBookings(year){
        if(year == ''){
            var tod = new Date();
            year = tod.getFullYear();
        }
        var agentId = $('#agents').val();
        $.ajax({
            url: "{{ route('flightbooking-counts')}}",
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}", "year":year,"agentId" : agentId
            },
            success: function(response) {
                var resp = JSON.parse(response);
                console.log(resp);
                monthChart.xAxis[0].setCategories(resp.categories, true);
                monthChart.series[0].setData(resp.series, true);
            }
        });  
    }

    $(document).on('change','#agents',function(){
        var filterYear = $('#flightdate_range').val();
        flightBookings(filterYear)
    })

</script>
@endsection