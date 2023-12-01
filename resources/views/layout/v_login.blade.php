<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login sek Ngab</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: azure no-repeat;
        height: 100vh;
        font-family: sans-serif;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        overflow: hidden
    }

    @media screen and (max-width: 600px; ) {
        body {
            background-size: cover;
            : fixed
        }
    }

    #particles-js {
        height: 100%
    }

    .loginBox {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 350px;
        min-height: 200px;
        background: #3a3a3a;
        border-radius: 10px;
        padding: 40px;
        box-sizing: border-box
    }

    .user {
        margin: 0 auto;
        display: block;
        margin-bottom: 20px
    }

    h3 {
        margin: 0;
        padding: 0 0 20px;
        color: #128ddf;
        text-align: center
    }

    .loginBox input {
        width: 100%;
        margin-bottom: 20px
    }

    .loginBox input[type="text"],
    .loginBox input[type="password"] {
        border: none;
        border-bottom: 2px solid #262626;
        outline: none;
        height: 40px;
        color: #fff;
        background: transparent;
        font-size: 16px;
        padding-left: 20px;
        box-sizing: border-box
    }

    .loginBox input[type="text"]:hover,
    .loginBox input[type="password"]:hover {
        color: #457aff;
        border: 1px solid #457aff;
        box-shadow: 0 0 5px rgba(176, 176, 176, 0.3), 0 0 10px rgba(0, 255, 0, .2), 0 0 15px rgba(0, 255, 0, .1), 0 2px 0 black
    }

    .loginBox input[type="text"]:focus,
    .loginBox input[type="password"]:focus {
        border-bottom: 2px solid #42F3FA
    }

    .inputBox {
        position: relative
    }

    .inputBox span {
        position: absolute;
        top: 10px;
        color: #262626
    }

    .loginBox input[type="submit"] {
        border: none;
        outline: none;
        height: 40px;
        font-size: 16px;
        background: #128ddf;
        color: azure;
        border-radius: 20px;
        cursor: pointer
    }

    .loginBox a {
        color: #7f7f7f;
        font-size: 14px;
        font-weight: bold;
        text-decoration: none;
        text-align: center;
        display: block
    }

    a:hover {
        color: #00ffff
    }

    p {
        color: #0000ff
    }
</style>

<body>
    <div class="loginBox"> <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px" width="100px">
        <h3>Sign in here</h3>

        <form action="{{ route('auth') }}" method="post">
            @csrf
            <div class="inputBox"> <input id="username" type="text" name="username" placeholder="Username">
                <input id="password" type="password" name="password" placeholder="Password">
            </div>
            <input type="submit" name="" value="Login">
        </form>

    </div>
</body>

</html>