!function(){
	var dom = document.getElementById("chart");
	var myChart = echarts.init(dom);

	function kdraw(data){
		var app = {};
		var typename;
		option = null;
		// 数据意义：开盘(open)，收盘(close)，最低(lowest)，最高(highest)
		myChart.clear();
		var width = $('#chartbox').width();
		var hegiht = $('#chartbox').height();
		
		data0 = splitData(data);
		function splitData(rawData) {
			var categoryData = [];
			var values = []
			for (var i = 0; i < rawData.length; i++) {
				categoryData.push(rawData[i].splice(0, 1)[0]);
				values.push(rawData[i])
			}
			return {
				categoryData: categoryData,
				values: values
			};
		}

		function calculateMA(dayCount) {
			var result = [];
			for (var i = 0, len = data0.values.length; i < len; i++) {
				if (i < dayCount) {
					result.push('-');
					continue;
				}
				var sum = 0;
				for (var j = 0; j < dayCount; j++) {
					sum += data0.values[i - j][1];
				}
				result.push(sum / dayCount);
			}
			return result;
		}

		option = {
			title: {
				text: '',
				left: 0
			},
			tooltip: {
				trigger: 'axis',
				axisPointer: {
					type: 'line'
				}
			},
			legend: {
				data: [typename, 'MA5', 'MA10', 'MA20', 'MA30']
			},
			grid: {
				left: '10%',
				right: '10%',
				bottom: '15%'
			},
			xAxis: {
				type: 'category',
				data: data0.categoryData,
				scale: true,
				boundaryGap : false,
				axisLine: {onZero: false},
				splitLine: {show: false},
				splitNumber: 20,
				min: 'dataMin',
				max: 'dataMax'
			},
			yAxis: {
				scale: true,
				splitArea: {
					show: true
				}
			},
			dataZoom: [
				{
					type: 'inside',
					start: 50,
					end: 100
				},
				{
					show: true,
					type: 'slider',
					y: '90%',
					start: 50,
					end: 100
				}
			],
			series: [
				{
					name: typename,
					type: 'candlestick',
					data: data0.values,
					candlestick : {
						itemStyle : {
							normal: {
								color: '#14b547'
							}
						}
					},
					markPoint: {
						label: {
							normal: {
								formatter: function (param) {
									return param != null ? Math.round(param.value) : '';
								}
							}
						},
						data: [
							{
								name: 'XX标点',
								coord: ['2013/5/31', 2300],
								value: 2300,
								itemStyle: {
									normal: {color: 'rgb(41,60,85)'}
								}
							},
							{
								name: 'highest value',
								type: 'max',
								valueDim: 'highest'
							},
							{
								name: 'lowest value',
								type: 'min',
								valueDim: 'lowest'
							},
							{
								name: 'average value on close',
								type: 'average',
								valueDim: 'close'
							}
						],
						tooltip: {
							formatter: function (param) {
								return param.name + '<br>' + (param.data.coord || '');
							}
						}
					},
					markLine: {
						symbol: ['none', 'none'],
						data: [
							[
								{
									name: 'from lowest to highest',
									type: 'min',
									valueDim: 'lowest',
									symbol: 'circle',
									symbolSize: 10,
									label: {
										normal: {show: false},
										emphasis: {show: false}
									}
								},
								{
									type: 'max',
									valueDim: 'highest',
									symbol: 'circle',
									symbolSize: 10,
									label: {
										normal: {show: false},
										emphasis: {show: false}
									}
								}
							],
							{
								name: 'min line on close',
								type: 'min',
								valueDim: 'close'
							},
							{
								name: 'max line on close',
								type: 'max',
								valueDim: 'close'
							}
						]
					}
				},
				{
					name: 'MA5',
					type: 'line',
					data: calculateMA(5),
					smooth: true,
					lineStyle: {
						normal: {opacity: 0.5}
					}
				},
				{
					name: 'MA10',
					type: 'line',
					data: calculateMA(10),
					smooth: true,
					lineStyle: {
						normal: {opacity: 0.5}
					}
				},
				{
					name: 'MA20',
					type: 'line',
					data: calculateMA(20),
					smooth: true,
					lineStyle: {
						normal: {opacity: 0.5}
					}
				},
				{
					name: 'MA30',
					type: 'line',
					data: calculateMA(30),
					smooth: true,
					lineStyle: {
						normal: {opacity: 0.5}
					}
				},

			]
		};

		if (option && typeof option === "object") {
			myChart.setOption(option, true);
			myChart.hideLoading();
		}
	}
	var _this;
	var kdata;
	var run = {
		init : function(){
			_this = this;
			typename = '周k';
			this.tab();
			this.change('W');
			this.fullbtn();
			this.nofullbtn();
		},
		change : function(ktype){
			myChart.showLoading();
			$.getJSON('//kleyqq.com/index.php?m=shares&a=get_k_data&code='+ gpinfo.code +'&ktype='+ ktype, function(data){
				kdata = data;
				if(data.code == 0){
					alert(data.msg);
					return false;
				}
				kdraw(data);
			});
		},
		tab : function(){
			$('.tab .day').click(function(){
				typename = '日K';
				_this.change('D');
			});
			$('.tab .week').click(function(){
				typename = '周K';
				_this.change('W');
			});
			$('.tab .month').click(function(){
				typename = '月K';
				_this.change('M');
			});
		},
		fullbtn : function(){
			$('.gptable .tab').on('click', '#fullbtn', function(){
				$(this).attr('id','nofullbtn').text('退出全屏');
				$('#gptable_warp').addClass('full');
				myChart.resize();
			});
		},
		nofullbtn : function(){
			$('.gptable .tab').on('click', '#nofullbtn', function(){
				$(this).attr('id','fullbtn').text('全屏');
				$('#gptable_warp').removeClass('full');
				myChart.resize();
			});
		}
	}

	run.init();
}(jQuery);