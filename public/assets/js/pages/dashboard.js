const currentYear = new Date().getFullYear();
const filterChart = $("#filterChart");
$(() => {
    $(".yearPotensiProfit").html(`${currentYear}-${currentYear + 1}`);
    $(".yearPrevProfitTotal").html(`${currentYear - 1}-${currentYear}`);

    annualSummary();
    getAllMaterial();
    getAllCustomer();

    filterChart.on("change", (e) => {
        const year = filterChart.val();
        annualSummary(year);
    });
});

// const year = 2024
// const month = 5
const months = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
];

const getAllCustomer = () => {
    $.get(
        "/api/customer?orderBy=price&direction=desc&limit=10",
        (results, status) => {
            const recentEvent = $("#customerRecent");
            const datas = results.data;

            recentEvent.html("");
            datas.forEach((data, index) => {
                let name = `${data.service} - ${data.name}`;
                recentEvent.append(
                    displayRecentEvent(name, data.due_date, data.price)
                );
            });
        },
        "json"
    );
};

const getAllMaterial = () => {
    $.get(
        "/api/material?orderBy=price&direction=desc&limit=10",
        (results, status) => {
            const recentEvent = $("#materialRecent");
            const datas = results.data;

            recentEvent.html("");
            datas.forEach((data, index) =>
                recentEvent.append(
                    displayRecentEvent(data.item, data.due_date, data.price)
                )
            );
        },
        "json"
    );
};

const annualSummary = (year) => {
    let queryParam = year ? `?year=${year}` : "";

    $.get(`/api/payment/annual-summary${queryParam}`, (results, status) => {
        const {
            years,
            monthly_customer_summary,
            material_summary_current_year,
            customer_summary_current_year,
            total_summary_current_year,
        } = results.data;
        const annualSummary = results.data.paymentSummary;
        let currentTotalPriceMaterial = 0,
            currentTotalPriceCustomer = 0,
            currentTotalPrice = 0,
            prevTotalPrice = 0;

        if (annualSummary[0]?.year == currentYear) {
            currentTotalPriceMaterial = parseInt(
                annualSummary[0]?.total_price_material
            );
            currentTotalPriceCustomer = parseInt(
                annualSummary[0]?.total_price_customer
            );
            currentTotalPrice = parseInt(annualSummary[0]?.total_price);
        }

        if (annualSummary[1]?.year == currentYear - 1) {
            prevTotalPrice = parseInt(annualSummary[1].total_price);
        }

        $("#profitMaterial").html(rupiah(currentTotalPriceMaterial));
        $("#nilaiPotensiProfitMaterial")
            .html(rupiah(material_summary_current_year))
            .addClass(
                currentTotalPriceMaterial > material_summary_current_year
                    ? "text-danger"
                    : "text-success"
            );

        $("#profitUser").html(rupiah(currentTotalPriceCustomer));
        $("#nilaiPotensiProfitUser")
            .html(rupiah(customer_summary_current_year))
            .addClass(
                currentTotalPriceCustomer > customer_summary_current_year
                    ? "text-danger"
                    : "text-success"
            );

        $("#profitTotal").html(
            rupiah(currentTotalPriceCustomer - currentTotalPriceMaterial)
        );
        $("#nilaiPotensiTotal")
            .html(rupiah(prevTotalPrice))
            .addClass(
                currentTotalPrice > prevTotalPrice
                    ? "text-danger"
                    : "text-success"
            );

        initChart(monthly_customer_summary);

        filterChart.html(
            years.map((year) => `<option val="${year}">${year}</option>`)
        );
        if (year) filterChart.val(year);
        else filterChart.val(currentYear);
    });
};

const displayRecentEvent = (keterangan, due_date, price) => {
    const date = new Date(due_date);
    const month = months[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();

    return `<div class="list align-items-center border-bottom py-2">
                <div class="wrapper w-100">
                    <p class="mb-2 fw-medium line-clamp-1"> ${keterangan} </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0 text-small text-muted"><i class="mdi mdi-calendar me-1"></i><span>${month} ${day}, ${year}</span></p>
                        <p class="mb-0 text-small text-muted"><i class="mdi mdi-cash me-1"></i><span>${rupiah(
                            price
                        )}</span></p>
                    </div>
                </div>
            </div>`;
};
