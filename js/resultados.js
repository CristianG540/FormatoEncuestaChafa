var modGrafica = new Vue({
	el : ".contact-form-area",
	mounted : function(){
        this.getData();
    },
	data : {
		barChart  :  '',
		data      : [],
		dVotantes : []
	},
	methods : {
		init : function(){
			this.barChart = new Chart( $("#myChart") , {
			    type: 'bar',
			    data: {
			        labels: ["#1", "#2", "#3", "#4"],
			        datasets: [{
			            label: '# de votos',
			            data: this.data,
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255,99,132,1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)'
			            ],
			            borderWidth: 1
			        }]
			    },
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
		getData : function(){
			var scope = this;
			$.get('getData.php')
            .done(function(d){
            	scope.data = d.graph;
            	scope.dVotantes = d.votantes;
                scope.init();
            })
            .fail(this.failReq);
		},
		failReq: function (e) {
            alert('Error al procesar la peticion, revise la consola para mas informacion.'+e.error);
            console.log('Error processing your request: ', e);
        }
	},
	computed: {

	}
});

$(document).ready(function(){

});
