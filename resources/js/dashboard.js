/**
 * @param {object} stats
 * @param {object} translations
 */



document.addEventListener("DOMContentLoaded", function() {
  const ctx = document.getElementById('visitsChart');

  const data = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [
      {
        label: 'Completed',
        data: [12, 19, 15, 25, 18, 22],
        backgroundColor: '#20c997',
        borderColor: 'rgba(74, 222, 128, 1)',
        borderWidth: 1,
        borderRadius: 6,
        borderSkipped: false
      },
      {
        label: 'Scheduled',
        data: [8, 12, 10, 15, 12, 14],
        backgroundColor: 'rgba(33, 150, 243, 0.85)',
        borderColor: 'rgba(96, 165, 250, 1)',
        borderWidth: 1,
        borderRadius: 6,
        borderSkipped: false
      },
      {
        label: 'Missed',
        data: [3, 5, 2, 4, 3, 5],
        backgroundColor: 'rgba(244, 67, 54, 0.85)',
        borderColor: 'rgba(251, 146, 60, 1)',
        borderWidth: 1,
        borderRadius: 6,
        borderSkipped: false
      }
    ]
  };

  new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top',
          labels: {
            usePointStyle: true,
            padding: 20,
            font: {
              family: 'inherit',
              size: 13
            }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(30, 41, 59, 0.95)',
          titleFont: {
            size: 14,
            weight: 'bold'
          },
          bodyFont: {
            size: 12
          },
          padding: 12,
          usePointStyle: true,
          cornerRadius: 6,
          displayColors: true,
          callbacks: {
            label: function(context) {
              return `${context.dataset.label}: ${context.raw}`;
            }
          }
        }
      },
      scales: {
        x: {
          grid: {
            display: false,
            drawBorder: false
          },
          ticks: {
            font: {
              family: 'inherit'
            }
          }
        },
        y: {
          grid: {
            drawBorder: false,
            color: 'rgba(226, 232, 240, 0.5)'
          },
          ticks: {
            precision: 0,
            font: {
              family: 'inherit'
            }
          },
          beginAtZero: true
        }
      },
      interaction: {
        intersect: false,
        mode: 'index'
      }
    }
  });
});
