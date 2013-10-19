<?php
/**
 * Created by PhpStorm.
 * User: Keiser
 * Date: 19.10.13
 * Time: 16:29
 */

class DataPost {

    private static $url;
    private static $post;
    private static $ch;

    private static function getConnect() {
        self::$ch = curl_init();
        curl_setopt(self::$ch, CURLOPT_URL, self::$url);
        //curl_setopt ($this->ch, CURLOPT_VERBOSE, 2); // Отображать детальную информацию о соединении
        curl_setopt(self::$ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); //Прописываем User Agent, чтобы приняли за своего
        curl_setopt(self::$ch, CURLOPT_COOKIEJAR, "cookie.txt");
        curl_setopt(self::$ch, CURLOPT_COOKIEFILE, "cookie.txt");
        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, self::$post);
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, 1);  // Возвращать результат
        curl_setopt(self::$ch, CURLOPT_HEADER, 1); // Наши заголовочки
        curl_setopt(self::$ch, CURLINFO_HEADER_OUT, 1); // Где то наткнулся на этот параметр, решил оставить
        curl_setopt(self::$ch, CURLOPT_CONNECTTIMEOUT, 60);
        return curl_exec(self::$ch);
    }

    private function __destruct() {
        if ($this->ch)
            curl_close($this->ch);
    }

    private static function sendPost($url, $post = "") {
        self::$url = $url;
        if (WORD === (self::$url))
            self::$post = "word=" . $post . "&include_media=1&add_word_forms=1&port=1002";
        else {
            self::$post = "port=1002";
            $result = self::getConnect();
            $res = json_decode(substr($result, stripos($result, '{"error_msg"'), strlen($result)), true);
            self::$post = "email=omatic2001@mail.ru&password=omatic321&port=1002";
        }
        $result = self::getConnect();
        $res = json_decode(substr($result, stripos($result, '{"error_msg"'), strlen($result)), true);
        return $res;
    }

    static function getData() {
        if ("POST" === $_SERVER['REQUEST_METHOD']) {
            define('PATH', $_POST['user']);
            if (file_exists(FILE)) {
                date_default_timezone_set('Europe/Moscow');
                rename(FILE, "words" . date("d_m_Y H_i", time()) . ".txt");
            }
            self::sendPost(AUTH);
            $words = explode(DEVICE_FORM, strip_tags(trim($_POST['thetext'])));
            foreach ($words as $word) {
                unset($out);
                $i = 0;
                $res = self::sendPost(WORD, $word);
                $out["word"] = $word;
                //Копируем картинку в папку Lingialeo/pic и в папку Anki
                $path = Yii::app()->basePath.'\\..\\public\\lingvoleo\\pic\\' . $word . ".png";
                file_put_contents($path, file_get_contents($res["pic_url"]));
                $out["pic"] = $path;
                //CVarDumper::dump($path,7,1); die();
                $path = 'c:\\Users\\' . PATH . '\\Documents\\Anki\\Andrey\\collection.media\\' . $word . ".png";
                copy($out["pic"], $path);
                //file_put_contents($path, file_get_contents($res["pic_url"]));


                $out["transcription"] = $res["transcription"];

                //Копируем mp3 в папку Lingialeo/sound и в папку Anki
                $path = Yii::app()->basePath.'\\..\\public\\lingvoleo\\sound\\' . $word . ".mp3";
                file_put_contents($path, file_get_contents($res["sound_url"]));
                $out["sound"] = $path;
                ;

                $path = 'c:\\Users\\' . PATH . '\\Documents\\Anki\\Andrey\\collection.media\\' . $word . ".mp3";
                copy($out["sound"], $path);
                //file_put_contents($path, file_get_contents($res["sound_url"]));

                foreach ($res["translate"] as $item) {
                    if ($item["votes"] > 50) {
                        if ($i) {
                            $out["translate"].= "; " . $item["value"];
                            $out["votes"].= "; " . $item["votes"];
                        } else {
                            $out["translate"] = $item["value"];
                            $out["votes"] = $item["votes"];
                            $i = 1;
                        }
                    } else
                        if (!isset($out["translate"]))
                            $out["translate"] = "";
                }
                $file = $out["word"] . DEVICE_FILE;
                $file.= $out["translate"] . DEVICE_FILE;
                $file.= $out["transcription"] . DEVICE_FILE;
                $file.= "'" . $out["word"] . ".png" . "'" . DEVICE_FILE;
                $file.= '[sound:' . $out["word"] . '.mp3]' . DEVICE_FILE;
                $file.= $out["sound"] . "\r\n";
                file_put_contents(FILE, $file, FILE_APPEND);
            }
        }
    }


} 