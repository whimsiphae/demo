<?php
    session_start();
    include("../config.php");
    if (empty($_SESSION['auth']) || $_SESSION['status'] == 0) {
        header("Location: index.php");
    }
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
            <h2>Комментарии</h2>
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
                        <td>Комментарий: </td>
                        <td><textarea name='comment' required></textarea></td>
                    </tr>
                    <tr>
                        <td>Запчасти и материалы: </td>
                        <td><textarea name='parts_array' required></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button>Оставить комментарий</button></td>
                    </tr>
                </table>
            </form>
        </main>
        <?php

            if (!empty($_POST['id']) && !empty($_POST['comment']) && !empty($_POST['parts_array'])) {
                $id = $_POST['id'];
                $comment = $_POST['comment'];
                $parts_array = $_POST['parts_array'];

                $result = db_query("REPLACE INTO `comments`(`order_id`, `comment`, `parts_array`) VALUES ('$id','$comment','$parts_array')");
                if ($result == 'true') {
                    header("Location: index.php");
                } else {
                    echo '<script>alert("Ошибка!")</script>';
                }
            }
        ?>
    </body>
</html>