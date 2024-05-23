<?php
    session_start();
    if (empty($_SESSION['auth'])) {
        header("Location: index.php");
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
            <a href="logout.php" style="color: red">Выйти</a>
            <a href="orders.php">Подать заявку</a>
            <a href="orders_all.php">Все заявки</a>
        </nav>
        <main>
            <h2>Подать заявку</h2>
            <form class="form1" action="" method="POST">
                <table>
                    <tr>
                        <td>Вид авто</td>
                        <td><select name = "autotype" required>
                            <option value="Грузовой">Грузовой</option>
                            <option value="Легковой">Легковой</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td>Модель автомобиля</td>
                        <td><input type="text" name="model" required></td>
                    </tr>
                    <tr>
                        <td>Описание заказа</td>
                        <td><textarea name="opisanie" required></textarea></td>
                    </tr>
                    <tr>
                        <td>ФИО клиента</td>
                        <td><input type="text" name="fio" required></td>
                    </tr>
                    <tr>
                        <td>Номер телефона клиента</td>
                        <td><input type="tel" name="phone" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button>Отправить</button></td>
                    </tr>
                </table>
            </form>
        </main>
        <?php
            include("config.php");

            if (!empty($_POST['autotype']) && !empty($_POST['opisanie']) && !empty($_POST['model']) && !empty($fio = $_POST['fio'])) {
                $autotype = $_POST['autotype'];
                $opisanie = $_POST['opisanie'];
                $model = $_POST['model'];
                $fio = $_POST['fio'];
                $phone = $_POST['phone'];
                $user_id = $_SESSION['user_id'];

                $result = db_query("INSERT INTO orders( `autotype`, `model`, `opisanie`, `fio`, `phone`, `id_user`) 
                    VALUES ('$autotype', '$model', '$opisanie', '$fio', '$phone', '$user_id')");
                if ($result) {
                    header("Location: orders_all.php");
                } else {
                    echo '<script>alert("Информация не добавлена!")</script>';
                }
            }
        ?>
    </body>
</html>