document.addEventListener("DOMContentLoaded", function() {
    fetch("/crypto-data")
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById("cryptoChart").getContext("2d");

            const labels = data.map(crypto => crypto.name);
            const prices = data.map(crypto => crypto.price);

            new Chart(ctx, {
                type: "bar",  // Tipo de gráfico ('line', 'pie', etc.)
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Precio (USD)",
                        data: prices,
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error("Error al obtener los datos:", error));
});
