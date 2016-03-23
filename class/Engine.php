<?php

class Engine {

    private $_page_file = null;
    private $_error = null;

    public function __construct() {
        if (isset($_GET["page"])) { //Если открыта какая-нибудь страница
            //Записываем в переменную имя открытого файла (из GET запроса)
            $this->_page_file = $_GET["page"]; 
            //Небольшая защита
            $this->_page_file = str_replace(".", null, $_GET["page"]);
            $this->_page_file = str_replace("/", null, $_GET["page"]);
            $this->_page_file = str_replace("\\", null, $_GET["page"]);

             //Проверяем, если шаблон не существует
            if (!file_exists("templates/" . $this->_page_file . ".php")) {
                $this->_setError("File is not Found"); //Ошибку на экран
                $this->_page_file = "main"; //Открываем главную страницу
            }
        }
         //Если в GET запросе нет переменной page, то открываем главную
        else $this->_page_file = "main";
    }

    /**
     * Записывает ошибку в переменную _error
     * @param string $error - текст ошибки
     * @author ox2.ru 
     */
    private function _setError($error) {
        $this->_error = $error;
    }

    /**
     * Возвращает текст ошибки
     * @author ox2.ru 
     */
    public function getError() {
        return $this->_error;
    }

    /**
     * Возвращает текст открытой страницы
     */
    public function getContentPage() {
        return file_get_contents("templates/" . $this->_page_file . ".php");
    }

    public function getTitle() {
        switch ($this->_page_file) {
            case "main":
                return "Mine Page of Simple Dvij";
                break;
            case "about":
                return "About";
                break;
            case "csgo":
                return "CAse";
                break;
            default:
                break;
        }
    }

}