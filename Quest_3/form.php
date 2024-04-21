<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Drupal Coder</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="fomaa">
    <form action="index.php" method="POST">
      <h3 id="forma">
        ФОРМА ДЛЯ ПОДПИСКИ НА РАССЫЛКУ С ЦИТАТИМИ ПРЕПОДАВАТЕЛЕЙ ФКТИПМ
      </h3>
      <label>
        <strong>
          Фамилия имя отчество:
        </strong>
        <input name="fio" type="text" placeholder="ФИО" />
      </label>
      <br>
      <label>
        <strong>
          Номер телефона:
        </strong>
        <input name="phone" type="tel" />
      </label>
      <br>
      <label>
        <strong>
          Введите вашу почту:
        </strong>
        <input name="mail" type="email" placeholder="email" />
      </label>
      <br>
      <strong>
        Укажите год рождения:
      </strong>
      <select name="year">
        <?php
        for ($i = 1922; $i <= 2022; $i++) {
          printf('<option value="%d">%d год</option>', $i, $i);
        }
        ?>
      </select><br />
      <strong>
        Укажите месяц рождения:
      </strong>
      <select name="month">
        <?php
        for ($i = 1; $i <= 12; $i++) {
          printf('<option value="%d">%d месяц</option>', $i, $i);
        }
        ?>
      </select><br />
      <strong>
        Укажите день рождения:
      </strong>
      <select name="day">
        <?php
        for ($i = 1; $i <= 31; $i++) {
          printf('<option value="%d">%d день</option>', $i, $i);
        }
        ?>
      </select>
      <br>
      <br>
      <strong>
        Пол:
      </strong>
      <label>
        <input type="radio" name="pol" required value="1">
        Мужской
      </label>
      <label>
        <input type="radio" name="pol" required value="2">
        Женский
      </label>
      <label>
        <input type="radio" name="pol" required value="3">
        Ламинат
      </label>
      <br>
      <strong>
        Любимый язык программирования:
      </strong>
      <div class="language">
        <label>
          <select name="langg[]" multiple="multiple">
            <option value="1">С</option>
            <option value="2">Pascal</option>
            <option value="3">Scala</option>
            <option value="4">C++</option>
            <option value="5">Java</option>
            <option value="6">Python</option>
            <option value="7">JavaScript</option>
            <option value="8">PHP</option>
            <option value="9">Hascel</option>
            <option value="10">Clojure</option>
            <option value="11">Prolog</option>
          </select>
        </label>
      </div>
      <label>
        <strong>
          Биография:
        </strong>
        <textarea name="biog" placeholder="Я ждал 12 лет в Азкабане..">
                </textarea>
      </label>
      <label>
        <input type="checkbox" name="V" />
        c контрактом ознакомлен(а)
      </label>
      <input type="submit" value="Сохранить" />
    </form>
  </div>
</body>

</html>