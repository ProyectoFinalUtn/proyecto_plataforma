$(document).ready(function(){
	$.ajax({
		url: "Grafico_usuarios",
		method: "GET",
		success: function(data) {
			var datos = JSON.parse(data);
			var edad = [];
			var vant = [];
			
			for(var i in datos) {
				edad.push(datos[i].edad);
				vant.push(datos[i].cantidadvant);
			}
			
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
									beginAtZero:true
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
		$.ajax({
			url: "Grafico_usuarios",
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
				}
				switch(ejeX) {
					case 'sexo':
						var sexo = [];
						var vant = [];
						
						for(var i in datos) {
							sexo.push(datos[i].sexo);
							vant.push(datos[i].cantidadvant);
						}

						var chartdata = {
							labels: sexo,
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
						
						$('canvas').replaceWith('<canvas id="graficoSe" width="400" height="400"></canvas>');
						
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
												beginAtZero:true
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
										text: 'Cantidad de VANT por Sexo'
									}
								}
						});
						break;
					case 'localidad':
						var localidad = [];
						var vant = [];
						
						for(var i in datos) {
							localidad.push(datos[i].localidad);
							vant.push(datos[i].cantidadvant);
						}

						var chartdata = {
							labels: localidad,
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
						
						$('canvas').replaceWith('<canvas id="graficoLoc" width="400" height="400"></canvas>');
						
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
												beginAtZero:true
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
										text: 'Cantidad de VANT por Localidad'
									}
								}
						});
						break;
					case 'provincia':
						var provincia = [];
						var vant = [];
						
						for(var i in datos) {
							provincia.push(datos[i].provincia);
							vant.push(datos[i].cantidadvant);
						}

						var chartdata = {
							labels: provincia,
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
						
						$('canvas').replaceWith('<canvas id="graficoProv" width="400" height="400"></canvas>');
						
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
												beginAtZero:true
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
										text: 'Cantidad de VANT por Provincia'
									}
								}
						});
						break;
					case 'edad':
						var edad = [];
						var vant = [];
						
						for(var i in datos) {
							edad.push(datos[i].edad);
							vant.push(datos[i].cantidadvant);
						}
						
						var chartdata = {
							labels: edad,
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
						
						$('canvas').replaceWith('<canvas id="graficoEdad" width="400" height="400"></canvas>');
						
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
												beginAtZero:true
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
						
						break;
				}
				
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
});