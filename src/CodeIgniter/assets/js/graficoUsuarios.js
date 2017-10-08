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
						label: 'Edad',
						backgroundColor: 'rgba(163, 73, 0, 0.9)',
						borderColor: 'rgba(163, 73, 0, 1)',
						hoverBackgroundColor: 'rgba(191, 116, 63, 1)',
						hoverBorderColor: 'rgba(163, 73, 0, 1)',
						data: vant
					}
				]
			};

			var ctx = $("#myChart");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata,
				options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero:true
								}
							}]
						}
					}
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});