$(document).ready(function(){
	$.ajax({
		url: "Grafico_usuarios",
		method: "GET",
		success: function(data) {
			var datos = JSON.parse(data);
			var edad = [];
			var vant = [];
			var maxValue = 0;
			for(var i in datos) {
				edad.push(datos[i].edad);
				vant.push(datos[i].cantidadvant);
				if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
				}
			}
			maxValue = maxValue + 2;
			var chartdata = {
				labels: edad,
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

			var ctx = $("#graficoEdad");

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
							text: 'Cantidad de VANT por Edad'
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
		var titulo = 'VANT';
		if (ejeY == 'vuelos') {
			var titulo = 'Vuelos';
		}
		$.ajax({
			url: "Grafico_usuarios",
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
					case 'sexo':
						var sexo = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].sexo+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							sexo.push(datos[i].sexo);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Sexo</th><th>Cantidad de '+titulo+'</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: sexo,
							datasets : [
								{
									label: 'Cantidad de '+titulo,
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
						
						$('canvas').replaceWith('<canvas id="graficoSe" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoSe");

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
										text: 'Cantidad de '+titulo+' por Sexo'
									}
								}
						});
						break;
					case 'localidad':
						var localidad = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].localidad+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							localidad.push(datos[i].localidad);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Localidad</th><th>Cantidad de '+titulo+'</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: localidad,
							datasets : [
								{
									label: 'Cantidad de '+titulo,
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
						
						$('canvas').replaceWith('<canvas id="graficoLoc" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoLoc");

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
										text: 'Cantidad de '+titulo+' por Localidad'
									}
								}
						});
						break;
					case 'provincia':
						var provincia = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].provincia+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							provincia.push(datos[i].provincia);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Provincia</th><th>Cantidad de '+titulo+'</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: provincia,
							datasets : [
								{
									label: 'Cantidad de '+titulo,
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
						
						$('canvas').replaceWith('<canvas id="graficoProv" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoProv");

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
										text: 'Cantidad de '+titulo+' por Provincia'
									}
								}
						});
						break;
					case 'zona_interes':
						var zona_interes = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].zona_interes+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							zona_interes.push(datos[i].zona_interes);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Zona de Interés</th><th>Cantidad de '+titulo+'</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: zona_interes,
							datasets : [
								{
									label: 'Cantidad de '+titulo,
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
						
						$('canvas').replaceWith('<canvas id="graficoZona" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoZona");

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
										text: 'Cantidad de '+titulo+' por Zona de Interés'
									}
								}
						});
						break;
					case 'edad':
						var edad = [];
						var vant = [];
						var maxValue = 0;
						$('table').replaceWith('<table></table>');
						for(var i in datos) {
							$('table').append('<tr><td>'+datos[i].edad+'</td><td>'+datos[i].cantidadvant+'</td></tr>');
							edad.push(datos[i].edad);
							vant.push(datos[i].cantidadvant);
							if (maxValue < parseInt(datos[i].cantidadvant)) {
								maxValue = parseInt(datos[i].cantidadvant);
							}
						}
						$('table').append('<thead id="header" style="background-color: #004ea2; color:#ffffff;"><tr id="headers"><th>Edad</th><th>Cantidad de '+titulo+'</th></tr></thead>');
						maxValue = maxValue + 2;
						var chartdata = {
							labels: edad,
							datasets : [
								{
									label: 'Cantidad de '+titulo,
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
						
						$('canvas').replaceWith('<canvas id="graficoEdad" width="400" height="100"></canvas>');
						
						var ctx = $("#graficoEdad");

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
										text: 'Cantidad de '+titulo+' por Edad'
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
		var titulo = 'VANT';
		if (ejeY == 'vuelos') {
			var titulo = 'Vuelos';
		}
		$.ajax({
			url: "Grafico_usuarios",
			method: "POST",
			data: { ejeX: ejeX, ejeY: ejeY, filtro_desde: filtro_desde, filtro_hasta: filtro_hasta, filtro_provincia: filtro_provincia, filtro_localidad: filtro_localidad },
			success: function(data) {
				var datos = JSON.parse(data);
				var tab_text = '<table>';
				switch(ejeX) {
					case 'edad':
						tab_text = tab_text+'<tr><td>Edad</td><td>Cantidad de '+titulo+'</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].edad+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'sexo':
						tab_text = tab_text+'<tr><td>Sexo</td><td>Cantidad de '+titulo+'</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].sexo+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'localidad':
						tab_text = tab_text+'<tr><td>Localidad</td><td>Cantidad de '+titulo+'</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].localidad+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
						}
						break;
					case 'provincia':
						tab_text = tab_text+'<tr><td>Provincia</td><td>Cantidad de '+titulo+'</td></tr>';
						for(var i in datos) {
							tab_text = tab_text+'<tr><td>'+datos[i].provincia+'</td><td>'+datos[i].cantidadvant+'</td></tr>';
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
			url: "Listar_usuarios/obtener_localidades",
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
		if (opcionElegida == 'zona_interes') {
			$("option[value='cantidad']").prop('disabled', true);
			$("option[value='vuelos']").prop('selected', true);
		} else {
			$("option[value='cantidad']").prop('disabled', false);
		}
	});
	
});