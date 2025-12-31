<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mint Clone</title>

    <!-- Google Font -->
    <link href="https://res.cloudinary.com/dew0sokic/image/upload/v1767027804/Screenshot_2025-12-29_223303_o7fipa.png" rel="stylesheet" >

    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
        }

        /* NAVBAR */
        nav {
            background: #ffffff;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand img {
            width: 36px;
            height: 36px;
        }

        .brand span {
            font-size: 22px;
            font-weight: 700;
            color: #2ecc71;
            letter-spacing: 0.5px;
        }

        .nav-links a {
            margin-left: 18px;
            font-size: 14px;
            font-weight: 500;
            color: #34495e;
            text-decoration: none;
        }

        .nav-links a:hover {
            color: #2ecc71;
        }

        /* PAGE CONTENT */
        .container {
            padding: 24px;
        }

        /* CARD */
        .card {
            background: #fff;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        button {
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        button:hover {
            background: #27ae60;
        }
    </style>
</head>
<body>

<nav>
    <!-- LEFT: LOGO + BRAND -->
    <div class="brand">
        <img src="{{ asset('images/mint-logo.png') }}" alt="Mint Logo">
        <span>Mint Clone</span>
    </div>

    <!-- RIGHT: LINKS -->
    @auth
        <div class="nav-links">
            <a href="/dashboard">Dashboard</a>
            <a href="/accounts">Accounts</a>
            <a href="/logout">Logout</a>
        </div>
    @endauth
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>
