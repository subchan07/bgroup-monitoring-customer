$(() => {
    // $('#greeting').html(greeting())

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            Accept: "application/json",
            Authorization: `Bearer ${localStorage.getItem("token-name")}`,
        },
        error: function (x, e) {
            if (x.status == 401) {
                flashMessage("Error", x.responseJSON.message, "error");
                setTimeout(() => {
                    location.href = "/login";
                }, 1500);
            }
        },
    });
});

const toggleDisabledButton = (elTarget, value) => {
    elTarget.prop("disabled", value);
};

const toastFlashMessage = (
    message,
    status = "success",
    position = "top-end"
) => {
    const Toast = Swal.mixin({
        toast: true,
        position: position,
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });

    Toast.fire({
        icon: status,
        title: message,
    });
};

const flashMessage = (
    title,
    message,
    success = "success",
    position = "center"
) => {
    Swal.fire({
        position: position,
        icon: success,
        title: title,
        html: message,
    });
};

const displayError = (errors) => {
    let errorMessage = "";
    for (const field in errors) {
        if (Object.hasOwnProperty.call(errors, field)) {
            const error = errors[field];
            errorMessage += `- ${error.join(", ")} </br>`;
        }
    }

    return errorMessage;
};

const setButtonDisabled = (button, value = "auto", ms = 1000) => {
    button.attr("disabled", value);

    if (value === "auto") {
        setTimeout(() => {
            button.removeAttr("disabled");
        }, ms);
    }
};

const rupiah = (number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(number);
};

const getCurrentDate = () => {
    const today = new Date(),
        year = today.getFullYear(),
        month = String(today.getMonth() + 1).padStart(2, "0"),
        day = String(today.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
};

// DATATABLE
const resetDataTable = (param) => {
    if ($.fn.dataTable.isDataTable(param)) {
        $(param).DataTable().destroy();
    }
};

const loadDataTable = (param) => {
    $(param).DataTable({
        pageLength: 10,
        order: [],
    });
};

const greeting = () => {
    const today = new Date();
    const getHour = today.getHours();
    let greeting = "";
    if (getHour > 18) {
        greeting = "Good Evening,";
    } else if (getHour > 12) {
        greeting = "Good Afternoon,";
    } else if (getHour > 0) {
        greeting = "Good Morning,";
    } else {
        greeting = "Welcome,";
    }

    return greeting;
};

const diffInDay = (date1, date2 = "now") => {
    let day1 = new Date(date1);
    let day2 = date2 === "now" ? new Date() : new Date(date2);
    let dayDiff = day1 - day2;

    return Math.round(dayDiff / (1000 * 60 * 60 * 24));
};

const badgeClassReminder = (dueDate) => {
    let classReminder = "opacity-success";
    if (dueDate > 30 && dueDate <= 60) {
        classReminder = "opacity-warning";
    } else if (dueDate > 0 && dueDate <= 30) {
        classReminder = "opacity-danger";
    } else if (dueDate <= 0) {
        classReminder = "danger";
    }

    return classReminder;
};
