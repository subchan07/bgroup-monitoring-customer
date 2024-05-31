const tbody = $("#tbodyMaterial");
const addForm = $("#addForm");
const updateForm = $("#updateForm");
const paymentForm = $("#paymentForm");
const currentYear = new Date().getFullYear();
const nextYear = currentYear + 1;

// tfoot table
let tfootTotalHargaText = $("#tfootTotalHargaText");
let tfootPotentialProfitThisYearText = $("#tfootPotentialProfitThisYearText");
let tfootPotentialProfitNextYearText = $("#tfootPotentialProfitNextYearText");
$("#tfootPotentialProfitThisYear").html(`Potensi Profit ${currentYear}`);
$("#tfootPotentialProfitNextYear").html(`Potensi Profit ${nextYear}`);

// filter material
const filterMaterial = localStorage.getItem("filter-material") ?? "all";
$(`.filterButton[data-filter=${filterMaterial}]`)
    .addClass("btn-primary")
    .removeClass("btn-outline-primary");

$(() => {
    // Muat data material saat halaman pertama kali dimuat
    getAllMaterial(filterMaterial);

    $(".filterButton").on("click", (event) => {
        const clickedVal = event.target.getAttribute("data-filter");
        getAllMaterial(clickedVal);

        localStorage.setItem("filter-material", clickedVal);
        $(".filterButton")
            .addClass("btn-outline-primary")
            .removeClass("btn-primary");
        $(event.target)
            .addClass("btn-primary")
            .removeClass("btn-outline-primary");
    });

    // Event delegation untuk form submit
    addForm.submit((event) => {
        event.preventDefault();
        handleFormSubmit(addForm, "/api/material", "POST");
    });

    updateForm.submit((event) => {
        event.preventDefault();
        const materialId = $("#inputIdEdit").val();
        handleFormSubmit(updateForm, `/api/material/${materialId}`, "POST");
    });

    paymentForm.submit((event) => {
        event.preventDefault();
        handleFormSubmit(paymentForm, `/api/material/pay`, "POST");
    });

    // Event delegation untuk tombol klik di dalam tbodyMaterial
    tbody.on("click", ".btn-hapus", (event) => {
        const idEl = $(event.target).closest("tr").data("id");
        handleShowConfirmDelete(idEl);
    });

    tbody.on("click", ".btn-edit", (event) => {
        const idEl = $(event.target).closest("tr").data("id");
        handleEditButtonClick(idEl);
    });

    tbody.on("click", ".btn-bayar", (event) => {
        const idEl = $(event.target).closest("tr").data("id");
        handleBayarButtonClick(idEl);
    });
});

// Fungsi untuk mendapatkan semua data material
const getAllMaterial = (filter) => {
    const addQueryParam = filter ? `?material=${filter}` : "";

    resetDataTable(".table");
    $.get(
        `/api/material${addQueryParam}`,
        (result, status) => {
            const results = result.data;
            let totalHarga = 0,
                potentialProfitThisYear = 0,
                potentialProfitNextYear = 0;

            tbody.html("");
            results.forEach((data) => {
                let year = new Date(data.due_date).getFullYear();
                let price = parseFloat(data.price);

                totalHarga += price;
                if (currentYear === year) potentialProfitThisYear += price;
                if (nextYear === year) potentialProfitNextYear += price;

                tbody.append(displayTbody(data));
            });

            if (results.length === 0)
                tbody.append(
                    '<tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>'
                );

            if (results.length > 0) {
                tfootTotalHargaText.html(rupiah(totalHarga));
                tfootPotentialProfitThisYearText.html(
                    rupiah(potentialProfitThisYear)
                );
                tfootPotentialProfitNextYearText.html(
                    rupiah(potentialProfitNextYear)
                );

                loadDataTable(".table");
            }
        },
        "json"
    );
};

// Fungsi untuk membangun HTML untuk menampilkan data material
const displayTbody = (data) => {
    const { id, item, price, billing_cycle, due_date, material } = data;
    const reminderDueDate = diffInDay(due_date);

    return `<tr data-id="${id}">
        <td>${due_date} <span class="badge badge-${badgeClassReminder(
        reminderDueDate
    )}">${reminderDueDate}</span></td>
        <td>${item}</td>
        <td>${material}</td>
        <td>${rupiah(
            price
        )} <small class="d-block text-muted">${billing_cycle}</small></td>
        <td>
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
        url: `/api/material/${idEl}`,
        type: "GET",
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (result, status) => {
            const {
                id,
                item,
                price,
                billing_cycle,
                due_date,
                material,
                is_multiple,
            } = result.data;

            // Isi nilai form dengan data material yang akan diupdate
            $("#inputIdEdit").val(id);
            $("#inputItemEdit").val(item);
            $("#inputPaymentAmountEdit").val(price);
            $("#inputDueDatePaymentEdit").val(due_date);
            $("#inputBillingCycleEdit").val(billing_cycle);
            $("#inputMaterialEdit").val(material);
            $("#inputMultipleEdit")
                .prop("checked", is_multiple)
                .prop("disabled", material !== "domain" ?? false);

            // Tampilkan modal edit
            $("#editMaterialModal").modal("show");
        },
    });
};

// Fungsi untuk menangani klik tombol Bayar
const handleBayarButtonClick = (idEl) => {
    $.ajax({
        url: `/api/material/${idEl}`,
        type: "GET",
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (result, status) => {
            const { id, item, price, due_date } = result.data;

            // Isi nilai form dengan data material yang akan diupdate
            $("#inputIdPayment").val(id);
            $("#inputMaterialNamePayment").val(item);
            $("#inputDueDatePayment").val(due_date);
            $("#inputPricePayment").val(price);

            $("#inputDatePayment").val(getCurrentDate());
            $("#inputPaymentAmount").val("");

            // Tampilkan modal edit
            $("#bayarMaterialModal").modal("show");
        },
    });
};

// Fungsi untun mengangi klik konfirmasi tombol hapus
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
        url: `/api/material/${idEl}`,
        type: "DELETE",
        cache: false,
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (response, status) => {
            getAllMaterial();
            toastFlashMessage(response.message, status);
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
            getAllMaterial();
            toastFlashMessage(results.message, status);
            form[0].reset();
            $(".modal").modal("hide");
        },
    });
};
