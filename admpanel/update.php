<?php
    session_start();
    if (empty($_SESSION['auth']) || $_SESSION['status'] == 0) {
        header("Location: index.php");
    }
    include("../config.php");
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>АвтоТранс АДМИН</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <header>
            <h1>Админ-Панель</h1>
        </header>
        <nav>
            <a href="index.php" style="color: #2ED73A">Статистика</a>
            <a href="../logout.php" style="color: red">Выйти</a>
            <a href="update.php">Редактирование заявок</a>
            <a href="comment.php">Комментарии</a>
        </nav>
        <main>
            <h2>Редактирование заявки</h2>
            <form class="form1" action="" method="POST">
                <table>
                    <tr>
                        <td>Номер заявки</td>
                        <td><select name = "id" required>
                            <?php
                            
                            $orders = db_query("SELECT id FROM `orders`");
                            
                            while($row = mysqli_fetch_assoc($orders)) {
                                print("<option value='$row[id]'>$row[id]</option>");
                            }
                            ?>
                        </select></td>
                    </tr>
                    <tr>
                        <td>Сменить описание</td>
                        <td><textarea name='opisanie' required></textarea></td>
                    </tr>
                    <tr>
                        <td>Сменить механика</td>
                        <td><select name = "id_mechanic" required>
                            <?php
                            
                            $mechanics = db_query("SELECT id, fio FROM `mechanics`");
                            
                            while($row = mysqli_fetch_assoc($mechanics)) {
                                print("<option value='$row[id]'>$row[id] - $row[fio]</option>");
                            }
                            ?>
                        </select></td>
                    </tr>
                    <tr>
                        <td>Сменить статус заявки: </td>
                        <td><select name = "status">
                            <option value="Ожидание запчастей">Ожидание запчастей</option>
                            <option value="В процессе ремонта">В процессе ремонта</option>
                            <option value="Готова к выдаче">Готова к выдаче</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button>Изменить</button></td>
                    </tr>
                </table>
            </form>
        </main>
        <?php

            if (!empty($_POST['id']) && !empty($_POST['opisanie']) && !empty($_POST['id_mechanic']) && !empty($_POST['status'])) {
                $id = $_POST['id'];
                $opisanie = $_POST['opisanie'];
                $id_mechanic = $_POST['id_mechanic'];
                $status = $_POST['status'];

                $result = mysqli_query($link, "UPDATE orders SET opisanie = '$opisanie', id_mechanic = '$id_mechanic', status = '$status', date_end = now(), 
                    hours_taken = TIMESTAMPDIFF(HOUR, `date`, `date_end`) WHERE id = '$id'");
                if ($result == 'true') {
                    header("Location: index.php");
                } else {
                    echo '<script>alert("Ошибка!")</script>';
                }
            }
        ?>
    </body>
</html>