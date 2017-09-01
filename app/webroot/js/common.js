$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    var i = 1;
    $(".add_row_vertical").click(function () {
        var ref = $(this).attr("ref");
        var tb = $("#" + ref).find(".tb0").html();
        $("#" + ref).append('<div id="tb' + (i + 1) + '">' + tb + '</div>');
        i++;
        $('.datePicker').datetimepicker({
            format: "YYYY-MM-DD",
            locale: 'vi'
        });
        $('.modeYear').datetimepicker({
            format: "YYYY",
            locale: 'vi'
        });
        $(".input-group-delete").click(function () {
            $(this).closest(".input-group").find("input").val("");
        });
    });
    $(document).on('click', ".ic_delete", function () {
        $(this).closest("tr").remove();
    });

    $(document).on('click', ".ic_delete_vertical", function () {
        $(this).closest("table").remove();
    });

    $("#ac_store").click(function () {
        if (is_ac_add == 1)
            return false;
        is_ac_add = 1;
        var url = base_url + 'Action/addAjax/' + model + "/" + fiedlAuto;
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: $('form').serialize(),
            beforeSend: function () {
                $("#ac_store").prop('value', 'Đang xử lí ...');
            },
            success: function (response) {
                $("#ac_store").prop('value', 'Lưu');
                is_ac_add = 0;
            },
            error: function () {
                $("#ac_store").prop('value', 'Lưu');
                  alert("Lưu thất bại");
                is_ac_add = 0;
            }
        });

        return false;

    });

});
$("form").submit(function () {
    return true; // ensure form still submits
});
$(function () {
    $('.datePicker').datetimepicker({
        format: "YYYY-MM-DD",
        locale: 'vi'
    });
    $('.modeYear').datetimepicker({
        format: "YYYY",
        locale: 'vi'
    });
    $(".input-group-delete").click(function () {
        $(this).closest(".input-group").find("input").val("");
    });
    $('[data-toggle="tooltip"]').tooltip();
});