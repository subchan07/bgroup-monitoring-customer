(function ($) {
    "use strict";
    $(function () {
        if ($(".navbar").hasClass("fixed-top")) {
            document
                .querySelector(".page-body-wrapper")
                .classList.remove("pt-0");
            document.querySelector(".navbar").classList.remove("pt-5");
        } else {
            document.querySelector(".page-body-wrapper").classList.add("pt-0");
            document.querySelector(".navbar").classList.add("pt-5");
            document.querySelector(".navbar").classList.add("mt-3");
        }
        document
            .querySelector("#bannerClose")
            .addEventListener("click", function () {
                document.querySelector("#proBanner").classList.add("d-none");
                document.querySelector("#proBanner").classList.remove("d-flex");
                document.querySelector(".navbar").classList.remove("pt-5");
                document.querySelector(".navbar").classList.add("fixed-top");
                document
                    .querySelector(".page-body-wrapper")
                    .classList.add("proBanner-padding-top");
                document.querySelector(".navbar").classList.remove("mt-3");
                let date = new Date();
                date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
                $.cookie("staradmin2-pro-banner", "true", { expires: date });
            });
    });
})(jQuery);

const initChartMaterial = (target, dataset) => {
    const ctx = document.getElementById(target);

    if (window.initChartMaterial !== undefined) {
        window.initChartMaterial.destroy();
    }

    let graphGradient = ctx.getContext("2d");
    let saleGradientBg = graphGradient.createLinearGradient(5, 0, 5, 100);
    saleGradientBg.addColorStop(0, "rgba(26, 115, 232, 0.18)");
    saleGradientBg.addColorStop(1, "rgba(26, 115, 232, 0.02)");

    let chart = new Chart(ctx, {
        type: "line",
        data: {
            datasets: [
                {
                    label: "This week",
                    data: dataset,
                    backgroundColor: saleGradientBg,
                    borderColor: ["#1F3BB3"],
                    borderWidth: 1.5,
                    fill: true, 
                    pointBorderWidth: 1,
                    pointRadius: [4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4],
                    pointHoverRadius: [2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2],
                    pointBackgroundColor: [
                        "#1F3BB3)",
                        "#1F3BB3",
                        "#1F3BB3",
                        "#1F3BB3",
                        "#1F3BB3)",
                        "#1F3BB3",
                        "#1F3BB3",
                        "#1F3BB3",
                        "#1F3BB3)",
                        "#1F3BB3",
                        "#1F3BB3",
                        "#1F3BB3",
                        "#1F3BB3)",
                    ],
                    pointBorderColor: [
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                        "#fff",
                    ],
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            elements: {
                line: {
                    tension: 0.4,
                },
            },

            scales: {
                y: {
                    border: {
                        display: false,
                    },
                    grid: {
                        display: true,
                        color: "#F0F0F0",
                        drawBorder: false,
                    },
                    ticks: {
                        beginAtZero: false,
                        autoSkip: true,
                        maxTicksLimit: 4,
                        color: "#6B778C",
                        font: {
                            size: 10,
                        },
                    },
                },
                x: {
                    border: {
                        display: false,
                    },
                    grid: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        beginAtZero: false,
                        autoSkip: true,
                        maxTicksLimit: 7,
                        color: "#6B778C",
                        font: {
                            size: 10,
                        },
                    },
                },
            },
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
        plugins: [],
    });

    window.initChartMaterial = chart;
};

const initChartStatistic = (target, dataset) => {
    const ctx = document.getElementById(target).getContext("2d");

    if (window.initChartStatistic !== undefined) {
        window.initChartStatistic.destroy();
    }

    let chart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: dataset.map((d) => d.label),
            datasets: [
                {
                    label: "Data",
                    data: dataset.map((d) => d.value),
                    borderColor: "#1F3BB3",
                    backgroundColor: "rgba(26, 115, 232, 0.18)",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            // indexAxis: "y",
            responsive: true,
            maintainAspectRatio: false,
            elements: {
                bar: {
                    borderWidth: 2,
                },
            },
            scales: {
                y: {
                    border: {
                        display: false,
                    },
                    grid: {
                        display: true,
                        color: "#F0F0F0",
                        drawBorder: false,
                    },
                    ticks: {
                        beginAtZero: false,
                        autoSkip: false,
                        color: "#6B778C",
                        font: {
                            size: 10,
                        },
                    },
                },
                x: {
                    border: {
                        display: false,
                    },
                    grid: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        beginAtZero: false,
                        autoSkip: false,
                        maxTicksLimit: 6,
                        color: "#6B778C",
                        font: {
                            size: 12,
                        },
                    },
                },
            },
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
        plugins: [],
    });

    window.initChartStatistic = chart;
};
