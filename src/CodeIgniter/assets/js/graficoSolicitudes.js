$(document).ready(function(){
	$.ajax({
		url: "Grafico_solicitudes",
		method: "GET",
		success: function(data) {
			var datos = JSON.parse(data);
			var estado = [];
			var cantidad = [];
			var maxValue = 0;
			for(var i in datos) {
				estado.push(datos[i].descripcion);
				cantidad.push(datos[i].cantidad);
				if (maxValue < parseInt(datos[i].cantidad)) {
								maxValue = parseInt(datos[i].cantidad);
				}
			}
			maxValue = maxValue + 2;
			var fondos = [];
			var bordes = [];
			for(var j in datos) {
				color = '#'+Math.floor(Math.random()*16777215).toString(16);
				fondos[j] = color;
				bordes[j] = "#ffffff";
			}
			var chartdata = {
				labels: estado,
				datasets : [
					{
						label: 'Cantidad de solicitudes',
						backgroundColor: fondos,
						borderColor: bordes,
						data: cantidad
					}
				]
			};

			var ctx = $("#graficoEstados");

			var barGraph = new Chart(ctx, {
				type: 'pie',
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
							text: 'Cantidad de Solicitudes por Estado de la Solicitud'
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
		var filtro_desde = $("input[name='filtro_desde']").val();
		var filtro_hasta = $("input[name='filtro_hasta']").val();
		var filtro_provincia = $("select[name='filtro_provincia']").val();
		var filtro_localidad = $("select[name='filtro_localidad']").val();
		$.ajax({
			url: "Grafico_solicitudes",
			method: "POST",
			data: { ejeX: ejeX, filtro_desde: filtro_desde, filtro_hasta: filtro_hasta, filtro_provincia: filtro_provincia, filtro_localidad: filtro_localidad }, 
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
						
						$('canvas').replaceWith('<canvas id="graficoFecha" width="400" height="200"></canvas>');
						
						var ctx = $("#graficoFecha");

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
						
						$('canvas').replaceWith('<canvas id="graficoMes" width="400" height="200"></canvas>');
						
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
						
						$('canvas').replaceWith('<canvas id="graficoDia" width="400" height="200"></canvas>');
						
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
						
						$('canvas').replaceWith('<canvas id="graficoHorario" width="400" height="200"></canvas>');
						
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
						
						$('canvas').replaceWith('<canvas id="graficoMarca" width="400" height="200"></canvas>');
						
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
						
						$('canvas').replaceWith('<canvas id="graficoModelo" width="400" height="200"></canvas>');
						
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
							$('table').append('<tr><td>'+datos[i].descripcion+'</td><td>'+datos[i].cantidad+'</td></tr>');
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
						
						$('canvas').replaceWith('<canvas id="graficoEstados" width="400" height="200"></canvas>');
						
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
						
						$('canvas').replaceWith('<canvas id="graficoMomentos" width="400" height="200"></canvas>');
						
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
					case 'provincia':
						var provincia = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].provincia+'</td><td>'+datos[i].cantidad+'</td></tr>');
							provincia.push(datos[i].provincia);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Provincia de la Ubicación Solicitada</th><th>Cantidad de Solicitudes</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: provincia,
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
						
						$('canvas').replaceWith('<canvas id="graficoProvincia" width="400" height="200"></canvas>');
						
						var ctx = $("#graficoProvincia");

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
										text: 'Cantidad de Solicitudes por Provincia de la Ubicación Solicitada'
									}
								}
						});
						break;
					case 'localidad':
						var localidad = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].localidad+'</td><td>'+datos[i].cantidad+'</td></tr>');
							localidad.push(datos[i].localidad);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Localidad de la Ubicación Solicitada</th><th>Cantidad de Solicitudes</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: localidad,
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
						
						$('canvas').replaceWith('<canvas id="graficoLocalidad" width="400" height="200"></canvas>');
						
						var ctx = $("#graficoLocalidad");

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
										text: 'Cantidad de Solicitudes por Localidad de la Ubicación Solicitada'
									}
								}
						});
						break;
					case 'zona_interes':
						var zona_interes = [];
						var cantidad = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].zona_interes+'</td><td>'+datos[i].cantidad+'</td></tr>');
							zona_interes.push(datos[i].zona_interes);
							cantidad.push(datos[i].cantidad);
							if (maxValue < parseInt(datos[i].cantidad)) {
											maxValue = parseInt(datos[i].cantidad);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Zona de Interés de la Ubicación Solicitada</th><th>Cantidad de Solicitudes</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: zona_interes,
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
						
						$('canvas').replaceWith('<canvas id="graficoZonainteres" width="400" height="200"></canvas>');
						
						var ctx = $("#graficoZonainteres");

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
										text: 'Cantidad de Solicitudes por Zona de Interés de la Ubicación Solicitada'
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
	
	$("button[name='Exportar']").click(function() {
		var ejeX = $("select[name='ejeX']").val();
		var filtro_desde = $("input[name='filtro_desde']").val();
		var filtro_hasta = $("input[name='filtro_hasta']").val();
		var filtro_provincia = $("select[name='filtro_provincia']").val();
		var filtro_localidad = $("select[name='filtro_localidad']").val();
		$.ajax({
			url: "Grafico_solicitudes",
			method: "POST",
			data: { ejeX: ejeX, filtro_desde: filtro_desde, filtro_hasta: filtro_hasta, filtro_provincia: filtro_provincia, filtro_localidad: filtro_localidad },
			success: function(data) {
				var datos = JSON.parse(data);
				var tab_text = '<table>';
				switch(ejeX) {
					case 'fecha':
						tab_text = tab_text+'<tr><td>Fecha Solicitada</td><td>Cantidad de Solicitudes</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].fecha_vuelo+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'mes':
						var mes = [];
						tab_text = tab_text+'<tr><td>Mes del Año</td><td>Cantidad de Solicitudes</td></tr>';
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
							tab_text = tab_text+'<tr><td>'+mes[i]+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'dia':
						var dia = [];
						tab_text = tab_text+'<tr><td>Día de la Semana</td><td>Cantidad de Solicitudes</td></tr>';
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
							tab_text = tab_text+'<tr><td>'+dia[i]+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'horario':
						tab_text = tab_text+'<tr><td>Horario Solicitado</td><td>Cantidad de Solicitudes</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].rango+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'marca':
						tab_text = tab_text+'<tr><td>Marca del VANT</td><td>Cantidad de Solicitudes</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].marca+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'modelo':
						tab_text = tab_text+'<tr><td>Modelo del VANT</td><td>Cantidad de Solicitudes</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].modelo+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'estado':
						tab_text = tab_text+'<tr><td>Estado de la Solicitud</td><td>Cantidad de Solicitudes</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].descripcion+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'momento':
						tab_text = tab_text+'<tr><td>Momento del Día</td><td>Cantidad de Solicitudes</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].descripcion+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'provincia':
						tab_text = tab_text+'<tr><td>Provincia de la Ubicacion Solicitada</td><td>Cantidad de Solicitudes</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].provincia+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'localidad':
						tab_text = tab_text+'<tr><td>Localidad de la Ubicacion Solicitada</td><td>Cantidad de Solicitudes</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].localidad+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
					case 'zona_interes':
						tab_text = tab_text+'<tr><td>Zona de Interes de la Ubicacion Solicitada</td><td>Cantidad de Solicitudes</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].zona_interes+'</td><td>'+datos[i].cantidad+'</td></tr>';
						}
						break;
				}
				tab_text = tab_text + '</table>';
				sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
	
	$("select[name='filtro_provincia']").change(function() {
		var prov_elegida = $("select[name='filtro_provincia']").val();
		$.ajax({
			url: "Info_solicitudes/obtener_localidades",
			method: "POST",
			data: { provincia: prov_elegida }, 
			success: function(data) {
				var localidades = JSON.parse(data);
				$("select[name='filtro_localidad']").replaceWith('<select name="filtro_localidad"><option value="0" selected="selected">Toda la provincia</option></select>');
				for(var i in localidades) {
					$("select[name='filtro_localidad']").append('<option value="'+localidades[i].id_localidad+'">'+localidades[i].localidad+'</option>');
				}
				$("select[name='filtro_localidad']").append('</select>');
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
	
	$("select[name='ejeX']").change(function() {
		var opcionElegida = $("select[name='ejeX']").val();
		switch(opcionElegida) {
			case 'fecha':
				$("option[value='line']").prop('selected', true);
				break;
			case 'mes':
				$("option[value='bar']").prop('selected', true);
				break;
			case 'dia':
				$("option[value='doughnut']").prop('selected', true);
				break;
			case 'horario':
				$("option[value='radar']").prop('selected', true);
				break;
			case 'momento':
				$("option[value='bar']").prop('selected', true);
				break;
			case 'marca':
				$("option[value='pie']").prop('selected', true);
				break;
			case 'modelo':
				$("option[value='doughnut']").prop('selected', true);
				break;
			case 'estado':
				$("option[value='pie']").prop('selected', true);
				break;
			case 'provincia':
				$("option[value='pie']").prop('selected', true);
				break;
			case 'localidad':
				$("option[value='pie']").prop('selected', true);
				break;
			case 'zona_interes':
				$("option[value='bar']").prop('selected', true);
				break;
		}
	});
	
});