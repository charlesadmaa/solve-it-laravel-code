<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
</head>

<style>
    body,
    div,
    p,
    td,
    th,
    table,
    p {
        font-family: 'Poppins', sans-serif;
    }

    .logo_img {
        width: 160px;
        height: auto;
        margin: 0 auto;
        margin-bottom: 20px;
    }

    .logo_img img {
        width: 100%;
        height: auto;
    }
</style>

<body style="margin:0px; background: #ECF0F1; ">
    <div width="100%"
        style="padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
        <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td>
                            <div style="display: none"> You are receiving this email because you or someone initiated
                                the registration
                                process on our website solve-it.ng</div>
                            {{-- <div class="logo_img" style="text-align: center; margin-bottom: 20px;">
                                <img width="150px" src="{{ asset('images/logo.png') }}" alt="logo">
                            </div> --}}
                        </td>
                    </tr>
                </tbody>
            </table>


            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td
                            style="border-top-right-radius: 3px; border-top-left-radius: 3px; padding: 10px 20px; color: #fff; text-align: center; background: #051c32; font-weight: 500;">
                            Verify your email </td>
                    </tr>
                </tbody>
            </table>
            <div style="padding: 40px; background: #fff;">
                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                <p>
                                    You are receiving this email because you or someone initiated the registration
                                    process on our website solve-it.ng
                                    If you did not intend to register on our platform, kindly ignore this message,
                                    otherwise, below is your verification code
                                </p>
                                <div
                                style="
                                padding: 25px;
                                background: #faf9f5;
                                border-radius: 1rem;
                                letter-spacing:8px;
                                font-size:24px;
                                font-weight: 500;
                                color:#000000;
                                text-align: center;
                                ">{{ $verificationCode }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
