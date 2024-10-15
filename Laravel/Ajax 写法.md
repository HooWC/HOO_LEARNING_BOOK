### Ajax 写法

```
 <p class="id" style="display:none" id="user_id_disabled">{{auth()->user()->id}}</p>
```

```
var user_id = document.getElementById('user_id_disabled').innerText;

function executeCode() {
    $.ajax({
        type: "POST",
        url: `/api/ajax/account/getNewAuthenticator`,
        dataType: "json",
        data: {
            user_id: user_id
        },
        success: function (data) {

            $("#verification_code_tbody").empty();

            var num = 0;
            $.each(data, function (x, y) {
                num++;
                $("#verification_code_tbody").append(`
        			<tr>
            			<td>${num}</td>
                        <td>${y.authenticatorCode.account_name}</td>
                        <td>${y.authenticatorCode.authenticator_code}</td>
                        <td>
                            <i class="fas trash_verification" id="${y.authenticatorCode.id}"></i>
                        </td>
                    </tr>
                `)
            })

            $(".trash_verification").click(function () {
                var authenticatorID = $(this).attr('id');

                $.ajax({
                    type: "POST",
                    url: `/api/ajax/account/deleteAuthenticatorFunction`,
                    dataType: "json",
                    data: {
                        authenticatorID: authenticatorID
                    },
                    success: function (data) {
                        if (data == true) {
                            getSelectAccountName()
                            executeCode();
                        }
                    }
                })
            })

        }
    })
}
```

```
$('.Click-here_authenticator').click(function () {
        $.ajax({
            type: "GET",
            url: `/api/ajax/account/getKeyCode`,
            dataType: "json",
            success: function (data) {

                $("#authenticator_input").empty();

                $("#authenticator_input").append(`
                    <input name="secret_key" value="${data}" readonly type="text" class="card-input__input" placeholder="Your Key" v-on:focus="focusInput" v-on:blur="blurInput" autocomplete="off" required>
                `)
            }
        })
    })
```

