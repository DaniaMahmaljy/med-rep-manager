/**
 * @param {object} stats
 * @param {object} translations
 */
function initDashboardCharts(stats, translations) {
    const ctx = document.getElementById('visitsChart');
    if (!ctx) return;

    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: [
                translations.completed,
                translations.missed,
                translations.scheduled,
                translations.cancelled
            ],
            datasets: [{
                label: translations.visits,
                data: [
                    stats.chart_data.completed || 0,
                    stats.chart_data.missed || 0,
                    stats.chart_data.scheduled || 0,
                    stats.chart_data.cancelled || 0
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    try {
        const translations = JSON.parse(document.getElementById('translations').textContent);
        const stats = JSON.parse(document.getElementById('stats-data').textContent);

        initDashboardCharts(stats, translations);
    } catch (error) {
        console.error('Failed to initialize dashboard charts:', error);
    }
});
