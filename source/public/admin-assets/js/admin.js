var BootstrapDatepicker = {
    init: function init() {
        $("#m_datepicker_1, #m_datepicker_1_validate").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_1_modal").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_2, #m_datepicker_2_validate").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_2_modal").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_3, #m_datepicker_3_validate").datepicker({
            todayBtn: "linked",
            clearBtn: !0,
            todayHighlight: !0,
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_3_modal").datepicker({
            todayBtn: "linked",
            clearBtn: !0,
            todayHighlight: !0,
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_4_1").datepicker({
            orientation: "top left",
            todayHighlight: !0,
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_4_2").datepicker({
            orientation: "top right",
            todayHighlight: !0,
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_4_3").datepicker({
            orientation: "bottom left",
            todayHighlight: !0,
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_4_4").datepicker({
            orientation: "bottom right",
            todayHighlight: !0,
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_5").datepicker({
            todayHighlight: !0,
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        }), $("#m_datepicker_6").datepicker({
            todayHighlight: !0,
            templates: { leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>' }
        });
    }
};
jQuery(document).ready(function () {
    BootstrapDatepicker.init();
});
/**
* Japanese translation for bootstrap-datepicker
* Norio Suzuki <https://github.com/suzuki/>
*/
;(function ($) {
    $.fn.datepicker.dates['ja'] = {
        days: ["日曜", "月曜", "火曜", "水曜", "木曜", "金曜", "土曜"],
        daysShort: ["日", "月", "火", "水", "木", "金", "土"],
        daysMin: ["日", "月", "火", "水", "木", "金", "土"],
        months: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        monthsShort: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        today: "今日",
        format: "yyyy/mm/dd",
        titleFormat: "yyyy年mm月",
        clear: "クリア"
    };
})(jQuery);
/**
* Vietnamese translation for bootstrap-datepicker
* An Vo <https://github.com/anvoz/>
*/
;(function ($) {
    $.fn.datepicker.dates['vi'] = {
        days: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
        daysShort: ["CN", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
        daysMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
        monthsShort: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
        today: "Hôm nay",
        clear: "Xóa",
        format: "dd/mm/yyyy"
    };
})(jQuery);
jQuery(document).ready(function () {
    /**
     * Bootstrap select
     */
    $(".m-bootstrap-select").selectpicker();
});

/**
 * Confirm form submit action
 */
function confirmSubmit(event, element) {
    event.preventDefault();

    swal({
        text: translator.trans('admin.confirm.delete.text'),
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: translator.trans('admin.confirm.delete.confirm_button'),
        cancelButtonText: translator.trans('admin.confirm.delete.cancel_button')
    }).then(function (result) {
        if (result.value) {
            $(element).parent('form').submit();
        }
    });
}

function logout(event) {
    if (event) {
        event.preventDefault();
        $('#logout-form').submit();
    }
}

function uploadFile(element) {
    element.click();
}

function loadImageToImgTag(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
}
