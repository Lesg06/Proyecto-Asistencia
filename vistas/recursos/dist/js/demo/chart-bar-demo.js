// Estilos de fuente por defecto (Bootstrap-like)
Chart.defaults.global.defaultFontFamily = 'Nunito, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Función para formatear números
function number_format(number, decimals = 0, dec_point = '.', thousands_sep = ',') {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number;
  var prec = Math.abs(decimals);
  var sep = thousands_sep;
  var dec = dec_point;
  var s = '';

  var toFixedFix = function(n, prec) {
    var k = Math.pow(10, prec);
    return '' + Math.round(n * k) / k;
  };

  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Cargar datos desde PHP
async function getData() {
  const url = 'ajax/estadistica.ajax.php';
  try {
    const response = await fetch(url);
    if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
    const json = await response.json();
    return json; // Se espera un array de 12 valores numéricos
  } catch (error) {
    console.error('Error al obtener datos:', error);
    return new Array(12).fill(0); // Devuelve ceros en caso de error
  }
}

// Dibujar gráfico después de obtener los datos
async function renderChart() {
  const chartData = await getData();

  const ctx = document.getElementById('myBarChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        'Enero', 'Febrero', 'Marzo', 'Abril',
        'Mayo', 'Junio', 'Julio', 'Agosto',
        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
      ],
      datasets: [{
        label: 'Entradas',
        backgroundColor: '#4e73df',
        hoverBackgroundColor: '#2e59d9',
        borderColor: '#4e73df',
        data: chartData,
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: { left: 10, right: 25, top: 25, bottom: 0 },
      },
      scales: {
        xAxes: [{
          time: { unit: 'month' },
          gridLines: { display: false, drawBorder: false },
          ticks: { maxTicksLimit: 12 },
          maxBarThickness: 50,
        }],
        yAxes: [{
          ticks: {
            min: 0,
            maxTicksLimit: 10,
            padding: 10,
            callback: function (value) {
              return number_format(value);
            },
          },
          gridLines: {
            color: 'rgb(234, 236, 244)',
            zeroLineColor: 'rgb(234, 236, 244)',
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2],
          },
        }],
      },
      legend: { display: false },
      tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: 'rgb(255,255,255)',
        bodyFontColor: '#858796',
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
          },
        },
      },
    },
  });
}

// Ejecutar
renderChart();
