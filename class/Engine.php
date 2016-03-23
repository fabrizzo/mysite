<?php

class Engine {

    private $_page_file = null;
    private $_error = null;

    public function __construct() {
        if (isset($_GET["page"])) { //���� ������� �����-������ ��������
            //���������� � ���������� ��� ��������� ����� (�� GET �������)
            $this->_page_file = $_GET["page"]; 
            //��������� ������
            $this->_page_file = str_replace(".", null, $_GET["page"]);
            $this->_page_file = str_replace("/", null, $_GET["page"]);
            $this->_page_file = str_replace("\\", null, $_GET["page"]);

             //���������, ���� ������ �� ����������
            if (!file_exists("templates/" . $this->_page_file . ".php")) {
                $this->_setError("File is not Found"); //������ �� �����
                $this->_page_file = "main"; //��������� ������� ��������
            }
        }
         //���� � GET ������� ��� ���������� page, �� ��������� �������
        else $this->_page_file = "main";
    }

    /**
     * ���������� ������ � ���������� _error
     * @param string $error - ����� ������
     * @author ox2.ru 
     */
    private function _setError($error) {
        $this->_error = $error;
    }

    /**
     * ���������� ����� ������
     * @author ox2.ru 
     */
    public function getError() {
        return $this->_error;
    }

    /**
     * ���������� ����� �������� ��������
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