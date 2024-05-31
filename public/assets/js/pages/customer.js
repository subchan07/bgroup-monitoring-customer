const minusIcon = '<i class="mdi mdi-minus text-danger"></i>';
const checkIcon = '<i class="mdi mdi-check text-success"></i>';
const tbody = $("#tbodyCustomer");
const addForm = $("#addForm");
const updateForm = $("#updateForm");
const paymentForm = $("#paymentForm");
const selectCustomer = $(".select-customer");
const selectDomain = $(".select-domain");
const selectHosting = $(".select-hosting");
const selectSsl = $(".select-ssl");

const currentYear = new Date().getFullYear();
const nextYear = currentYear + 1;

// Tfoot table
let tfootTotalHargaText = $("#tfootTotalHargaText");
let tfootPotentialProfitThisYearText = $("#tfootPotentialProfitThisYearText");
let tfootPotentialProfitNextYearText = $("#tfootPotentialProfitNextYearText");
$("#tfootPotentialProfitThisYear").html(`Potensi Profit ${currentYear}`);
$("#tfootPotentialProfitNextYear").html(`Potensi Profit ${nextYear}`);

$(() => {
    // Muat data customer saat halaman pertama kali dimuat
    getAllCustomer();

    // Event delegation untuk form submit
    addForm.submit((event) => {
        event.preventDefault();
        handleFormSubmit(addForm, "/api/customer", "POST");
    });

    updateForm.submit((event) => {
        event.preventDefault();
        const customerId = $("#inputIdEdit").val();
        handleFormSubmit(updateForm, `/api/customer/${customerId}`, "POST");
    });

    paymentForm.submit((event) => {
        event.preventDefault();
        handleFormSubmit(paymentForm, `/api/customer/pay`, "POST");
    });

    // Event delegation untuk tombol klik di dalam tbodyMaterial
    tbody.on("click", ".btn-hapus", (event) => {
        const id = $(event.target).closest("tr").data("id");
        handleShowConfirmDelete(id);
    });

    tbody.on("click", ".btn-edit", (event) => {
        const idEl = $(event.target).closest("tr").data("id");
        handleEditButtonClick(idEl);
    });

    tbody.on("click", ".btn-bayar", (event) => {
        const idEl = $(event.target).closest("tr").data("id");
        handleBayarButtonClick(idEl);
    });

    tbody.on("click", ".btn-detail", (event) => {
        const idEl = $(event.target).closest("tr").data("id");
        handleDetailButtonCLick(idEl);
    });

    selectCustomer.on("change", (event) => {
        const targetIdEl = $(event.target).data("target_id");
        showHideElement(event.target, targetIdEl, "other");
    });
});

// Fungsi untuk mendapatkan semua data material
const getAllMaterial = () => {
    $.get(
        "/api/material?unused_by_customers=true",
        (result, status) => {
            const results = result.data;

            selectDomain.html('<option disabled value="">-- Pilih --</option>');
            selectHosting.html(
                '<option selected disabled value="">-- Pilih --</option>'
            );
            selectSsl.html(
                '<option selected disabled value="">-- Pilih --</option>'
            );

            results.forEach((data) => {
                if (data.material === "hosting")
                    selectHosting.append(
                        `<option value="${data.id}">${data.item}</option>`
                    );
                if (data.material == "domain")
                    selectDomain.append(
                        `<option value="${data.id}">${data.item}</option>`
                    );
                if (data.material == "ssl")
                    selectSsl.append(
                        `<option value="${data.id}">${data.item}</option>`
                    );
            });
        },
        "json"
    );
};

// Fungsi untuk mendapatkan semua data customer
const getAllCustomer = () => {
    resetDataTable("#datatable");
    $.get(
        "/api/customer",
        (result, status) => {
            const results = result.data;
            let totalHarga = 0,
                potentialProfitThisYear = 0,
                potentialProfitNextYear = 0;

            tbody.html("");
            selectCustomer.html(
                "<option selected value=''>-- Pilih --</option>"
            );
            results.forEach((data) => {
                const year = new Date(data.due_date).getFullYear();
                const price = parseFloat(data.price);

                totalHarga += price;
                if (currentYear === year) potentialProfitThisYear += price;
                if (nextYear === year) potentialProfitNextYear += price;

                tbody.append(displayTbody(data));
                selectCustomer.append(
                    `<option value="${data.name}">${data.name}</option>`
                );
            });

            if (results.length === 0)
                tbody.append(
                    '<tr><td colspan="9" class="text-center">Data tidak ditemukan.</td></tr>'
                );

            if (results.length > 0) {
                loadDataTable("#datatable");

                tfootTotalHargaText.html(rupiah(totalHarga));
                tfootPotentialProfitThisYearText.html(
                    rupiah(potentialProfitThisYear)
                );
                tfootPotentialProfitNextYearText.html(
                    rupiah(potentialProfitNextYear)
                );
                selectCustomer.append(
                    `<option value="other"><strong>Lainnya...</strong></option>`
                );
            }

            getAllMaterial();
        },
        "json"
    );
};

