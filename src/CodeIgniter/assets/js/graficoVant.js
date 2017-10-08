$(document).ready(function(){
	$.ajax({
		url: "Grafico_vant",
		method: "GET",
		success: function(data) {
			var datos = JSON.parse(data);
			var vant = [];
			var peso = [];
			
			for(var i in datos) {
				vant.push(datos[i].marca);
				peso.push(datos[i].peso);
			}

			var chartdata = {
				labels: vant,
				datasets : [
					{
						label: 'Peso de cada VANT',
						backgroundColor: 'rgba(255, 99, 132, 0.2)',
						borderColor: 'rgba(255,99,132,1)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: peso
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