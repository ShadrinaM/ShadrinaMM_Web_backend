<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty ($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print ('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include ('form.php');
  // Завершаем работу скрипта.
  exit();
}

// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
$errors = FALSE;
if (empty($_POST['fio']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fio'])) {
  print ('Заполните имя.<br/>');
  $errors = TRUE;
}
if (empty($_POST['phone']) || !preg_match('/^\+[0-9]{11}$/', $_POST['phone'])) {
  print ('Заполните телефон.<br/>');
  $errors = TRUE;
}

if (empty ($_POST['mail']) || !preg_match('/^([a-z0-9_-]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i', $_POST['mail'])) {
  print ('Заполните почту.<br/>');
  $errors = TRUE;
}
if (empty ($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  print ('Заполните год.<br/>');
  $errors = TRUE;
}

if (empty ($_POST['month'])|| !is_numeric($_POST['year'])||$_POST['month']<0||$_POST['month']>12) {
  print ('Заполните месяц.<br/>');
  $errors = TRUE;
}

if (empty ($_POST['day'])|| !is_numeric($_POST['year'])||$_POST['day']<0||$_POST['day']>31) {
  print ('Заполните день.<br/>');
  $errors = TRUE;
}

if (empty ($_POST['pol'])) {
  print ('Выберите пол.<br/>');
  $errors = TRUE;
}

$user = 'u67304';
$pass = '4684538';
$db = new PDO(
  'mysql:host=localhost;dbname=u67304',
  $user,
  $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

if (empty($_POST['lang'])) {
  print ('Выберите язык програмирования.<br/>');
  $errors = TRUE;
} else {
  $sth = $db->prepare("SELECT id FROM Lang");
  $sth->execute();
  $langs = $sth->fetchAll();
  foreach ($_POST['lang'] as $lang) {
    $flag = TRue;
    foreach ($langs as $index)
      if ($index[0] == $lang) //т.к. index есть не то что можно сравнить с $lang
      {
        $flag = false;
        break;
      }
    if ($flag == true) {
      print ('Error: no valid language');
      $errors = true;
      break;
    }
  }
}

if (empty ($_POST['biog'])) {
  print ('Заполните биографию.<br/>');
  $errors = TRUE;
}

if ($_POST['V']!="on") {
  print ('Подвердите согласие.<br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
}

$stmt = $db->prepare("INSERT INTO Person (fio, phone, mail, bornday, pol, biog, V) VALUES (:fio, :phone, :mail, :bornday, :pol, :biog, :V)"); //создание запроса
$fio = $_POST['fio'];
$phone = $_POST['phone'];
$mail = $_POST['mail'];
$bornday = $_POST['day'] . '.' . $_POST['month'] . '.' . $_POST['year'];
$pol = $_POST['pol'];
$biog = $_POST['biog'];
$V = true;
$stmt->bindParam(':fio', $fio);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':mail', $mail);
$stmt->bindParam(':bornday', $bornday);
$stmt->bindparam(':pol', $pol);
$stmt->bindparam(':biog', $biog);
$stmt->bindparam(':V', $V);
$stmt->execute(); //отправка
$id = $db->lastInsertId();

foreach ($_POST['lang'] as $lang) {
  $stmt = $db->prepare("INSERT INTO person_lang (id_u, id_l) VALUES (:id_u,:id_l)");
  $stmt->bindParam(':id_u', $id_u);
  $stmt->bindParam(':id_l', $lang);
  $id_u=$id;
  $stmt->execute(); //отправка
}

header('Location: ?save=1');
