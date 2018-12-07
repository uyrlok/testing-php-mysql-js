<?php
    require($_SERVER['DOCUMENT_ROOT']."/admin/header.php");

    if (isset($m)){
        if ($m['status']!=true)
        {
            header('Location: /auth/');
        }
        
    }
    else
    {
        header('Location: /auth/');
    } 

    
?>
<script type="text/javascript">
$(function(){
    if(getCookie("status"))
    {
        $('#modal').css("display","block");
    }
    var timerId = setTimeout(function periodicMethod(e){
        if(getCookie("status"))
        {
            var id = getCookie("id");
            var status = getCookie('status');
            $.post('checkstatus1.php',{id:id,status:status},function(data){
                eval("var obj="+data);
                //$('#percent').css("display","block");
                var elem = document.getElementById("myBar");
                elem.style.width = obj.status;
                $('#percent').text(obj.status);
                if(obj.status=="success")
                {
                    elem.style.width = 100 + "%";
                    var date = new Date(new Date().getTime());
                    document.cookie = "status=start; path=/; expires=" + date.toUTCString();
                }
            })
        }
        timerId = setTimeout(periodicMethod,100);
    },100);

    $('#perform').click(function(e){
        $('#modal').css("display","block");
        if(!getCookie("status"))
        {
        var filename="/test/tenthousandsinserts.php";
        var id = getCookie("id");
        
        var date = new Date(new Date().getTime() + 60*60*24*30);
        //alert(date);
        document.cookie = "status=start; path=/; expires=" + date.toUTCString();

        var status = getCookie('status');
        alert(status);
        $.post('checkstatus.php',{id:id,filename:filename,status:status},function(data,status){
            alert(data);
            $('#percent').css("display","block");
            $('#percent').text("Загрузка началась");
        })
        }
    });
});


function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}
</script>


<form method="POST" id="changeprofile_form" action="changeprofile.php">

<div class="container">
    <div>
        <div>
            <?php
            if(isset($_GET["msgl"]))
            if($_GET["msgl"]=="loginsuccess")
            {
                echo('<div>Логин успешно изменен</div>');
            }
            echo('<input class="input" type="text" name="login" id="login" value="'.$m['login'].'"/>
            <div class="label">
                Сменить имя пользователя
            </div>');
            ?>
        </div>
        <div>
        <?php
            if(isset($_GET["msge"]))
            if($_GET["msge"]=="emailsuccess")
            {
                echo('<div>E-mail успешно изменен</div>');
            }
            echo('<input class="input" type="text" name="e-mail" id="e-mail" value="'.$m['mail'].'"/>
            <div class="label">
                Сменить e-mail
            </div>');
            ?>
        </div>
    </div>
</div>

<div class="container">
    <div>
        <?php
            if(isset($_GET["msgp"]))
            {
                if($_GET["msgp"]=="changesuccess")
                {
                    echo('<div>Пароль успешно изменен</div>');
                }
                else if($_GET["msgp"]=="alreadyexists")
                {
                    echo('<div>Введите пароль, отличающийся от текущего</div>');
                }
                else if($_GET["msgp"]=="wrongpswd")
                {
                    echo('<div>Неверно введен пароль или подтверждение пароля</div>');
                }
                else if($_GET["msgp"]=="notenterconfirmpswd")
                {
                    echo('<div>Не введено подтверждение пароля</div>'); 
                }
            }
        ?>
        Сменить пароль:
        <div class="newpass">
        <input class="input" type="password" name="passwd" id="passwd"/>
        <input class="input" type="password" name="confirmpasswd" id="confirmpasswd"/>
        </div>
    </div>
</div>

<input id="save" type="submit" name="submit" value="Сохранить">
</form>

<input id="perform" type="submit" name="submit" value="Выполнить">

<div id="modal">
    <div id="myProgress">
        <div id="myBar">
            <div id="percent">0%</div>
        </div>
    </div>
</div>