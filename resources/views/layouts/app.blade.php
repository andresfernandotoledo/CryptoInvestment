<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="cryptoChart"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById("cryptoChart").getContext("2d");

            let cryptoChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: [],
                    datasets: [{
                        label: "Precio (USD)",
                        data: [],
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: false }
                    }
                }
            });

            function fetchCryptoData() {
                fetch("/crypto-data")
                    .then(response => response.json())
                    .then(data => {
                        cryptoChart.data.labels = data.map(crypto => crypto.name);
                        cryptoChart.data.datasets[0].data = data.map(crypto => crypto.price);
                        cryptoChart.update();
                    })
                    .catch(error => console.error("Error al obtener los datos:", error));
            }

            fetchCryptoData();
            setInterval(fetchCryptoData, 10000); // Actualiza cada 10 segundos
        });
    </script>
</body>
</html>
