<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.


  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000); // Удаляем куку, указывая время устаревания в прошлом.
    $messages[] = 'Спасибо, результаты сохранены.'; // Если есть параметр save, то выводим сообщение пользователю.
  }


  //fio phone mail year month day pol langg biog V
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['phone'] = !empty($_COOKIE['phone_error']);
  $errors['mail'] = !empty($_COOKIE['mail_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['month'] = !empty($_COOKIE['month_error']);
  $errors['day'] = !empty($_COOKIE['day_error']);
  $errors['pol'] = !empty($_COOKIE['pol_error']);
  $errors['langg'] = !empty($_COOKIE['langg_error']);
  $errors['biog'] = !empty($_COOKIE['biog_error']);
  $errors['V'] = !empty($_COOKIE['V_error']);



  if ($errors['fio']) {
    setcookie('fio_error', '', 100000);
    setcookie('fio_value', '', 100000);
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['phone']) {
    setcookie('phone_error', '', 100000);
    setcookie('phone_value', '', 100000);
    $messages[] = '<div class="error">Заполните телефон.</div>';
  }
  if ($errors['mail']) {
    setcookie('mail_error', '', 100000);
    setcookie('mail_value', '', 100000);
    $messages[] = '<div class="error">Заполните почту.</div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    setcookie('year_value', '', 100000);
    $messages[] = '<div class="error">Выберите год рождения.</div>';
  }
  if ($errors['month']) {
    setcookie('month_error', '', 100000);
    setcookie('month_value', '', 100000);
    $messages[] = '<div class="error">Выберите месяц рождения.</div>';
  }
  if ($errors['day']) {
    setcookie('day_error', '', 100000);
    setcookie('day_value', '', 100000);
    $messages[] = '<div class="error">Выберите день рождения.</div>';
  }
  if ($errors['pol']) {
    setcookie('pol_error', '', 100000);
    setcookie('pol_value', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
  if ($errors['langg']) {
    setcookie('langg_error', '', 100000);
    setcookie('langg_value', '', 100000);
    $messages[] = '<div class="error">Что-то не так с языком программирования!.</div>';
  }
  if ($errors['biog']) {
    setcookie('biog_error', '', 100000);
    setcookie('biog_value', '', 100000);
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }
  if ($errors['V']) {
    setcookie('V_error', '', 100000);
    setcookie('V_value', '', 100000);
    $messages[] = '<div class="error">Подтвердите согласие.</div>';
  }


  //fio phone mail year month day pol langg biog V
  $values = array(); // Складываем значения полей в массив.
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
  $values['mail'] = empty($_COOKIE['mail_value']) ? '' : $_COOKIE['mail_value'];
  $values['year'] = empty($_COOKIE['year_value']) ?  '' : $_COOKIE['year_value'];
  $values['month'] = empty($_COOKIE['month_value']) ?  '' : $_COOKIE['month_value'];
  $values['day'] = empty($_COOKIE['day_value']) ?  '' : $_COOKIE['day_value'];
  $values['pol'] = empty($_COOKIE['pol_value']) ? '' : $_COOKIE['pol_value'];
  $values['langg'] = empty($_COOKIE['langg_value']) ? array() : unserialize($_COOKIE['langg_value']);
  $values['biog'] = empty($_COOKIE['biog_value']) ? '' : $_COOKIE['biog_value'];
  $values['V'] = empty($_COOKIE['V_value']) ? '' : $_COOKIE['V_value'];




  include ('form.php');
  exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

  include ('../Secret.php');
  $user = userr;
  $pass = passs;
  $db = new PDO(
    "mysql:host=localhost;dbname=$user",
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );


  $errors = FALSE;
  if (empty($_POST['fio']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fio'])) {
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
  }


  if (empty($_POST['phone']) || !preg_match('/^\+[0-9]{11}$/', $_POST['phone'])) {
    setcookie('phone_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);
  }


  if (empty($_POST['mail']) || !preg_match('/^([a-z0-9_-]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i', $_POST['mail'])) {
    setcookie('mail_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('mail_value', $_POST['mail'], time() + 30 * 24 * 60 * 60);
  }


  if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  }


  if (empty($_POST['month']) || !is_numeric($_POST['month']) || $_POST['month'] < 0 || $_POST['month'] > 12) {
    setcookie('month_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('month_value', $_POST['month'], time() + 30 * 24 * 60 * 60);
  }


  if (empty($_POST['day']) || !is_numeric($_POST['day']) || $_POST['day'] < 0 || $_POST['day'] > 31) {
    setcookie('day_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('day_value', $_POST['day'], time() + 30 * 24 * 60 * 60);
  }


  $polCheck = $_POST['pol'] == "1" || $_POST['pol'] == "2" || $_POST['pol'] == "3";
  if (empty($_POST['pol']) || !$polCheck) {
    setcookie('pol_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('pol_value', $_POST['pol'], time() + 30 * 24 * 60 * 60);
  }


  if (empty($_POST['langg'])) {
    setcookie('langg_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    $sth = $db->prepare("SELECT id FROM Lang");
    $sth->execute();
    $langs = $sth->fetchAll();
    $has_incorrect_lang = false;
    foreach ($_POST['langg'] as $lang) {
      $flag = true;
      foreach ($langs as $index)
        if ($index[0] == $lang) {
          $flag = false;
          break;
        }
      if ($flag == true) {
        $has_incorrect_lang = true;
        $errors = true;
        break;
      }
    }
    if (!$has_incorrect_lang) {
      setcookie('langg_value', serialize($_POST['langg']), time() + 30 * 24 * 60 * 60);
    }
  }


  if (empty($_POST['biog'])) {
    setcookie('biog_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('biog_value', $_POST['biog'], time() + 30 * 24 * 60 * 60);
  }


  if (empty($_POST['V'])) {
    setcookie('V_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } else {
    setcookie('V_value', $_POST['V'], time() + 30 * 24 * 60 * 60);
  }


  if ($errors) {
    header('Location: index.php');
    exit();
  } else {
    setcookie('fio_error', '', -10000);
    setcookie('phone_error', '', -10000);
    setcookie('mail_error', '', -10000);
    setcookie('year_error', '', -10000);
    setcookie('month_error', '', -10000);
    setcookie('day_error', '', -10000);
    setcookie('pol_error', '', -10000);
    setcookie('langg_error', '', -10000);
    setcookie('biog_error', '', -10000);
    setcookie('V_error', '', -10000);
  }


  $stmt = $db->prepare("INSERT INTO Person (fio, phone, mail, bornday, pol, biog, V) VALUES (:fio, :phone, :mail, :bornday, :pol, :biog, :V)"); //создание запроса
  $stmt->bindParam(':bornday', $bornday);
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

  $stmt->bindparam(':pol', $pol);
  $stmt->bindparam(':biog', $biog);
  $stmt->bindparam(':V', $V);
  $stmt->execute(); //отправка
  $id = $db->lastInsertId();

  foreach ($_POST['langg'] as $lang) {
    $stmt = $db->prepare("INSERT INTO person_and_lang (id_u, id_l) VALUES (:id_u,:id_l)");
    $stmt->bindParam(':id_u', $id_u);
    $stmt->bindParam(':id_l', $lang);
    $id_u = $id;
    $stmt->execute(); //отправка
  }
  setcookie('save', '1');
  header('Location: ?save=1');

}
?>