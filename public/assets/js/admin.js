"use strict";

const chartDataElement = document.getElementById("overview-chart-data");
const overviewData = chartDataElement ? JSON.parse(chartDataElement.textContent) : null;

function createOverviewCharts() {
  if (!window.Chart || !overviewData) return;

  const colors = [
    "#829875",
    "#a6b293",
    "#b89b6c",
    "#789183",
    "#8e9878",
    "#a88b6c",
    "#7f999c"
  ];
  const gridColor = "rgba(224, 227, 211, .17)";
  const tickColor = "#e5e8dc";
  const money = value => `${Number(value).toLocaleString()} JOD`;

  Chart.defaults.color = tickColor;
  Chart.defaults.font.family = "DM Sans, Arial, sans-serif";
  Chart.defaults.plugins.legend.labels.usePointStyle = true;
  Chart.defaults.plugins.tooltip.backgroundColor = "rgba(20, 35, 26, .96)";
  Chart.defaults.plugins.tooltip.titleColor = "#f2eee2";
  Chart.defaults.plugins.tooltip.bodyColor = "#dce3d4";
  Chart.defaults.plugins.tooltip.borderColor = "rgba(184, 155, 108, .55)";
  Chart.defaults.plugins.tooltip.borderWidth = 1;
  Chart.defaults.plugins.tooltip.padding = 10;
  Chart.defaults.plugins.tooltip.cornerRadius = 8;

  const bestCanvas = document.getElementById("bestSellersChart");
  if (bestCanvas && overviewData.bestSellers.values.length) {
    new Chart(bestCanvas, {
      type: "bar",
      data: {
        labels: overviewData.bestSellers.labels,
        datasets: [{
          data: overviewData.bestSellers.values,
          backgroundColor: colors.slice(0, 5),
          borderRadius: 7,
          maxBarThickness: 28
        }]
      },
      options: {
        indexAxis: "y",
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: context => ` ${context.raw} sold`
            }
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: { color: gridColor },
            ticks: { color: tickColor, precision: 0 }
          },
          y: {
            grid: { display: false },
            ticks: { color: tickColor }
          }
        }
      }
    });
  }

  const categoryCanvas = document.getElementById("categorySalesChart");
  if (categoryCanvas && overviewData.categories.values.length) {
    new Chart(categoryCanvas, {
      type: "doughnut",
      data: {
        labels: overviewData.categories.labels,
        datasets: [{
          data: overviewData.categories.values,
          backgroundColor: colors,
          borderColor: "#203528",
          borderWidth: 3,
          hoverOffset: 7
        }]
      },
      options: {
        maintainAspectRatio: false,
        cutout: "68%",
        plugins: {
          legend: {
            position: "bottom",
            labels: { color: tickColor, padding: 16, boxWidth: 8 }
          },
          tooltip: {
            callbacks: {
              label: context => ` ${context.label}: ${money(context.raw)}`
            }
          }
        }
      }
    });
  }

  const weeklyCanvas = document.getElementById("weeklySalesChart");
  if (weeklyCanvas && overviewData.weekly.values.length) {
    new Chart(weeklyCanvas, {
      type: "line",
      data: {
        labels: overviewData.weekly.labels,
        datasets: [{
          label: "Sales",
          data: overviewData.weekly.values,
          borderColor: "#b5c29a",
          backgroundColor: "rgba(164, 180, 139, .2)",
          fill: true,
          tension: .38,
          borderWidth: 2.5,
          pointRadius: 3,
          pointHoverRadius: 5,
          pointBackgroundColor: "#d1b17d",
          pointBorderColor: "#253a2b",
          pointBorderWidth: 2
        }]
      },
      options: {
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: context => ` ${money(context.raw)}`
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: tickColor }
          },
          y: {
            beginAtZero: true,
            grid: { color: gridColor },
            ticks: {
              color: tickColor,
              callback: value => `${value} JOD`
            }
          }
        }
      }
    });
  }

  const ordersCanvas = document.getElementById("ordersStatusChart");
  if (ordersCanvas && overviewData.orders.values.length) {
    new Chart(ordersCanvas, {
      type: "bar",
      data: {
        labels: overviewData.orders.labels,
        datasets: [{
          label: "Orders",
          data: overviewData.orders.values,
          backgroundColor: colors.slice(0, overviewData.orders.values.length),
          borderRadius: 7,
          maxBarThickness: 44
        }]
      },
      options: {
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: tickColor }
          },
          y: {
            beginAtZero: true,
            grid: { color: gridColor },
            ticks: { color: tickColor, precision: 0 }
          }
        }
      }
    });
  }
}

function connectBestSellersDialog() {
  const dialog = document.getElementById("bestSellersDialog");
  const openButton = document.querySelector("[data-open-best-sellers]");
  const closeButton = document.querySelector("[data-close-best-sellers]");

  openButton?.addEventListener("click", () => dialog?.showModal());
  closeButton?.addEventListener("click", () => dialog?.close());
  dialog?.addEventListener("click", event => {
    if (event.target === dialog) dialog.close();
  });
}

createOverviewCharts();
connectBestSellersDialog();
(() => {
  const normalizePath = path =>
    decodeURIComponent(path).replace(/\/+$/, "");

  const currentPath = normalizePath(window.location.pathname);
  const links = document.querySelectorAll(".admin-sidebar nav a[href]");

  links.forEach(link => {
    const linkPath = normalizePath(new URL(link.href).pathname);

    link.classList.remove("active");
    link.removeAttribute("aria-current");

    if (linkPath === currentPath) {
      link.classList.add("active");
      link.setAttribute("aria-current", "page");
    }
  });
})();