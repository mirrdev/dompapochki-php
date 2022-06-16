@extends('layouts.master')
@section('main-content')
           <div class="breadcrumb">
                <h1>{{ trans('panel.dashboard') }}</h1>
            </div>

            <div class="separator-breadcrumb border-top"></div>

            <div class="row">
                <!-- ICON BG -->
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Add-User"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Товаров</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$info['countProducts']}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Checkout-Basket"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Покупок</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$info['countOrders']}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Money-2"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Сумма</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$sum['all']}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">Продажи за год</div>
                            <div id="echartBar" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

           <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card card-chart-bottom o-hidden mb-4">
                        <div class="card-body">
                            <div class="text-muted">За 30 дней</div>
                            <p class="mb-4 text-primary text-24">{{$sum['month']}} руб</p>
                        </div>
                        <div id="echart1" style="height: 260px;"></div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card card-chart-bottom o-hidden mb-4">
                        <div class="card-body">
                            <div class="text-muted">За неделю</div>
                            <p class="mb-4 text-warning text-24">{{$sum['weak']}} руб</p>
                        </div>
                        <div id="echart2" style="height: 260px;"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <h5 class="card-title m-0 p-3">За последние 20 дней</h5>
                            <div id="echart3" style="height: 360px;"></div>
                        </div>
                    </div>
                </div>

            </div>


@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script type="application/javascript">
         $(document).ready(function() {

             // Chart in Dashboard version 1
             let echartElemBar = document.getElementById('echartBar');
             if (echartElemBar) {
                 let echartBar = echarts.init(echartElemBar);
                 echartBar.setOption({
                     legend: {
                         borderRadius: 0,
                         orient: 'horizontal',
                         x: 'right',
                         data: ['продажи']
                     },
                     grid: {
                         left: '8px',
                         right: '8px',
                         bottom: '0',
                         containLabel: true
                     },
                     tooltip: {
                         show: true,
                         backgroundColor: 'rgba(0, 0, 0, .8)'
                     },
                     xAxis: [{
                         type: 'category',
                         data: [{!! $data['months'] !!}],
                         axisTick: {
                             alignWithLabel: true
                         },
                         splitLine: {
                             show: false
                         },
                         axisLine: {
                             show: true
                         }
                     }],
                     yAxis: [{
                         type: 'value',
                         axisLabel: {
                             formatter: '{value} руб'
                         },
                         min: 0,
                         max: 20000,
                         interval: 4000,
                         axisLine: {
                             show: false
                         },
                         splitLine: {
                             show: true,
                             interval: 'auto'
                         }
                     }

                     ],

                     series: [{
                         name: 'продажи',
                         data: [{{$data['year']}}],
                         label: { show: false, color: '#0168c1' },
                         type: 'bar',
                         barGap: 0,
                         color: '#bcbbdd',
                         smooth: true,

                     }
                     ]
                 });
                 $(window).on('resize', function() {
                     setTimeout(() => {
                         echartBar.resize();
                     }, 500);
                 });
             }

             // Chart in Dashboard version 1
             let echartElem1 = document.getElementById('echart1');
             if (echartElem1) {
                 let echart1 = echarts.init(echartElem1);
                 echart1.setOption({
                     ...echartOptions.lineFullWidth,
                     ... {
                         series: [{
                             data: [{{$data['month']}}],
                             ...echartOptions.smoothLine,
                             markArea: {
                                 label: {
                                     show: true
                                 }
                             },
                             areaStyle: {
                                 color: 'rgba(102, 51, 153, .2)',
                                 origin: 'start'
                             },
                             lineStyle: {
                                 color: '#663399',
                             },
                             itemStyle: {
                                 color: '#663399'
                             }
                         }]
                     }
                 });
                 $(window).on('resize', function() {
                     setTimeout(() => {
                         echart1.resize();
                     }, 500);
                 });
             }
             // Chart in Dashboard version 1
             let echartElem2 = document.getElementById('echart2');
             if (echartElem2) {
                 let echart2 = echarts.init(echartElem2);
                 echart2.setOption({
                     ...echartOptions.lineFullWidth,
                     ... {
                         series: [{
                             data: [{{$data['weak']}}],
                             ...echartOptions.smoothLine,
                             markArea: {
                                 label: {
                                     show: true
                                 }
                             },
                             areaStyle: {
                                 color: 'rgba(255, 193, 7, 0.2)',
                                 origin: 'start'
                             },
                             lineStyle: {
                                 color: '#FFC107'
                             },
                             itemStyle: {
                                 color: '#FFC107'
                             }
                         }]
                     }
                 });
                 $(window).on('resize', function() {
                     setTimeout(() => {
                         echart2.resize();
                     }, 500);
                 });
             }
             // Chart in Dashboard version 1
             let echartElem3 = document.getElementById('echart3');
             if (echartElem3) {
                 let echart3 = echarts.init(echartElem3);
                 echart3.setOption({
                     ...echartOptions.lineNoAxis,
                     ... {
                         series: [{
                             data: [{{$data['day20']}}],
                             lineStyle: {
                                 color: 'rgba(102, 51, 153, 0.6)',
                                 width: 8,
                                 ...echartOptions.lineShadow
                             },
                             label: { show: true, color: '#212121' },
                             type: 'line',
                             smooth: true,
                             itemStyle: {
                                 borderColor: 'rgba(102, 51, 153, 1)'
                             }
                         }]
                     }
                 });
                 $(window).on('resize', function() {
                     setTimeout(() => {
                         echart3.resize();
                     }, 500);
                 });
             }

         });
     </script>

@endsection
