<?php
    session_start();
    if (empty($_SESSION['auth']) || $_SESSION['status'] == 0) {
        header("Location: ../index.php");
    } 

    include("../config.php");

    $res = fetch("SELECT COUNT(*) as count FROM orders WHERE status='Готова к выдаче'");
    $count = $res['count'];

    $aver = fetch("SELECT sum(hours_taken)/count(hours_taken) AS average_time FROM orders");

    $ent = fetch("SELECT COUNT(id) AS ct FROM orders WHERE autotype = 'Легковой'");
    $bet = fetch("SELECT COUNT(id) AS ct FROM orders WHERE autotype = 'Грузовой'");
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
            <h2>Панель Администратора</h2>
            <div class="stats">
                <p>Количество выполненных заявок: <?php echo $count ?></p>
                <p>Среднее время выполнения заявки: <?php echo intval($aver['average_time']) ?> </p>
                <p>Количество обслуженных грузовых автомобилей: <?php echo $bet['ct'] ?></p>
                <p>Количество обслуженных легковых автомобилей: <?php echo $ent['ct'] ?></p>
            </div>
            
         
            <h2>Поиск заявки</h2>
              <form class="form1" action="" method="POST">
                <table>
                    <tr>
                        <td>Дата заказа</td>
                        <td><input type="date" name="date"></td>
                    </tr>
                    <tr>
                        <td>Вид авто</td>
                        <td><select name = "autotype" required>
                            <option value="Грузовой">Грузовой</option>
                            <option value="Легковой">Легковой</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td>Модель авто</td>
                        <td><input type="text" name="model"></td>
                    </tr>
                    <tr>
                        <td>Описание заказа</td>
                        <td><textarea name="opisanie"></textarea></td>
                    </tr>
                    <tr>
                        <td>ФИО клиента</td>
                        <td><input type="text" name="fio"></td>
                    </tr>
                    <tr>
                        <td>Номер телефона клиента</td>
                        <td><input type="tel" name="phone"></td>
                    </tr>
                    <tr>
                        <td>Статус заявки: </td>
                        <td><select name = "status">
                            <option value="Ожидание запчастей">Ожидание запчастей</option>
                            <option value="В процессе ремонта">В процессе ремонта</option>
                            <option value="Готова к выдаче">Готова к выдаче</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button>Искать</button></td>
                    </tr>
                </table>
            </form>

            <h2>Все заявки</h2>
            <table>
                <tr>
                    <th>Номер заявки</th>
                    <th>Дата добавления</th>
                    <th>Вид авто</th>
                    <th>Модель авто</th>
                    <th>Описание проблемы</th>
                    <th>ФИО клиента</th>
                    <th>Телефон клиента</th>
                    <th>Статус заявки</th>
                </tr>
                <?php

                    if (empty($_POST['date'])) {
                        $date = "now()";
                    } else $date = $_POST['date'];

                    if (empty($_POST['autotype'])) {
                        $autotype = "placeholder";
                    } else $autotype = $_POST['autotype'];

                    if (empty($_POST['model'])) {
                        $model = "placeholder";
                    } else $model = $_POST['model'];

                    if (empty($_POST['opisanie'])) {
                        $opisanie = "placeholder";
                    } else $opisanie = $_POST['opisanie'];

                    if (empty($_POST['fio'])) {
                        $fio = "placeholder";
                    } else $fio = $_POST['fio'];

                    if (empty($_POST['phone'])) {
                        $phone = "placeholder";
                    } else $phone = $_POST['phone'];

                    if (empty($_POST['status'])) {
                        $status = "placeholder";
                    } else $status = $_POST['status'];

                    $result = db_query("SELECT * FROM `orders` ORDER BY id DESC");
                    
                    if (!empty($_POST)) {
                        $result = db_query("SELECT * FROM `orders` WHERE (`date` = $date OR `autotype` = '$autotype' OR `model` LIKE '%$model%' OR `opisanie` LIKE '%$opisanie%' OR `fio` LIKE '%$fio%' 
                            OR `phone` LIKE '%$phone%' OR `status` = '$status') ORDER BY `id` DESC");
                        if (mysqli_num_rows($result) <= 0) {
                            echo 
                           "<tr>
                               <td><strong style='color: red'>Нет заявок удовлетворяющих условию.</strong></td>
                            </tr>";
                        }
                        while($row = mysqli_fetch_assoc($result)) {
                            echo 
                            "<tr>
                                <td>$row[id]</td>
                                <td>$row[date]</td>
                                <td>$row[autotype]</td>
                                <td>$row[model]</td>
                                <td>$row[opisanie]</td>
                                <td>$row[fio]</td>
                                <td>$row[phone]</td>
                                <td>$row[status]</td>
                            </tr>";
                        }
                    } else {
                        if (mysqli_num_rows($result) <= 0) {
                            echo 
                           "<tr>
                               <td><strong style='color: red'>Нет заявок удовлетворяющих условию.</strong></td>
                            </tr>";
                        }
                    while($row = mysqli_fetch_assoc($result)) {
                        echo 
                        "<tr>
                            <td>$row[id]</td>
                            <td>$row[date]</td>
                            <td>$row[autotype]</td>
                            <td>$row[model]</td>
                            <td>$row[opisanie]</td>
                            <td>$row[fio]</td>
                            <td>$row[phone]</td>
                            <td>$row[status]</td>
                        </tr>";
                    }
                }
                ?>
            </table>
        </main>
    </body>
</html>