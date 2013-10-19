<?php
/**
 * Created by PhpStorm.
 * User: Keiser
 * Date: 19.10.13
 * Time: 16:22
 */
?>
<a href="<?php echo '/admin'; ?>">Чистка excel файла</a>

<h1>Получение слов с lingvoleo</h1>

<form action="/admin/default/lingvoleo" method="post">
    <textarea name="thetext" rows="20" cols="80">Вводим слова построчно</textarea><br>
    <input name="user" value="Keiser"/>Имя пользователя Windows<br>
    <input type="submit" value="Send"/>
</form>


