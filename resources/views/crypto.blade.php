<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criptomonedas en Tiempo Real</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
        }
        .crypto-selector {
            margin: 20px 0;
        }
        canvas {
            max-width: 100%;
        }
    </style>
    <meta name="api-url" content="{{ $apiUrl }}">
    <meta name="crypto-list-url" content="{{ $cryptoListUrl }}">
</head>
<body>
    <div class="container">
        <h1>Criptomonedas en Tiempo Real</h1>

        <!-- Selector de criptomonedas -->
        <div class="crypto-selector">
            <label for="cryptoSelect">Selecciona una criptomoneda:</label>
            <select id="cryptoSelect"></select>
        </div>

        <!-- Área para la gráfica -->
        <canvas id="cryptoChart"></canvas>

        <!-- Información adicional -->
        <div id="cryptoInfo">
            <p>Precio: <span id="price">-</span></p>
            <p>Cambio porcentual: <span id="percentageChange">-</span></p>
            <p>Volumen: <span id="volume">-</span></p>
        </div>
    </div>

    <script>
        let chartInstance = null;

        async function loadCryptoList() {
            const cryptoListUrl = document.querySelector('meta[name="crypto-list-url"]').content;
            const select = document.getElementById('cryptoSelect');

            try {
                const response = await fetch(cryptoListUrl);
                const data = await response.json();

                if (response.ok) {
                    data.forEach(crypto => {
                        const option = document.createElement('option');
                        option.value = crypto.symbol;
                        option.textContent = `${crypto.name} (${crypto.symbol})`;
                        select.appendChild(option);
                    });

                    fetchData(); // Cargar datos iniciales
                } else {
                    throw new Error('Error al cargar lista de criptos');
                }
            } catch (error) {
                console.error(error);
                alert('No se pudieron cargar las criptomonedas.');
            }
        }

        async function fetchData() {
            const baseUrl = document.querySelector('meta[name="api-url"]').content;
            const crypto = document.getElementById('cryptoSelect').value;
            const url = `${baseUrl}?crypto=${crypto}`;

            try {
                const response = await fetch(url);
                const data = await response.json();

                if (!response.ok || data.error) {
                    throw new Error(data.error || 'Datos no válidos.');
                }

                document.getElementById('price').textContent = `$${data.price.toFixed(2)}`;
                document.getElementById('percentageChange').textContent = `${data.percent_change.toFixed(2)}%`;
                document.getElementById('volume').textContent = `$${data.volume.toFixed(2)}`;

                // Destruir gráfico anterior si existe
                if (chartInstance) {
                    chartInstance.destroy();
                }

                // Crear nueva gráfica
                const ctx = document.getElementById('cryptoChart').getContext('2d');
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [data.timestamp],
                        datasets: [{
                            label: 'Precio en USD',
                            data: [data.price],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: false,
                        }]
                    },
                    options: { responsive: true }
                });

            } catch (error) {
                console.error(error);
                alert('Error al obtener los datos.');
            }
        }

        document.getElementById('cryptoSelect').addEventListener('change', fetchData);
        loadCryptoList();
        setInterval(fetchData, 30000);
    </script>
</body>
</html>
