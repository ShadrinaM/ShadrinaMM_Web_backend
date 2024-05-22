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
    /* CSS стили */
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
