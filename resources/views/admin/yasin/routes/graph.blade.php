@extends('admin.layouts.app')
@section('title', 'Agents')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <!-- <div class="title_left">
                <h3>Agents</h3>
            </div> -->
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <!-- <div class="x_title">
                        <h2>All Agents <small></small></h2>
                        
                        <div class="clearfix"></div>
                    </div> -->
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                <div id="container"></div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('header')
<style>
    
</style>
@endsection

@section('footer')
<script src="{{ asset('assets/js/highcharts.js') }}"></script>
<script src="https://code.highcharts.com/modules/treemap.js"></script>
<script src="https://code.highcharts.com/modules/treegraph.js"></script>
<script>



    
  console.log(JSON.parse('{!! $graph !!}'));

Highcharts.chart('container', {
    chart: {
        inverted: false,
        marginBottom: 170,
        marginRight: 20,
        height:1000
    },
    title: {
        text: 'Agents',
        align: 'left'
    },
    series: [
        {
            type: 'treegraph',
            data: JSON.parse('{!! $graph !!}'),
            tooltip: {
                pointFormat: '{point.name}'
            },
            dataLabels: {
                pointFormat: '{point.name}',
                style: {
                    whiteSpace: 'nowrap',
                    color: '#000000',
                    textOutline: '3px contrast'
                },
                crop: false
            },
            marker: {
                radius: 6
            },
            levels: [
                {
                    level: 1,
                    dataLabels: {
                        align: 'left',
                        x: 20
                    }
                },
                {
                    level: 2,
                    colorByPoint: true,
                    dataLabels: {
                        verticalAlign: 'bottom',
                        y: -20
                    }
                },
                {
                    level: 3,
                    colorVariation: {
                        key: 'brightness',
                        to: -0.5
                    },
                    dataLabels: {
                        align: 'left',
                        rotation: 90,
                        y: 20
                    }
                }
            ]
        }
    ]
});

</script>

@endsection