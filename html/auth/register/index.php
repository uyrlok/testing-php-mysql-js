<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/admin/css/auth.css" type="text/css">
    <link rel="stylesheet" href="/admin/css/font-awesome.css" type="text/css">
</head>
<body>
<div class="container">
    <form method="post" action="reg.php">
            <?php
            if (!empty($_GET["message"]))
            {
                if($_GET["message"]=="notconfirm")
                {
                    echo('<div><label class="">Пароли не совпадают</label></div>');                    
                }
                if($_GET["message"]=="alreadylogin")
                {
                    echo('<div><label class="">Пользователь с данным именем уже существует</label></div>');                    
                }
                if($_GET["message"]=="notmail")
                {
                    echo('<div><label class="">Введите e-mail</label></div>');                    
                }
                if($_GET["message"]=="alreadymail")
                {
                    echo('<div><label class="">Пользователь с данным e-mail уже существует</label></div>');                    
                }
                if($_GET["message"]=="notrepeatpass")
                {
                    echo('<div><label class="">Не введен повтор пароля</label></div>');                    
                }
                if($_GET["message"]=="notpass")
                {
                    echo('<div><label class="">Не введен пароль</label></div>');                    
                }
                if($_GET["message"]=="notlogin")
                {
                    echo('<div><label class="">Введите логин</label></div>');                    
                }
                if($_GET["message"]=="smalllogin")
                {
                    echo('<div><label class="">Логин не может быть длиной 1 символ</label></div>');                    
                }
                
            }    
            ?>
            <div class="input">
                <input type="text" name="username" placeholder="Введите логин" autocomplete="off">
            </div>
            <div class="input">
            <input type="password" name="password" placeholder="Введите пароль" autocomplete="off" id="pswd">
            </div>
            <div class="input">
                <input type="password" name="repeatpass" placeholder="Подтвердите пароль" id="confirm">
            </div>
            <div class="input">
            <input type="mail" name="mail" placeholder="Введите адрес электронной почты">
            </div>
            <input class="submit" type="submit" name="submit" value="Зарегистрировать">

        
    </form>
</div>
</body>
</html>