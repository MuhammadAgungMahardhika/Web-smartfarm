<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Not Found</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #cb8e8e;
            color: #fff;
            text-align: center;
            padding: 50px;
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            color: #fff;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            color: #fff;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Error 404 - Not Found</h1>
        <p>Maaf, Anda tidak memiliki akses ke halaman ini</p>
        <a class="btn btn-primary" href="{{ url('menuList') }}">Back to menu</a>
        <img src="/images/menu/error-noKandang2.png" alt="Boiler Farm Chicken" style="max-width: 1000px;">
    </div>
</body>

</html>
