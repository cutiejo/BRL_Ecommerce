// Fetch actual data for the charts asynchronously
fetch('fetch_chart_data.php')
    .then(response => response.json())
    .then(data => {
        // Extract data from the response
        const totalProducts = data.totalProducts;
        const totalOrders = data.totalOrders;

        // Update data arrays for both charts with the fetched data
        polarAreaChart.data.datasets[0].data = [totalProducts, totalOrders];
        barChart.data.datasets[0].data = [totalProducts, totalOrders];

        // Update the charts
        polarAreaChart.update();
        barChart.update();
    })
    .catch(error => {
        console.error('Error fetching chart data:', error);
    });

// Define polarAreaChart
const ctx1 = document.getElementById("chart-1").getContext("2d");
const polarAreaChart = new Chart(ctx1, {
    type: "polarArea",
    data: {
        labels: ["Total Products", "Total Orders"], // Remove "Total Sales" label
        datasets: [{
            label: "# of Votes",
            data: [], // Leave this empty, data will be updated asynchronously
            backgroundColor: [
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
            ],
        }],
    },
    options: {
        responsive: true,
    },
});

// Define barChart
const ctx2 = document.getElementById("chart-2").getContext("2d");
const barChart = new Chart(ctx2, {
    type: "bar",
    data: {
        labels: ["Total Products", "Total Orders"], // Remove "Total Sales" label
        datasets: [{
            label: "POS with Inventory",
            data: [], // Leave this empty, data will be updated asynchronously
            backgroundColor: [
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
            ],
        }],
    },
    options: {
        responsive: true,
    },
});
//