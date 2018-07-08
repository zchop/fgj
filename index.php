<?php
/**
 * Created by PhpStorm.
 * User: KingBlanc
 * Date: 2018/3/1
 * Time: 10:46
 */
define('TOKEN','king0514');
include_once  'Message.class.php';
include_once  'Event.class.php';

//判断是否为GET请求
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    server_validate();
}else{
    //接收无键的post请求，并转成对象
    $xml = file_get_contents("php://input");
    $xml = simplexml_load_string($xml);
    //区别是事件还是消息
    if($xml -> MsgType == 'event'){
        new Event($xml);
    }else{
        new Message($xml);
    }
}

function server_validate(){
    //接收来自于微信的GET请求参数
    $signature = $_GET['signature'];
    $timestamp = $_GET['timestamp'];
    $nonce = $_GET['nonce'];
    $echostr = $_GET['echostr'];

    $arr = array(TOKEN,$timestamp,$nonce);
    sort($arr);

    $str = implode($arr);
    $str = sha1($str);

    if($str == $signature){
        echo $echostr;
    }
}
