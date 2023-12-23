<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ Route('login') }}" method="POST">
        @csrf


        <input type="text" placeholder="username" name="username"><br><br>
        <input type="password" placeholder="password" name="password"><br><br>
        <input type="submit">
    </form>
</body>

</html>
