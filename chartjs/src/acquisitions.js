import Chart from 'chart.js/auto';
import jsonData from '../data.json';

(async function() {
  try {
    const sensorData = jsonData.datasensorreport[0].sensordata;

    // Pisahkan data berdasarkan sensor_id
    const sensor1 = sensorData.filter(item => item.sensor_id === "1");
    const sensor2 = sensorData.filter(item => item.sensor_id === "2");

    // Label tanggal dari sensor 1 (keduanya punya tanggal yang sama)
    const labels = sensor1.map(item => item.timestamp.split('T')[0]);

    // ===================== Temperature Chart =====================
    new Chart(document.getElementById('temperatureChart'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Temperature Lokasi 1 (Sensor 1) °C',
            data: sensor1.map(item => item.temperature),
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            fill: false,
            tension: 0.3
          },
          {
            label: 'Temperature Lokasi 2 (Sensor 2) °C',
            data: sensor2.map(item => item.temperature),
            borderColor: 'rgba(153, 102, 255, 1)',
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            fill: false,
            tension: 0.3
          }
        ]
      },
      options: {
        plugins: {
          title: { display: true, text: 'Temperature Sensor (2 Lokasi)' }
        }
      }
    });

    // ===================== Humidity Chart =====================
    new Chart(document.getElementById('humidityChart'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Humidity Lokasi 1 (Sensor 1) %',
            data: sensor1.map(item => item.humidity),
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            fill: false,
            tension: 0.3
          },
          {
            label: 'Humidity Lokasi 2 (Sensor 2) %',
            data: sensor2.map(item => item.humidity),
            borderColor: 'rgba(255, 159, 64, 1)',
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            fill: false,
            tension: 0.3
          }
        ]
      },
      options: {
        plugins: {
          title: { display: true, text: 'Humidity Sensor (2 Lokasi)' }
        }
      }
    });

    // ===================== Pressure Chart =====================
    new Chart(document.getElementById('pressureChart'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Pressure Lokasi 1 (Sensor 1) hPa',
            data: sensor1.map(item => item.pressure),
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: false,
            tension: 0.3
          },
          {
            label: 'Pressure Lokasi 2 (Sensor 2) hPa',
            data: sensor2.map(item => item.pressure),
            borderColor: 'rgba(255, 206, 86, 1)',
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            fill: false,
            tension: 0.3
          }
        ]
      },
      options: {
        plugins: {
          title: { display: true, text: 'Pressure Sensor (2 Lokasi)' }
        }
      }
    });

  } catch (error) {
    console.error('Failed to parse or create charts:', error);
  }
})();