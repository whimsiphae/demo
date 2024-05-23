<?php
    session_start();
    if (!empty($_SESSION['auth'])) {
        if ($_SESSION['status'] == 0) 
            header("Location: orders_all.php");
        elseif ($_SESSION['status'] == 1)
            header("Location: admpanel/index.php");
    }
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>АвтоТранс</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header>
            <h1>Сервисный Центр АвтоТранс</h1>
        </header>
        <nav>
            <a href="index.php">Войти</a>
            <a href="register.php">Регистрация</a>
        </nav>
        <main>
            <h2>Регистрация</h2>
            <form class="form1" action="" method="POST">
                <table>
                    <tr>
                        <td>Логин: </td>
                        <td><input type="text" name="login" required></td>
                    </tr>
                    <tr>
                        <td>Пароль: </td>
                        <td><input type="password" name="password" required></td>
                    </tr>
                    <tr>
                        <td>Подтвердить пароль: </td>
                        <td><input type="password" name="confirm" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button>Зарегистрироваться</button></td>
                    </tr>
                </table>
            </form>
        </main>
        <?php
        include("config.php");

        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['confirm']) && $_POST['password'] != $_POST['confirm']) {
            echo '<script>alert("Пароли не совпадают.")</script>';
        }
        
        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['confirm']) && $_POST['password'] == $_POST['confirm']) {
            $login = $_POST['login'];
            $password = md5($_POST['password']);

            db_query("INSERT INTO `users`(`login`, `password`) VALUES ('$login', '$password')");

            $user = fetch("SELECT * FROM users WHERE login = '$login' AND password = '$password'");

            if(!empty($user)) {
                $_SESSION['auth'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['status'] = $user['admin'];
                header("Location: orders.php");
            } else {
                echo '<script>alert("Во время регистрации произошла непредвиденная ошибка.")</script>';
            }
        }
        ?>
    </body>
</html>