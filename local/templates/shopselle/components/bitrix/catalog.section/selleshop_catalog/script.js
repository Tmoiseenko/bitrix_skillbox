$(document).ready(function () {
    $('#js_sort_field').on('change', function (e) {
        window.location.href = $(this).val();
    })

    $('#js_sort_direction').on('change', function (e) {
        window.location.href = $(this).val();
    })

    $('#js_on_page').on('change', function (e) {
        window.location.href = $(this).val();
    })
})