// Fungsi untuk membangun HTML untuk menampilkan data customer
const displayTbody = (data) => {
    const {
        id,
        name,
        service,
        domain,
        due_date,
        price,
        domainMaterials,
        hostingMaterial,
        sslMaterial,
    } = data;
    const reminderDueDate = diffInDay(due_date);

    return `<tr data-id="${id}">
                <td>${due_date} <span class="badge badge-${badgeClassReminder(
        reminderDueDate
    )}">${reminderDueDate}</span></td>
                <td>${name}</td>
                <td>${service}</td>
                <td>${domain}</td>
                <td class="text-center">${
                    domainMaterials && domainMaterials.length === 0
                        ? minusIcon
                        : checkIcon
                }</td>
                <td class="text-center">${
                    hostingMaterial === null ? minusIcon : checkIcon
                }</td>
                <td class="text-center">${
                    sslMaterial === null ? minusIcon : checkIcon
                }</td>
                <td>${rupiah(price)}</td>
                <td>
                    <button class="btn-detail btn btn-sm btn-success btn-action">Detail</button>
                    <button class="btn-bayar btn btn-sm btn-info btn-action">Bayar</button>
                    <button class="btn-edit btn btn-sm btn-warning btn-action">Edit</button>
                    <button class="btn-hapus btn btn-sm btn-danger btn-action">Hapus</button>
                </td>
            </tr>`;
};

// HANDLE FUNCTION

// Fungsi untuk menangani klik tombol edit
const handleEditButtonClick = (idEl) => {
    $.ajax({
        url: `/api/customer/${idEl}?withMaterial=true`,
        type: "GET",
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (result, status) => {
            const selectDomainEdit = $("#inputDomainMaterialEdit");
            const selectSslEdit = $("#inputSslMaterialEdit");

            const {
                id,
                name,
                service,
                domain,
                due_date,
                price,
                domain_material_ids,
                hosting_material_id,
                ssl_material_id,
                sslMaterial,
                domainMaterials,
            } = result.data;

            // hapus elemen select option old-material
            $(".old-material").remove();

            // tambahkan select option edit
            if (domainMaterials && domainMaterials.length >= 0) {
                domainMaterials.forEach((data, index) => {
                    if (!data.is_multiple)
                        selectDomainEdit.append(
                            `<option class="old-material" value="${data.id}">${data.item}</option>`
                        );
                });
            }

            if (sslMaterial)
                selectSslEdit.append(
                    `<option class="old-material" value="${sslMaterial.id}">${sslMaterial.item}</option>`
                );

            $("#inputIdEdit").val(id);
            $("#inputNameEdit").val(name);
            $("#inputOtherNameEdit").addClass("d-none").removeAttr("required");
            $("#inputServiceEdit").val(service);
            $("#inputDomainEdit").val(domain);
            $("#inputDueDateEdit").val(due_date);
            $("#inputPriceEdit").val(price);
            $("#inputHostingMaterialEdit").val(hosting_material_id);
            selectDomainEdit.val(domain_material_ids);
            selectSslEdit.val(ssl_material_id);

            $("#editCustomerModal").modal("show");
        },
    });
};

// Fungsi untuk menangani klik tombol Bayar
const handleBayarButtonClick = (idEl) => {
    $.ajax({
        url: `/api/customer/${idEl}`,
        type: "GET",
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (result, status) => {
            const { id, name, due_date, price } = result.data;

            // Isi nilai form dengan data customer yang akan diupdate
            $("#inputIdPayment").val(id);
            $("#inputCustomerNamePayment").val(name);
            $("#inputDueDatePayment").val(due_date);
            $("#inputPricePayment").val(price);

            $("#inputDatePayment").val(getCurrentDate());
            $("#inputPaymentAmount").val("");

            // Tampilkan modal edit
            $("#bayarCustomerModal").modal("show");
        },
    });
};

// Fungsi untuk menangani klik konfirmasi tombol Hapus
const handleShowConfirmDelete = (idEl) => {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Data ini tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            handleHapusButtonClick(idEl);
        }
    });
};

// Fungsi untuk menangani klik tombol Hapus
const handleHapusButtonClick = (idEl) => {
    $.ajax({
        url: `/api/customer/${idEl}`,
        type: "DELETE",
        cache: false,
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (response, status) => {
            getAllCustomer();
            toastFlashMessage(response.message, status);
        },
    });
};

// fungsi untuk detail data
const handleDetailButtonCLick = (idEl) => {
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
            getAllCustomer();
            toastFlashMessage(results.message, status);
            form[0].reset();
            $(".modal").modal("hide");
        },
    });
};
