'use strict';

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

$(document).ready(function () {
    // Chart in Dashboard version 1
    var echartElemBar = document.getElementById('echartBar');
    if (echartElemBar) {
        var echartBar = echarts.init(echartElemBar);
        echartBar.setOption({
            legend: {
                borderRadius: 0,
                orient: 'horizontal',
                x: 'right',
                data: ['Заказы']
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
                data: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек'],
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
                max: 30000,
                interval: 5000,
                axisLine: {
                    show: false
                },
                splitLine: {
                    show: true,
                    interval: 'auto'
                }
            }],

            series: [{
                name: 'Online',
                data: [15000, 16000, 20000, 7000, 0, 0, 0, 0, 0, 0, 0, 0],
                label: { show: false, color: '#0168c1' },
                type: 'bar',
                barGap: 0,
                color: '#bcbbdd',
                smooth: true

            }]
        });
        $(window).on('resize', function () {
            setTimeout(function () {
                echartBar.resize();
            }, 500);
        });
    }

    // Chart in Dashboard version 1
    var echartElem1 = document.getElementById('echart1');
    if (echartElem1) {
        var echart1 = echarts.init(echartElem1);
        echart1.setOption(_extends({}, echartOptions.lineFullWidth, {
            series: [_extends({
                data: [30, 40, 20, 50, 40, 80, 90]
            }, echartOptions.smoothLine, {
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
                    color: '#663399'
                },
                itemStyle: {
                    color: '#663399'
                }
            })]
        }));
        $(window).on('resize', function () {
            setTimeout(function () {
                echart1.resize();
            }, 500);
        });
    }
    // Chart in Dashboard version 1
    var echartElem2 = document.getElementById('echart2');
    if (echartElem2) {
        var echart2 = echarts.init(echartElem2);
        echart2.setOption(_extends({}, echartOptions.lineFullWidth, {
            series: [_extends({
                data: [30, 10, 40, 10, 40, 20, 90]
            }, echartOptions.smoothLine, {
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
            })]
        }));
        $(window).on('resize', function () {
            setTimeout(function () {
                echart2.resize();
            }, 500);
        });
    }
    // Chart in Dashboard version 1
    var echartElem3 = document.getElementById('echart3');
    if (echartElem3) {
        var echart3 = echarts.init(echartElem3);
        echart3.setOption(_extends({}, echartOptions.lineNoAxis, {
            series: [{
                data: [40, 80, 20, 90, 30, 80, 40, 90, 20, 80, 30, 45, 50, 110, 90, 145, 120, 135, 120, 140],
                lineStyle: _extends({
                    color: 'rgba(102, 51, 153, 0.6)',
                    width: 8
                }, echartOptions.lineShadow),
                label: { show: true, color: '#212121' },
                type: 'line',
                smooth: true,
                itemStyle: {
                    borderColor: 'rgba(102, 51, 153, 1)'
                }
            }]
        }));
        $(window).on('resize', function () {
            setTimeout(function () {
                echart3.resize();
            }, 500);
        });
    }
});