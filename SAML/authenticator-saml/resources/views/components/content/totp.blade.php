<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OTP Verification Form</title>
    <link rel="stylesheet" href="style.css" />

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/totpView.css') }}">
</head>
<body>
<div class="container">
    <header>
        <i class="bx bxs-check-shield"></i>
    </header>
    <h4>Enter OTP Code</h4>
    <form action="{{ route('totp.verify') }}" method="post">
        @csrf
        <input type="hidden" name="userId" value="{{ $userId }}">
        <div class="input-field">
            <input type="number" name="num1"/>
            <input type="number" name="num2" disabled />
            <input type="number" name="num3" disabled />
            <input type="number" name="num4" disabled />
            <input type="number" name="num5" disabled />
            <input type="number" name="num6" disabled />
        </div>
        <p class="error_noneLoginTotp">You have not login TOTP webpage yet. <a href="http://127.0.0.1:8080/" target="_blank">Login TOTP</a></p>
        <button type="submit" class="btn_verify verify_otp">Verify OTP</button>
        <a href="#" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
           class="btn_verify logout_btn">Logout</a>
    </form>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

<script src="{{ asset('js/totpView.js') }}"></script>
</body>
</html>
