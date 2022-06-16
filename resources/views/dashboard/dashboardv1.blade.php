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
                                <p class="text-primary text-24 line-height-1 mb-2">78</p>
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
                                <p class="text-primary text-24 line-height-1 mb-2">3948</p>
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
                                <p class="text-primary text-24 line-height-1 mb-2">загрузка</p>
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
                            <div class="text-muted">За последний месяц</div>
                            <p class="mb-4 text-primary text-24">загрузка</p>
                        </div>
                        <div id="echart1" style="height: 260px;"></div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card card-chart-bottom o-hidden mb-4">
                        <div class="card-body">
                            <div class="text-muted">За последнюю неделю</div>
                            <p class="mb-4 text-warning text-24">загрузка</p>
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
     <script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>

@endsection
