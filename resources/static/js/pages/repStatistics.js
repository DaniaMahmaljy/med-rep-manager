document.addEventListener("DOMContentLoaded", function () {
  const repId = window.representativeId;
  const statsUrl = `/representatives/${repId}/stats-json`;

  const isDarkMode = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
  const textColor = isDarkMode ? "#eee" : "#333";

  fetch(statsUrl)
    .then((response) => response.json())
    .then((responseData) => {
      const data = responseData.data || responseData;

      document.getElementById("totalVisits").textContent = data.total_visits;
      document.getElementById("linkedDoctors").textContent = data.linked_doctors;
      document.getElementById("completionRate").textContent = data.completion_rate + "%";

      const colors = data.colors && data.colors.length
        ? data.colors
        : [chartColors.green, chartColors.grey];

      const labels = data.labels.map(labelKey => window.translations[labelKey] || labelKey);

      const canvas = document.getElementById("repStatsChart");
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
          datasets: [
            {
              data: data.values,
              backgroundColor: colors,
              borderColor: isDarkMode ? "#444" : "#fff",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: "bottom",
              labels: {
                fontColor: textColor,
                font: {
                  size: 14,
                  weight: "bold",
                },
              },
            },
            title: {
              display: true,
              text: window.translations["local.visit_completion_overview"] || "Visit Completion Overview",
              fontColor: textColor,
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
            },
          },
        },

      });
    })
    .catch((error) => {
      console.error("Failed to load statistics:", error);
    });
});
