<?php
$host = 'localhost';
$userName = 'root';
$passWord = 'root';
$dbName = 'travel';

/*
 * 查询数据库返回一行数据
 */
function query_row($sql) {
    global $host, $userName, $passWord, $dbName;
    $link = mysqli_connect($host, $userName, $passWord, $dbName);
    $result = mysqli_query($link, $sql);
    if($result) {
        $data = mysqli_fetch_assoc($result);
        return $data;
    } else {
        return false;
    }
}

/*
 * 查询数据库返回一个列表
 */
function query_list($sql) {
    global $host, $userName, $passWord, $dbName;
    $link = mysqli_connect($host, $userName, $passWord, $dbName);
    $result = mysqli_query($link, $sql);
    if($result) {
        $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
        return $data;
    } else {
        return false;
    }
}

function query_adm($sql) {

}