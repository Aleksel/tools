<?php
/**
 * Created by PhpStorm.
 * User: Keiser
 * Date: 19.10.13
 * Time: 16:17
 */
class Lingvoleo extends CAction
{
    public $layout = '/layouts/default';

    public function run()
    {
        define('AUTH', "lingualeo.com/api/login"); //Адрес для аутинтификации
        define('WORD', "api.lingualeo.com/gettranslates"); //Адрес для отправки слов
        define('DEVICE_FORM', "\r\n"); //разделитель слов в форме
        define('DEVICE_FILE', "|"); //разделитель слов в файле
        define('FILE', "words.txt"); //Файл для записи
        DataPost::getData();
        //require_once('PhpConsole.php');
        //PhpConsole::start();

        //Создаем соединение для отправки запроса

        $this->getController()->render('/lingvoleo');
    }

}