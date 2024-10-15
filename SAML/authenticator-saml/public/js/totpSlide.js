$(function(){

    $("#slideTOTP").click(function () {
        var dataValue = $(this).data('value');

        $.ajax({
            type: "POST",
            url: `/api/ajax/account/updateOpenTotp`,
            dataType: "json",
            data: {
                userId: dataValue
            }
        })
    })

})
