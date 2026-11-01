"use strict";

const chartDataElement = document.getElementById("overview-chart-data");
const overviewData = chartDataElement ? JSON.parse(chartDataElement.textContent) : null;

function createOverviewCharts() {
  if (!window.Chart || !overviewData) { const tables = document.querySelector('.chart-data-tables'); if (tables) { const note = document.createElement('p'); note.setAttribute('role', 'status'); note.textContent = 'Charts could not load. The full figures are available in the data tables below.'; tables.prepend(note); tables.querySelectorAll('details').forEach(el => { el.open = true; }); } return; }

  const colors = [
    "#286148",
    "#216B95",
    "#925914",
    "#A13D58",
    "#6655A3",
    "#A34B26",
    "#52652C",
    "#245A72",
    "#786033",
    "#7B3E80",
    "#4C6D6A",
    "#8A4F46"
  ];
  const gridColor = "rgba(38, 61, 49, .18)";
  const tickColor = "#334638";
  const statusColor = label => {
    const value = String(label).toLowerCase();
    if (value.includes("cancel") || value.includes("reject")) return "#A13D58";
    if (value.includes("pending")) return "#925914";
    if (value.includes("process")) return "#216B95";
    if (value.includes("ship")) return "#6655A3";
    if (value.includes("complete") || value.includes("deliver") || value.includes("approve")) return "#286148";
    return colors[0];
  };
  const money = value => `${Number(value).toLocaleString()} JOD`;

  Chart.defaults.color = tickColor;
  Chart.defaults.font.family = "DM Sans, Arial, sans-serif";
  Chart.defaults.font.size = 13;
  Chart.defaults.font.weight = "500";
  Chart.defaults.plugins.legend.labels.font = { size: 13, weight: "600" };
  Chart.defaults.layout.padding = 6;
  Chart.defaults.plugins.legend.labels.usePointStyle = true;
  Chart.defaults.plugins.tooltip.backgroundColor = "rgba(52, 69, 47, .96)";
  Chart.defaults.plugins.tooltip.titleColor = "#FFFEFA";
  Chart.defaults.plugins.tooltip.bodyColor = "#FFF3DE";
  Chart.defaults.plugins.tooltip.borderColor = "#E8D5B8";
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
            ticks: { color: tickColor, autoSkip: false, callback: function(value) { const words = String(this.getLabelForValue(value)).split(" "); const lines = []; let line = ""; words.forEach(word => { if ((line + " " + word).trim().length > 18 && line) { lines.push(line); line = word; } else line = (line + " " + word).trim(); }); if (line) lines.push(line); return lines; } }
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
          borderColor: "#FFFEFA",
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
            labels: { color: tickColor, padding: 16, boxWidth: 12, boxHeight: 12 }
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
          borderColor: "#286148",
          backgroundColor: "rgba(40, 97, 72, .12)",
          fill: true,
          tension: .38,
          borderWidth: 3,
          pointRadius: 4,
          pointHoverRadius: 5,
          pointBackgroundColor: "#FFFFFF",
          pointBorderColor: "#34452F",
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
          backgroundColor: overviewData.orders.labels.map(statusColor),
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

if (document.fonts?.ready) document.fonts.ready.then(createOverviewCharts);
else createOverviewCharts();
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
