const tbody = $("#tbody");
const btnRefresh = $("#btn-refresh");

$(() => {
    getAllFile();

    btnRefresh.on("click", (event) => {
        event.preventDefault();
        displayLoading();
        getAllFile();
    });

    tbody.on("click", ".btn-delete", (event) => {
        const dataOriginal = $(event.target).closest("tr").data("original");
        handleShowConfirmDelete(dataOriginal);
    });

    tbody.on("click", ".btn-download", (event) => {
        const dataOriginal = $(event.target).closest("tr").data("original");
        handleDownloadButtonClick(dataOriginal);
    });
});

const getAllFile = async () => {
    const results = await $.get(
        `/api/file?directory=Monitoring-customer`,
        (result, status) => {
            const results = result.data;
            tbody.html("");
            results.forEach((data) => {
                tbody.append(displayTbody(data));
            });

            if (results.length === 0) {
                tbody.html(
                    '<tr><td colspan="4" class="text-center fw-bold">No File.</td></tr>'
                );
            }
        },
        "json"
    );
};

const displayTbody = (data) => {
    const { original, name, size, last_modified } = data;

    return `<tr data-original="${name}">
                        <td>${name}</td>
                        <td>${convertFileSize(size)}</td>
                        <td>${last_modified}</td>
                        <td>
                            <button type="button" class="btn-download btn btn-sm btn-primary btn-action"">Download</button>
                            <button type="button" class="btn-delete btn btn-sm btn-danger btn-action">Hapus</button>
                        </td>
                    </tr>`;
};

const convertFileSize = (bytes) => {
    if (bytes == 0) return "0 Bytes";
    const sizes = ["Bytes", "KB", "MB", "GB", "TB"];
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + " " + sizes[i];
};

// Fungsi untuk menangani klik konfirmasi tombol hapus
const handleShowConfirmDelete = (dataOriginal) => [
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
            handleDeleteButtonClick(dataOriginal);
        }
    }),
];

const handleDeleteButtonClick = (dataOriginal) => {
    $.ajax({
        url: "/api/file/delete",
        type: "POST",
        data: {
            path: `Monitoring-customer/${dataOriginal}`,
        },
        dataType: "JSON",
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: (results, status) => {
            if (status === "success") {
                getAllFile();
                toastFlashMessage(results.message, status);
            }
        },
    });
};

const handleDownloadButtonClick = (dataOriginal) => {
    $.ajax({
        url: "/api/file/download",
        type: "POST",
        data: {
            path: `Monitoring-customer/${dataOriginal}`,
        },
        xhrFields: {
            responseType: "blob",
        },
        beforeSend: () => setButtonDisabled($(".btn-action"), true),
        complete: () => setButtonDisabled($(".btn-action"), false),
        success: function (data, status, xhr) {
            if (status === "success") {
                const filename = dataOriginal;
                const blob = new Blob([data], {
                    type: xhr.getResponseHeader("content-type"),
                });
                const link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                link.click();

                toastFlashMessage("File berhasil didownload", status);
            }
        },
    });
};

const displayLoading = () => {
    tbody.html(
        '<tr><td colspan="4" class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>'
    );
};
