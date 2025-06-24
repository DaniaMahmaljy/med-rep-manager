document.addEventListener("DOMContentLoaded", function() {
    const statsTab = document.getElementById('stats-tab');
    let chartData = null;

    statsTab.addEventListener('shown.bs.tab', function() {
        if (chartData) {
            renderChart(chartData);
        }
    });

    const doctorId = window.doctorId;
    const statsUrl = `${window.APP_BASE_URL || ''}/doctors/${doctorId}/stats-json`;
    const isDarkMode = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
    const textColor = isDarkMode ? "#adb5bd" : "#666666";
    const chartColors = {
        green: '#28a745',
        yellow: '#ffc107',
        red: '#dc3545',
        grey: '#6c757d'
    };

    fetch(statsUrl)
        .then(response => response.json())
        .then((responseData) => {
            const data = responseData.data || responseData;
            const chartContainer = document.querySelector(".chart-container");
            const canvas = document.getElementById("doctorStatsChart");

            document.getElementById("totalVisits").textContent = data.total_visits;
            document.getElementById("linkedRepresentatives").textContent = data.distinct_representatives;
            document.getElementById("completionRate").textContent = `${data.completed_rate}%`;

            if (document.getElementById("totalAssigned")) {
                document.getElementById("totalAssigned").textContent = data.sample_stats.total_assigned;
                document.getElementById("totalUsed").textContent = data.sample_stats.total_used;
                document.getElementById("utilizationRate").textContent = data.sample_stats.utilization_rate;
            }

            document.querySelectorAll('.no-data-alert, .stats-error-alert').forEach(el => el.remove());

            if (data.has_visits) {
                chartContainer.classList.remove('no-data-container');
                canvas.style.display = 'block';

                const colors = data.colors && data.colors.length
                    ? data.colors
                    : [chartColors.green, chartColors.yellow, chartColors.red];

                const labels = [
                    window.translations['local.status.completed'] || 'Completed',
                    window.translations['local.status.scheduled'] || 'Scheduled',
                    window.translations['local.status.canceled'] || 'Canceled'
                ];

                if (window.doctorChart) {
                    window.doctorChart.destroy();
                }

                const ctx = canvas.getContext('2d');
                window.doctorChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: [
                                data.completed_visits || 0,
                                data.upcoming_visits || 0,
                                data.cancelled_visits || 0
                            ],
                            backgroundColor: colors,
                            borderColor: isDarkMode ? "#444" : "#fff",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor,
                                    font: {
                                        size: 14,
                                        weight: "bold"
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: window.translations["local.visit_completion_overview"],
                                color: textColor,
                                font: {
                                    size: 18,
                                    weight: "bold"
                                }
                            }
                        }
                    }
                });
            } else {
                chartContainer.classList.add('no-data-container');
                canvas.style.display = 'none';

                const noDataAlert = document.createElement('div');
                noDataAlert.className = 'no-data-alert alert alert-info';
                noDataAlert.textContent = window.translations['local.no_visits_data'] || 'No visits data available';
                chartContainer.parentNode.insertBefore(noDataAlert, chartContainer.nextSibling);
            }
        })
        .catch(error => {
            console.error("Error loading statistics:", error);
            const chartContainer = document.querySelector(".chart-container");
            const canvas = document.getElementById("doctorStatsChart");

            chartContainer.classList.add('no-data-container');
            canvas.style.display = 'none';

            const errorDiv = document.createElement('div');
            errorDiv.className = 'stats-error-alert alert alert-danger';
            errorDiv.innerHTML = `
                <i class="bi bi-exclamation-triangle me-2"></i>
                ${window.translations['local.stats_load_error'] || 'Failed to load statistics'}
            `;
            chartContainer.parentNode.insertBefore(errorDiv, chartContainer.nextSibling);
        });
});
