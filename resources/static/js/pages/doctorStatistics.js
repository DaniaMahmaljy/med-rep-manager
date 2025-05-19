document.addEventListener("DOMContentLoaded", function() {
    const doctorId = window.doctorId;
    const statsUrl = `/doctors/${doctorId}/stats-json`;
    const isDarkMode = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
    const textColor = isDarkMode ? "#eee" : "#333";
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

            document.getElementById("totalVisits").textContent = data.total_visits;
            document.getElementById("linkedRepresentatives").textContent = data.distinct_representatives;
            document.getElementById("completionRate").textContent = `${data.completed_rate}%`;

            if (document.getElementById("totalAssigned")) {
                document.getElementById("totalAssigned").textContent = data.sample_stats.total_assigned;
                document.getElementById("totalUsed").textContent = data.sample_stats.total_used;
                document.getElementById("utilizationRate").textContent = data.sample_stats.utilization_rate;
            }

            const colors = data.colors && data.colors.length
                ? data.colors
                : [chartColors.green, chartColors.yellow, chartColors.red];

            const labels = [
                window.translations['local.status.completed'] || 'Completed',
                window.translations['local.status.scheduled'] || 'Scheduled',
                window.translations['local.status.canceled'] || 'Canceled'
            ];

            const values = [
                data.completed_visits || 0,
                data.upcoming_visits || 0,
                data.cancelled_visits || 0
            ];

            const canvas = document.getElementById("doctorStatsChart");
            if (!canvas) return;

            if (isDarkMode) {
                canvas.style.backgroundColor = "#222";
            } else {
                canvas.style.backgroundColor = "transparent";
            }

            const ctx = canvas.getContext('2d');

            if (data.has_visits) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
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
                            },
                            tooltip: {
                                bodyColor: textColor,
                                backgroundColor: isDarkMode ? "#222" : "#fff",
                                borderColor: textColor,
                                borderWidth: 1,
                                callbacks: {
                                    label: function(tooltipItem) {
                                        const label = tooltipItem.label || '';
                                        const value = tooltipItem.raw || 0;
                                        return `${label}: ${value}`;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                canvas.style.display = 'none';
                const noDataAlert = document.createElement('div');
                noDataAlert.className = 'alert alert-info';
                noDataAlert.textContent = window.translations['local.no_visits_data'] || 'No visits data available';
                canvas.parentNode.insertBefore(noDataAlert, canvas.nextSibling);
            }
        })
        .catch(error => {
            console.error("Error loading statistics:", error);
            const chart = document.getElementById("doctorStatsChart");
            if (chart) chart.style.display = 'none';

            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger mt-3';
            errorDiv.innerHTML = `
                <i class="bi bi-exclamation-triangle me-2"></i>
                ${window.translations['local.stats_load_error'] || 'Failed to load statistics'}
                <small class="d-block mt-1">${error.message}</small>
            `;
            document.querySelector(".card-body").appendChild(errorDiv);
        });
});
