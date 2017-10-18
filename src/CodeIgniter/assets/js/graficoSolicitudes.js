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
							text: 'Cantidad de Solicitudes por Fecha Solicitada'
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
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].fecha_vuelo+'</td><td>'+datos[i].cantidad+'</td></tr>');
							fecha.push(datos[i].fecha_vuelo);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Fecha Solicitada</th><th>Cantidad de Solicitudes</th></tr></thead>');
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
										text: 'Cantidad de Solicitudes por Fecha Solicitada'
									}
								}
						});
						break;
					case 'mes':
						var mes = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							switch(datos[i].mes) {
								case '1':
									mes.push('Enero');
									break;
								case '2':
									mes.push('Febrero');
									break;
								case '3':
									mes.push('Marzo');
									break;
								case '4':
									mes.push('Abril');
									break;
								case '5':
									mes.push('Mayo');
									break;
								case '6':
									mes.push('Junio');
									break;
								case '7':
									mes.push('Julio');
									break;
								case '8':
									mes.push('Agosto');
									break;
								case '9':
									mes.push('Septiembre');
									break;
								case '10':
									mes.push('Octubre');
									break;
								case '11':
									mes.push('Noviembre');
									break;
								case '12':
									mes.push('Diciembre');
									break;
							}
							$('table').append('<tr><td>'+mes[i]+'</td><td>'+datos[i].cantidad+'</td></tr>');
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Mes del Año</th><th>Cantidad de Solicitudes</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: mes,
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
						
						$('canvas').replaceWith('<canvas id="graficoMes" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoMes");

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
										text: 'Cantidad de Solicitudes por Mes del Año'
									}
								}
						});
						break;
					case 'dia':
						var dia = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							switch(datos[i].dia) {
								case '0':
									dia.push('Domingo');
									break;
								case '1':
									dia.push('Lunes');
									break;
								case '2':
									dia.push('Martes');
									break;
								case '3':
									dia.push('Miércoles');
									break;
								case '4':
									dia.push('Jueves');
									break;
								case '5':
									dia.push('Viernes');
									break;
								case '6':
									dia.push('Sábado');
									break;
							}
							cantidad.push(datos[i].cantidad);
							$('table').append('<tr><td>'+dia[i]+'</td><td>'+datos[i].cantidad+'</td></tr>');
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Día de la Semana</th><th>Cantidad de Solicitudes</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: dia,
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
						
						$('canvas').replaceWith('<canvas id="graficoDia" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoDia");

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
										text: 'Cantidad de Solicitudes por Día de la Semana'
									}
								}
						});
						break;
					case 'horario':
						var horario = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].rango+'</td><td>'+datos[i].cantidad+'</td></tr>');
							horario.push(datos[i].rango);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Horario</th><th>Cantidad de Solicitudes</th></tr></thead>');
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
					case 'marca':
						var marca = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].marca+'</td><td>'+datos[i].cantidad+'</td></tr>');
							marca.push(datos[i].marca);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Marca del VANT</th><th>Cantidad de Solicitudes</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: marca,
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
						
						$('canvas').replaceWith('<canvas id="graficoMarca" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoMarca");

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
										text: 'Cantidad de Solicitudes por Marca del VANT Solicitante'
									}
								}
						});
						break;
					case 'modelo':
						var modelo = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].modelo+'</td><td>'+datos[i].cantidad+'</td></tr>');
							modelo.push(datos[i].modelo);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Modelo del VANT</th><th>Cantidad de Solicitudes</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: modelo,
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
						
						$('canvas').replaceWith('<canvas id="graficoModelo" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoModelo");

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
										text: 'Cantidad de Solicitudes por Modelo del VANT Solicitante'
									}
								}
						});
						break;
					case 'estado':
						var estado = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].estado+'</td><td>'+datos[i].cantidad+'</td></tr>');
							estado.push(datos[i].descripcion);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Estado de la Solicitud</th><th>Cantidad de Solicitudes</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: estado,
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
						
						$('canvas').replaceWith('<canvas id="graficoEstados" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoEstados");

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
										text: 'Cantidad de Solicitudes por Estados de Solicitud'
									}
								}
						});
						break;
					case 'momento':
						var momento = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].descripcion+'</td><td>'+datos[i].cantidad+'</td></tr>');
							momento.push(datos[i].descripcion);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Momento del Día</th><th>Cantidad de Solicitudes</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: momento,
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
						
						$('canvas').replaceWith('<canvas id="graficoMomentos" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoMomentos");

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
										text: 'Cantidad de Solicitudes por Momento del Día Solicitado'
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