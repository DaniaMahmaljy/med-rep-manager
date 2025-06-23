document.addEventListener("DOMContentLoaded", function () {
    const statsTab = document.getElementById('stats-tab');
    const chartContainer = document.querySelector('.chart-container');
    const canvas = document.getElementById("repStatsChart");
    let chartData = null;

    statsTab.addEventListener('shown.bs.tab', function() {
        if (chartData) {
            renderChart(chartData);
        }
    });

    const repId = window.representativeId;
    const statsUrl = `/representatives/${repId}/stats-json`;

    const isDarkMode = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
    const textColor = isDarkMode ? "#eee" : "#666666";

    fetch(statsUrl)
        .then((response) => response.json())
        .then((responseData) => {
            const data = responseData.data || responseData;
            chartData = data;

            document.getElementById("totalVisits").textContent = data.total_visits;
            document.getElementById("linkedDoctors").textContent = data.linked_doctors;
            document.getElementById("completionRate").textContent = data.completion_rate + "%";

            const hasData = data.values && data.values.some(value => value > 0);

            if (!hasData) {
                canvas.style.display = 'none';
                chartContainer.style.display = 'none';

                const noDataMessage = document.createElement('div');
                noDataMessage.className = 'alert alert-info mt-3';
                noDataMessage.textContent = window.translations['local.no_data_available'] || 'No data available';
                chartContainer.parentNode.insertBefore(noDataMessage, chartContainer.nextSibling);
                return;
            }

            const colors = data.colors && data.colors.length
                ? data.colors
                : ['#28a745', '#6c757d'];

            const labels = data.labels.map(labelKey => window.translations[labelKey] || labelKey);

            if (isDarkMode) {
                canvas.style.backgroundColor = "#222";
            } else {
                canvas.style.backgroundColor = "transparent";
            }

            const ctx = canvas.getContext("2d");
            new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: colors,
                        borderColor: isDarkMode ? "#444" : "#fff",
                        borderWidth: 1,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom",
                            labels: {
                                color: textColor,
                                font: {
                                    size: 14,
                                    weight: "bold",
                                },
                            },
                        },
                        title: {
                            display: true,
                            text: window.translations["local.visit_completion_overview"],
                            color: textColor,
                            font: {
                                size: 18,
                                weight: "bold",
                            },
                        },
                        tooltip: {
                            bodyColor: textColor,
                            backgroundColor: isDarkMode ? "#222" : "#fff",
                            borderColor: textColor,
                            borderWidth: 1,
                            callbacks: {
                                label: function (tooltipItem) {
                                    const label = tooltipItem.label || '';
                                    const value = tooltipItem.raw || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        },
                    },
                },
            });
        })
        .catch((error) => {
            console.error("Failed to load statistics:", error);
            canvas.style.display = 'none';
            chartContainer.style.display = 'none';

            const errorMessage = document.createElement('div');
            errorMessage.className = 'alert alert-danger mt-3';
            errorMessage.textContent = window.translations['local.failed_to_load_data'] || 'Failed to load data';
            chartContainer.parentNode.insertBefore(errorMessage, chartContainer.nextSibling);
        });
});
