<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* PIN PRUEBAS */

        .pin-form {
            background: antiquewhite;
            border-radius: 20px;
            padding: 50px;
            margin: 0 auto;
            width: 200px;
            border: 1px solid;
            display: flex;
            flex-direction: column;
            align-content: flex-start;
            align-items: center;
        }

        .pin-form form {
            gap: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="pin-form">
        <h3>Necesitas un PIN para ver este proyecto.</h3>

        <form action="{{ route('pin.verify') }}" method="POST">
            @csrf
            <input type="password" name="pin" required>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>

</html>
