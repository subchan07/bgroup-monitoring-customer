(function ($) {
    "use strict";

    if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
    }

    if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
    }

    $("body").on("shown.bs.modal", ".modal", function () {
        $(this)
            .find(".js-example-basic-single")
            .each(function () {
                let dropdownParent = $(document.body);
                if ($(this).parents(".modal.in:first").length !== 0)
                    dropdownParent = $(this).parents(".modal.in:first");
                $(this).select2({
                    dropdownParent: $(this).parent(),
                });
            });
    });

    $("body").on("hidden.bs.modal", ".modal", function () {
        $(this)
            .find(".js-example-basic-single")
            .each(function () {
                $(this).select2("destroy"); // Destroy the Select2 instance
            });
    });
})(jQuery);
