<?php



namespace app\models;

use Yii;
use yii\base\ErrorException;


class Tcp {
    
    private $address;
    private $port;
    public  $socket;
    public  $msg='';
    
    /*public function __construct(){
        if(!$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)){
            throw new ErrorException('Не удалось выполнить socket_create()!');
        }
        if(!socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1)){
            throw new ErrorException('Не удалось выполнить socket_set_option()!');
        }
        if (!$fp = fsockopen("192.168.156.35", 12700, $errno, $errstr)) {
            echo "ERROR: $errno - $errstr<br />\n";
        }
    }*/
    
    public function connect($address, $port){
        $this->address = $address;
        $this->port = $port;
        if (!$this->socket = fsockopen($address, $port, $errno, $errstr)) {
            echo "ERROR: $errno - $errstr<br />\n";
        }
        /*socket_connect($this->socket, $this->address, $this->port);
        if(!socket_connect($this->socket, $this->address, $this->port)){
            throw new ErrorException('Не удалось выполнить socket_connect()!');
        } */
    }
    
    public function send($msg){
        fwrite($this->socket, $msg);
        stream_set_timeout($this->socket, 5);
        /*if(!socket_write($this->socket, $msg, strlen($msg))){
            throw new ErrorException('Не удалось выполнить socket_write()!');
        }*/
    }
    
    public function read(){
        /*while ($msg = socket_read($this->socket, 2048)) {
            $this->msg = $msg;
        }*/
        $this->msg = fread($this->socket,66000);
        fclose($this->socket);
        
    }
    
    /*public function __destruct() {
        
    }*/
}
