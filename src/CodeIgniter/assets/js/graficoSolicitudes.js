$(document).ready(function(){
	$.ajax({
		url: "Grafico_solicitudes",
		method: "GET",
		success: function(data) {
			var datos = JSON.parse(data);
			var fecha = [];
			var cantidad = [];
			var maxValue = 0;
			for(var i in datos) {
				fecha.push(datos[i].fecha_vuelo);
				cantidad.push(datos[i].cantidad);
				if (maxValue < parseInt(datos[i].cantidad)) {
								maxValue = parseInt(datos[i].cantidad);
				}
			}
			maxValue = maxValue + 2;
			var chartdata = {
				labels: fecha,
				datasets : [
					{
						label: 'Cantidad de solicitudes',
						borderColor: 'rgba(0, 34, 29, 1)',
						hoverBorderColor: 'rgba(0, 34, 29, 1)',
						pointBackgroundColor: 'rgba(8, 59, 51, 0.9)',
						pointBorderColor: 'rgba(0, 34, 29, 1)',
						data: cantidad
					}
				]
			};

			var ctx = $("#graficoFecha");

			var barGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata,
				options: {
						scales: {
							xAxes: [{
									ticks: {
										callback: function(value) { 
											return new Date(value).toLocaleDateString('es-AR'); 
										},
									}
							}],
							yAxes: [{
								ticks: {
									beginAtZero:true,
									max: maxValue
								}
							}]
						},
						legend: {
							labels: {
								fontFamily: 'Montserrat'
							}
						},
						title: {
							display: true,
							fontFamily: 'Montserrat',
							text: 'Cantidad de Solicitudes por Fecha'
						}
					}
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
	
	$("button[name='Calcular']").click(function() {
		var ejeX = $("select[name='ejeX']").val();
		$.ajax({
			url: "Grafico_solicitudes",
			method: "POST",
			data: { ejeX: ejeX }, 
			success: function(data) {
				var datos = JSON.parse(data);
				var chartType = $("select[name='tipoGrafico']").val();
				
				switch(chartType) {
					case 'bar':
						var bgColor = 'rgba(8, 59, 51, 0.9)';
						var bdColor = 'rgba(0, 34, 29, 1)';
						var hoverBgColor = 'rgba(8, 59, 51, 1)';
						var hoverBdColor = 'rgba(0, 34, 29, 1)';
						var pointBgColor = '';
						var pointBdColor = '';
						break;
					case 'line':
						var bgColor = '';
						var bdColor = 'rgba(0, 34, 29, 1)';
						var hoverBgColor = '';
						var hoverBdColor = 'rgba(0, 34, 29, 1)';
						var pointBgColor = 'rgba(8, 59, 51, 0.9)';
						var pointBdColor = 'rgba(0, 34, 29, 1)';
						break;
					case 'radar':
						var bgColor = '';
						var bdColor = 'rgba(0, 34, 29, 1)';
						var hoverBgColor = '';
						var hoverBdColor = 'rgba(0, 34, 29, 1)';
						var pointBgColor = 'rgba(8, 59, 51, 0.9)';
						var pointBdColor = 'rgba(0, 34, 29, 1)';
						break;
					case 'pie':
						var bgColor = [];
						var bdColor = [];
						var hoverBgColor = [];
						var hoverBdColor = [];
						for(var j in datos) {
							color = '#'+Math.floor(Math.random()*16777215).toString(16);
							bgColor[j] = color;
							bdColor[j] = "#ffffff";
						}
						var pointBgColor = [];
						var pointBdColor = [];
						break;
					case 'doughnut':
						var bgColor = [];
						var bdColor = [];
						var hoverBgColor = [];
						var hoverBdColor = [];
						for(var j in datos) {
							color = '#'+Math.floor(Math.random()*16777215).toString(16);
							bgColor[j] = color;
							bdColor[j] = "#ffffff";
						}
						var pointBgColor = [];
						var pointBdColor = [];
						break;
				}
				switch(ejeX) {
					case 'fecha':
						var fecha = [];
						var cantidad = [];
						var maxValue = 0;
						for(var i in datos) {
							fecha.push(datos[i].fecha_vuelo);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						maxValue = maxValue + 2;
						var chartdata = {
							labels: fecha,
							datasets : [
								{
									label: 'Cantidad de solicitudes',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: cantidad
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoFecha" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoFecha");

						var barGraph = new Chart(ctx, {
							type: chartType,
							data: chartdata,
							options: {
									scales: {
										xAxes: [{
											ticks: {
												callback: function(value) { 
													return new Date(value).toLocaleDateString('es-AR'); 
												},
											}
										}],
										yAxes: [{
											ticks: {
												beginAtZero:true,
												max: maxValue
											}
										}]
									},
									legend: {
										labels: {
											fontFamily: 'Montserrat'
										}
									},
									title: {
										display: true,
										fontFamily: 'Montserrat',
										text: 'Cantidad de Solicitudes por Fecha'
									}
								}
						});
						break;
					case 'horario':
						console.log(datos);
						var horario = [];
						var cantidad = [];
						var maxValue = 0;
						for(var i in datos) {
							horario.push(datos[i].rango);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						maxValue = maxValue + 2;
						var chartdata = {
							labels: horario,
							datasets : [
								{
									label: 'Cantidad de solicitudes',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: cantidad
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoHorario" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoHorario");

						var barGraph = new Chart(ctx, {
							type: chartType,
							data: chartdata,
							options: {
									scales: {
										xAxes: [{
											ticks: {
												beginAtZero:true
											}
										}],
										yAxes: [{
											ticks: {
												beginAtZero:true,
												max: maxValue
											}
										}]
									},
									legend: {
										labels: {
											fontFamily: 'Montserrat'
										}
									},
									title: {
										display: true,
										fontFamily: 'Montserrat',
										text: 'Cantidad de Solicitudes por Horario Solicitado'
									}
								}
						});
						break;
				}
				
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
});