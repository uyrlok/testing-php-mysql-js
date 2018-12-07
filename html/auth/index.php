<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/admin/css/auth.css" type="text/css">
    <link rel="stylesheet" href="/admin/css/font-awesome.css" type="text/css">
</head>
<body>
<div class="container">
    <form method="post" action="auth.php">
            <?php
            if (!empty($_GET["message"]))
            {
                if($_GET["message"]=="no")
                {
                    echo('<div><label class="message">Неверное имя пользователя или пароль</label></div>');                    
                }
            }
            ?>
            <div class="input">
                <input type="text" name="username" placeholder="Введите логин">
            </div>
        <div class="input">
            <input type="password" name="password" placeholder="Введите пароль">
        </div>
            <input class="submit" type="submit" name="submit" value="Войти">
            <br />
            <a href="#">Восстановить пароль</a>
        
    </form>
</div>
</body>
</html>
