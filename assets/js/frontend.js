jQuery(document).ready(function ($) {
    let is_fach_data = false;
    let is_fach_s = false;

    // Function to initialize GLightbox
    function initializeLightbox() {
        return GLightbox({
            selector: ".glightbox",
        });
    }

    // Initial lightbox setup
    let lightbox = initializeLightbox();

    $(".single-product-slider").slick({
        speed: 800,
        arrows: false,
        swipe: false,
        draggable: false,
        asNavFor: ".single-product-thumb",
        adaptiveHeight: true,
        waitForAnimate: false,
        fade: true
    });
    $(".single-product-thumb").slick({
        infinite: false,
        slidesToShow: 4,
        // speed: 800,
        arrows: false,
        focusOnSelect: true,
        asNavFor: ".single-product-slider",
        swipeToSlide: true,
        touchThreshold: 1000,
        waitForAnimate: false,
        responsive: [
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 3,
                },
            },
        ],
    });

    // Event listener for product_cat_btn click
    $("body").on("click", ".recipe_cat_btn", function (e) {
        e.preventDefault();
        $(".recipe_cat_btn").removeClass("active-btn");
        $(this).addClass("active-btn");
        let cat = $(this).data("category");
        let btn = $(this).closest(".recipe").find(".recipe__cards");
        let s = $(".recipe__filter-search-input").val();
        // Check if is_fach is false and id is not empty
        if (!is_fach_data && cat) {
            // AJAX request
            $.ajax({
                url: ajax_helper.ajaxurl,
                type: "POST",
                data: {
                    action: "get_product_by_cat",
                    security: ajax_helper.security,
                    cat,
                    s,
                },
                beforeSend: function () {
                    // Set is_fach to true
                    is_fach_data = true;
                    // loading
                    jQuery(btn).css({
                        opacity: 0.5,
                        cursor: "not-allowed",
                    });
                },
                success: function (response) {
                    console.log(response);
                    // Reset is_fach to false after response
                    is_fach_data = false;
                    if (response) {
                        btn.html(response.html);

                        // Reinitialize GLightbox after updating the content
                        lightbox = initializeLightbox();
                    }

                    // Restore button opacity
                    jQuery(btn).css({
                        opacity: 1,
                        cursor: "pointer",
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
    });
    $("body").on("click", ".recipe__filter-search-submit", function (e) {
        e.preventDefault();
        let s = $(".recipe__filter-search-input").val();
        let btn = $(this).closest(".recipe").find(".recipe__cards");
        let cat = $(".active-btn").data("category");
        // Check if is_fach is false and id is not empty
        if (!is_fach_s && s) {
            // AJAX request
            $.ajax({
                url: ajax_helper.ajaxurl,
                type: "POST",
                data: {
                    action: "get_product_by_cat",
                    security: ajax_helper.security,
                    s,
                    cat,
                },
                beforeSend: function () {
                    // Set is_fach to true
                    is_fach_s = true;
                    // loading
                    jQuery(btn).css({
                        opacity: 0.5,
                        cursor: "not-allowed",
                    });
                },
                success: function (response) {
                    console.log(response);
                    // Reset is_fach to false after response
                    is_fach_s = false;
                    if (response) {
                        btn.html(response.html);

                        // Reinitialize GLightbox after updating the content
                        lightbox = initializeLightbox();
                    }

                    // Restore button opacity
                    jQuery(btn).css({
                        opacity: 1,
                        cursor: "pointer",
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
    });
});
