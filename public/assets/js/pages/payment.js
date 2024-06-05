const tbody = $("#tbodyPayment");
const tfootTotalHarga = $("#tfootTotalHarga");
const tfootTotalBayar = $("#tfootTotalBayar");
const updateForm = $("#updateForm");

$(() => {
    // Muat data payment saat halaman pertama kali dimuat
    getAllPayment();

    // Event delegation untuk form submit
    updateForm.submit((event) => {
        event.preventDefault();
        const paymentId = $("#inputIdEdit").val();
        handleFormSubmit(updateForm, `/api/payment/${paymentId}`, "POST");
    });

    // Event delegation untuk tombol klik di dalam tbody Payment
    tbody.on("click", ".btn-edit", (event) => {
        const idEl = $(event.target).closest("tr").data("id");
        handleEditButtonClick(idEl);
    });

    tbody.on("click", ".btn-detail-customer", (event) => {
        const idEl = $(event.target).data("customer");
        handleDetailCustomerButtonCLick(idEl);
    });

    tbody.on("click", ".btn-show-img", (event) => {
        event.preventDefault();
        const filename = $(event.target).data("filename");
        handleShowImg(filename);
    });
});

// Fungsi untuk mendapatkan semua data payment
const getAllPayment = () => {
    resetDataTable("#datatable");
    $.get(
        "/api/payment",
        (result, status) => {
            const results = result.data;
            let totalHarga = 0,
                totalBayar = 0;

            tbody.html("");
            results.forEach((data) => {
                totalHarga += parseInt(data.price);
                totalBayar += parseInt(data.payment_amount);
                tbody.append(displayTbody(data));
            });

            if (results.length === 0)
                tbody.append(
                    '<tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>'
                );

            if (results.length > 0) {
                tfootTotalBayar.html(rupiah(totalBayar));
                tfootTotalHarga.html(rupiah(totalHarga));

                loadDataTable("#datatable");
            }
        },
        "json"
    );
};

// Fungsi untuk membangun HTML untuk menampilkan data payment
const displayTbody = (data) => {
    const material = data.material;
    const customer = data.customer;
    // const hostingCustomer = customer ? customer.hostingMaterial : null
    // const domainCustomer = customer ? customer.domainMaterials : null
    // const sslCustomer = customer ? customer.sslMaterial : null
    let namaItem = material
        ? material.item
        : `<span class="fw-bold">${customer.service}:</span> ${customer.name}`;

    const { id, date, due_date, price, payment_amount, file } = data;

    // "  <a href='#' class='btn-detail-customer text-muted' data-customer="+customer.id+">lihat detail...</a>"
    return `<tr data-id="${id}">
                <td>${material ? "material" : "customer"}</td>
                <td>${namaItem}</td>
                <td>${date}</td>
                <td>${due_date}</td>
                <td>${rupiah(price)}</td>
                <td>${rupiah(
                    payment_amount
                )} <span class="badge badge-opacity-${
        price > payment_amount ? "danger" : "success"
    }"><i class="mdi mdi-arrow-${
        price > payment_amount ? "down" : "up"
    }-thick"></i></span></td>
                <td>
                    <button class="btn-edit btn btn-sm btn-warning btn-action">Edit</button>
                    <button class="${
                        file !== null ? "btn-show-img btn-info" : "btn-dark"
                    } btn btn-sm btn-action" data-filename="${file}" title="Lihat Bukti Pembayaran">${
        file !== null ? "Lihat" : "Belum Ada"
    }</button>
                </td>
            </tr>`;
};

const displayDetailCustomer = (title, object) => {
    if (object) {
        return `<tr>
                    <td><span class="fw-bold">${title}</span></td>
                    <td><span class="fw-bold">Item:</span> ${object.item}</td>
                </tr>
                <tr>
                    <td></td>
                    <td><span class="fw-bold">Harga:</span> ${rupiah(
                        object.price
                    )}</td>
                </tr><tr><td colspan="2" class="border-0">&nbsp;</td></tr>`;
    }
};

// HANDLE FUNCTION

// Detail data customer
const handleDetailCustomerButtonCLick = (idEl) => {
    $.ajax({
        url: `/api/customer/${idEl}?withMaterial=true`,
        type: "GET",
        cache: false,
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (result, status) => {
            const { sslMaterial, domainMaterials, hostingMaterial } =
                result.data;

            let html = "";
            domainMaterials.forEach(
                (data, i) =>
                    (html += displayDetailCustomer(`Domain ${i + 1}`, data))
            );
            html += displayDetailCustomer("Hosting", hostingMaterial);
            html += displayDetailCustomer("SSL", sslMaterial);

            $("#tbodyDetailModal").html(html);
            $("#detailCustomerModal").modal("show");
        },
    });
};

// Fungsi untuk menangani klik tombol edit
const handleEditButtonClick = (idEl) => {
    $.ajax({
        url: `/api/payment/${idEl}`,
        type: "GET",
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (result, status) => {
            const { id, due_date, date, price, payment_amount } = result.data;

            // Isi nilai form dengan data material yang akan diupdate
            $("#inputIdEdit").val(id);
            $("#inputDateEdit").val(date);
            $("#inputDueDateEdit").val(due_date);
            $("#inputPriceEdit").val(price);
            $("#inputPaymentAmountEdit").val(payment_amount);

            // Tampilkan modal edit
            $("#editPaymentModal").modal("show");
        },
    });
};

const handleShowImg = (filename) => {
    $.ajax({
        url: `/api/file/show?path=${filename}`,
        type: "GET",
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (result, status, xhr) => {
            const mimeType = xhr.getResponseHeader("Content-Type");
            const blob = new Blob([result], {
                type: mimeType,
            });
            const url = URL.createObjectURL(blob);

            // Create an img element and set its src attribute to the object URL
            const imgElement = $("<img>", {
                src: url,
                alt: "Image",
                width: "100%", // adjust as needed
            });
            $("#showImgModal .modal-body").html(imgElement);
            $("#showImgModal").modal("show");
        },
        xhrFields: {
            responseType: "blob",
        },
    });
};

// fungsi untuk form submit
const handleFormSubmit = (form, url, method) => {
    const dataForm = new FormData(form[0]);

    $.ajax({
        url: url,
        type: method,
        data: dataForm,
        processData: false,
        contentType: false,
        beforeSend: () => setButtonDisabled($(".btn-submit"), true),
        complete: () => setButtonDisabled($(".btn-submit"), false),
        success: (results, status) => {
            getAllPayment();
            toastFlashMessage(results.message, status);
            form[0].reset();
            $(".modal").modal("hide");
        },
    });
};
