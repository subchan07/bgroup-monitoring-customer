const addForm = $("#addForm");
const updateForm = $("#updateForm");
const tbody = $("#tbody");

$(() => {
    getAllOprasional();

    addForm.submit((event) => {
        event.preventDefault();
        handleFormSubmit(addForm, "/api/oprasional", "POST");
    });

    updateForm.submit((event) => {
        event.preventDefault();
        const opraisonalId = $("#inputIdEdit").val();
        handleFormSubmit(updateForm, `/api/oprasional/${opraisonalId}`, "POST");
    });

    tbody.on("click", ".btn-hapus", (event) => {
        const idEl = $(event.target).closest("tr").data("id");
        handleShowConfirmDelete(idEl);
    });

    tbody.on("click", ".btn-edit", (event) => {
        const idEl = $(event.target).closest("tr").data("id");
        handleEditButtonClick(idEl);
    });
});

const getAllOprasional = () => {
    resetDataTable("#table");
    $.get(
        "/api/oprasional",
        (response, status) => {
            const datas = response.data;

            tbody.html("");
            datas.forEach((data) => {
                tbody.append(displayTbody(data));
            });

            if (datas.length > 0) {
                loadDataTable("#table");
            }
        },
        "json"
    );
};

const displayTbody = ({ id, date, detail, needs, price, note }) => {
    return `<tr data-id="${id}">
                <td>${date}</td>
                <td>
                    ${needs}
                    ${note ? `<br>${note}` : ""}
                </td>
                <td>${detail}</td>
                <td>${rupiah(price)}</td>
                <td>
                    <button type="button" class="btn-edit btn btn-sm btn-warning btn-action">Edit</button>
                    <button type="button" class="btn-hapus btn btn-sm btn-danger btn-action">Hapus</button>
                </td>
            </tr>`;
};

// HANDLE FUNCTION
const handleEditButtonClick = (idEl) => {
    $.ajax({
        url: `/api/oprasional/${idEl}`,
        type: "GET",
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (response, status) => {
            const data = response.data;

            $("#inputIdEdit").val(data.id);
            $("#inputDateEdit").val(data.date);
            $("#inputNeedsEdit").val(data.needs);
            $("#inputDetailEdit").val(data.detail);
            $("#inputPriceEdit").val(data.price);
            $("#inputNoteEdit").val(data.note);
            $("#editOprasionalModal").modal("show");
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
        url: `/api/oprasional/${idEl}`,
        type: "DELETE",
        cache: false,
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (response, status) => {
            getAllOprasional();
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
            getAllOprasional();
            toastFlashMessage(results.message, status);
            form[0].reset();
            $(".modal").modal("hide");
        },
    });
};
