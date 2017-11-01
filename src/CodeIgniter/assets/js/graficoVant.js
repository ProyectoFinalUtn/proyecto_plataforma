$(document).ready(function(){
	$.ajax({
		url: "Grafico_vant",
		method: "GET",
		success: function(data) {
			var datos = JSON.parse(data);
			var peso = [];
			var vant = [];
			var maxValue = 0;
			for(var i in datos) {
				peso.push(datos[i].peso);
				vant.push(datos[i].cantidadvant);
				if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
				}
			}
			maxValue = maxValue + 2;
			var chartdata = {
				labels: peso,
				datasets : [
					{
						label: 'Cantidad de VANT',
						backgroundColor: 'rgba(8, 59, 51, 0.9)',
						borderColor: 'rgba(0, 34, 29, 1)',
						hoverBackgroundColor: 'rgba(8, 59, 51, 1)',
						hoverBorderColor: 'rgba(0, 34, 29, 1)',
						data: vant
					}
				]
			};

			var ctx = $("#graficoPeso");

			var barGraph = new Chart(ctx, {
				type: 'bar',
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
							text: 'Cantidad de VANT por Peso'
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
		var ejeY = $("select[name='ejeY']").val();
		var filtro_desde = $("input[name='filtro_desde']").val();
		var filtro_hasta = $("input[name='filtro_hasta']").val();
		var filtro_provincia = $("select[name='filtro_provincia']").val();
		var filtro_localidad = $("select[name='filtro_localidad']").val();
		$.ajax({
			url: "Grafico_vant",
			method: "POST",
			data: { ejeX: ejeX, ejeY: ejeY, filtro_desde: filtro_desde, filtro_hasta: filtro_hasta, filtro_provincia: filtro_provincia, filtro_localidad: filtro_localidad },
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
					case 'peso':
						var peso = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].peso+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							peso.push(datos[i].peso);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Peso</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: peso,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoPeso" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoPeso");

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
										text: 'Cantidad de VANT por Peso'
									}
								}
						});
						break;
					
					case 'marca':
						var marca = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].marca+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							marca.push(datos[i].marca);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Marca</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: marca,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
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
										text: 'Cantidad de VANT por Marca'
									}
								}
						});
						break;
					
					case 'modelo':
						var modelo = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].modelo+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							modelo.push(datos[i].modelo);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Modelo</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: modelo,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
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
										text: 'Cantidad de VANT por Modelo'
									}
								}
						});
						break;
					
					case 'fabricante':
						var fabricante = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].fabricante+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							fabricante.push(datos[i].fabricante);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Fabricante</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: fabricante,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoFabricante" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoFabricante");

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
										text: 'Cantidad de VANT por Fabricante'
									}
								}
						});
						
						break;
						
					case 'lFab':
						var lugar_fabricacion = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].lugar_fabricacion+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							lugar_fabricacion.push(datos[i].lugar_fabricacion);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Lugar de Fabricación</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: lugar_fabricacion,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoOrigen" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoOrigen");

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
										text: 'Cantidad de VANT por Lugar de Fabricación'
									}
								}
						});
						
						break;
						
					case 'anioFab':
						var anio_fabricacion = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].anio_fabricacion+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							anio_fabricacion.push(datos[i].anio_fabricacion);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Año de Fabricación</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: anio_fabricacion,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoAnio" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoAnio");

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
										text: 'Cantidad de VANT por Año de Fabricación'
									}
								}
						});
						
						break;
						
					case 'altMax':
						var alt_max = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].alt_max+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							alt_max.push(datos[i].alt_max);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Altura Máxima</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: alt_max,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoAltMax" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoAltMax");

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
										text: 'Cantidad de VANT por Altura Máxima'
									}
								}
						});
						
						break;
						
					case 'velMax':
						var vel_max = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].vel_max+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							vel_max.push(datos[i].vel_max);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Velocidad Máxima</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: vel_max,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoVelMax" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoVelMax");

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
										text: 'Cantidad de VANT por Velocidad Máxima'
									}
								}
						});
						
						break;
					
					case 'alto':
						var alto = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].alto+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							alto.push(datos[i].alto);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Alto</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: alto,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoAlto" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoAlto");

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
										text: 'Cantidad de VANT por Alto del vehículo'
									}
								}
						});
						
						break;
						
					case 'ancho':
						var ancho = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].ancho+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							ancho.push(datos[i].ancho);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Ancho</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: ancho,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoAncho" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoAncho");

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
										text: 'Cantidad de VANT por Ancho del vehículo'
									}
								}
						});
						
						break;
						
					case 'largo':
						var largo = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].largo+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							largo.push(datos[i].largo);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Largo</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: largo,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoLargo" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoLargo");

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
										text: 'Cantidad de VANT por Largo del vehículo'
									}
								}
						});
						
						break;
					
					case 'color':
						var color = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].color+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							color.push(datos[i].color);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Color</th><th>Cantidad de VANT</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: color,
							datasets : [
								{
									label: 'Cantidad de VANT',
									backgroundColor: bgColor,
									borderColor: bdColor,
									hoverBackgroundColor: hoverBgColor,
									hoverBorderColor: hoverBdColor,
									pointBackgroundColor: pointBgColor,
									pointBorderColor: pointBdColor,
									data: vant
								}
							]
						};
						
						$('canvas').replaceWith('<canvas id="graficoColor" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoColor");

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
										text: 'Cantidad de VANT por Color del vehículo'
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
		var ejeY = $("select[name='ejeY']").val();
		var filtro_desde = $("input[name='filtro_desde']").val();
		var filtro_hasta = $("input[name='filtro_hasta']").val();
		var filtro_provincia = $("select[name='filtro_provincia']").val();
		var filtro_localidad = $("select[name='filtro_localidad']").val();
		$.ajax({
			url: "Grafico_vant",
			method: "POST",
			data: { ejeX: ejeX, ejeY: ejeY, filtro_desde: filtro_desde, filtro_hasta: filtro_hasta, filtro_provincia: filtro_provincia, filtro_localidad: filtro_localidad },
			success: function(data) {
				var datos = JSON.parse(data);
				var tab_text = '<table>';
				switch(ejeX) {
					case 'peso':
						tab_text = tab_text+'<tr><td>Peso</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].peso+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'marca':
						tab_text = tab_text+'<tr><td>Marca</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].marca+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'modelo':
						tab_text = tab_text+'<tr><td>Modelo</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].modelo+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'fabricante':
						tab_text = tab_text+'<tr><td>Fabricante</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].fabricante+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'lFab':
						tab_text = tab_text+'<tr><td>Origen</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].lugar_fabricacion+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'anioFab':
						tab_text = tab_text+'<tr><td>Año de Fabricación</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].anio_fabricacion+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'altMax':
						tab_text = tab_text+'<tr><td>Altura Máxima</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].alt_max+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'velMax':
						tab_text = tab_text+'<tr><td>Velocidad Máxima</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].vel_max+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'alto':
						tab_text = tab_text+'<tr><td>Alto</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].alto+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'ancho':
						tab_text = tab_text+'<tr><td>Ancho</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].ancho+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'largo':
						tab_text = tab_text+'<tr><td>Largo</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].largo+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'color':
						tab_text = tab_text+'<tr><td>Color</td><td>Cantidad de VANT</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].color+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
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
			url: "Listar_vant/obtener_localidades",
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
	
});