<?php
header('Content-Type: text/html; charset=UTF-8');

$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
    $session_started = true;
    if (!empty($_GET['exit'])) {
        session_destroy();
        header('Location: index.php');
        exit();
    }
    if (!empty($_SESSION['hasLogged']) && $_SESSION['hasLogged'] = true) {
        header('Location: ./');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Генерируем токен CSRF для формы
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    ?>

    <form action="" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <h3 id="forma">
            ВХОД В АККАУНТ
            <h3>
                <strong>
                    Логин:
                </strong>
                <input name="login" />
                <br>
                <strong>
                    Пароль:
                </strong>
                <input name="pass" />
                <br>
                <input type="submit" value="Войти" />
    </form>

    <style>
        .fomaa {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #b0e0e6;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #b0e0e6;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #000080;
        }

        strong {
            display: block;
            margin: 10px 0;
            color: #000080;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #000080;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #000080;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0000cd;
        }
    </style>

    <?php
} else {
    include ('../Secret.php');
    $user = userr;
    $pass = passs;
    $db = new PDO(
        "mysql:host=localhost;dbname=$user",
        $user,
        $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Проверяем токен CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] != $_SESSION['csrf_token']) {
        setcookie('AUTHERROR', 'Ошибка безопасности');
        exit();
    }

    // Используем подготовленные выражения для предотвращения SQL-инъекций
    $select = $db->prepare("SELECT * FROM Logi WHERE login = :login");
    $select->bindValue(':login', $_POST['login']);
    $select->execute();

    $loginFlag = false;
    $row = $select->fetch();
    if ($row && md5($_POST['pass']) == $row['password']) {
        $loginFlag = true;
    }

    if ($loginFlag) {
        $_SESSION['hasLogged'] = true;
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['pass'] = $_POST['pass'];
    } else {
        $_SESSION['hasLogged'] = false;
        $_SESSION['login'] = '';
        $_SESSION['pass'] = '';
        setcookie('AUTHERROR', 'Неверный логин или пароль');
    }

    header('Location: ./');
}
