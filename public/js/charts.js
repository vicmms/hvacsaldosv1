$(document).ready(function () {
    getSalesData();
});

function getSalesData() {
    let data = [];
    $.ajax({
        type: "POST",
        url: "../api/getSalesData",
        dataType: "json",
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
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
        },
    });
}

function paintSalesChart(data, type = '2') {
    labels = [];
    switch (type) {
        case '1':
            labels = ["'  Hace 2 semanas", "Hace 1 semana", "Última semana"];
            $('#last_sales_label').text('Ventas en la última semana');
            $('#increase_label').text('La última semana');
            break;
        case '2':
            labels = ["'  Hace 2 meses", "Hace 1 mes", "Último mes"];
            $('#last_sales_label').text('Ventas en el último mes');
            $('#increase_label').text('El último mes');
            break;
        case '3':
            labels = ["'  Hace 2 años", "Hace 1 año", "Último año"];
            $('#last_sales_label').text('Ventas en el último año');
            $('#increase_label').text('El último año');
            break;
    }
    var options = {
        chart: {
            type: "area",
            stroke: {
                curve: "smooth",
            },
            toolbar: {
                show: false,
            },
        },
        dataLabels: {
            enabled: false,
        },
        series: [
            {
                name: "Ventas",
                data: data,
            },
        ],
        xaxis: {
            categories: labels,
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.6,
                opacityTo: 1,
                stops: [0, 95, 100],
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    $('#last_sales').text(data[2]);
    chart.render();
}
