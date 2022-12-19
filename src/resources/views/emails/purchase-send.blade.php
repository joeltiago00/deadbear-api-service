<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Entrega de conta</title>
</head>
<body>
<h1>olá {{$customer->name}}</h1>
@foreach($accounts as $account)
    login: {{$account->login}} / password: {{$account->password}} / email: {{$account->email}} <br>
@endforeach
</body>
</html>
