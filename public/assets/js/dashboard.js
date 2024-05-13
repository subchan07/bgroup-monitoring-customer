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
    // iconify.load('icons.svg').then(function() {
    //   iconify(document.querySelector('.my-cool.icon'));
    // });
})(jQuery);

const initChart = (dataset) => {
    const ctx = document.getElementById("performanceLine");

    if (window.performanceLineChart !== undefined) {
        window.performanceLineChart.destroy();
    }

    let graphGradient = ctx.getContext("2d");
    let saleGradientBg = graphGradient.createLinearGradient(5, 0, 5, 100);
    saleGradientBg.addColorStop(0, "rgba(26, 115, 232, 0.18)");
    saleGradientBg.addColorStop(1, "rgba(26, 115, 232, 0.02)");

    let chart = new Chart(ctx, {
        type: "line",
        data: {
            // labels: ["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DES"],
            datasets: [
                {
                    label: "This week",
                    data: dataset,
                    backgroundColor: saleGradientBg,
                    borderColor: ["#1F3BB3"],
                    borderWidth: 1.5,
                    fill: true, // 3: no fill
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
        plugins: [
            {
                // afterDatasetUpdate: function (chart, args, options) {
                //     const chartId = chart.canvas.id;
                //     let i;
                //     const legendId = `${chartId}-legend`;
                //     const ul = document.createElement("ul");
                //     for (i = 0; i < chart.data.datasets.length; i++) {
                //         ul.innerHTML += `<li>
                //                             <span style="background-color: ${chart.data.datasets[i].borderColor}"></span>
                //                             ${chart.data.datasets[i].label}
                //                         </li>`;
                //     }
                //     return document.getElementById(legendId).appendChild(ul);
                // },
            },
        ],
    });

    window.performanceLineChart = chart;
};
