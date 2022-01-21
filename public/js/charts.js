$( document ).ready(function() {
    getSalesData();
});

function getSalesData(){
    let data = [];
    $.ajax({
        type: 'POST',
        url: '../api/getSalesData',
        dataType: 'json',
        data: {
            "_token": $("meta[name='csrf-token']").attr("content")
        },
        success: function (response) {
            data.push(response[2].length);
            data.push(response[1].length);
            data.push(response[0].length);
           
            // for (let i = 0; i < response[0].length; i++) {
            // }
            paintSalesChart(data);
        },
        error: function (responsetext) {
            console.log(responsetext);
        }
    });
}

function paintSalesChart(data){
    var options = {
        chart: {
          type: 'area',
          stroke: {
            curve: 'smooth',
          },
          toolbar: {
            show: false,
          }
        },
        dataLabels: {
            enabled: false
          },
        series: [{
          name: 'Mes',
          data: data
        }],
        xaxis: {
          categories: ['Hace 2 meses', 'Hace 1 mes', 'Ultimo mes']
        },
        fill: {
            type: "gradient",
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.7,
              opacityTo: 0.9,
              stops: [0, 90, 100]
            }
          },
      }
      
      var chart = new ApexCharts(document.querySelector("#chart"), options);
      
      chart.render();
}