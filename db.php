<?php
// PHP hỗ trợ các loại thư viện làm việc với SQL: mysql, mysqli, pdo 
// thực hành với PDO 
$objConn = null;
$db_host = '127.0.0.1'; // máy windows xampp mặc định là: localhost
$db_name = 'thuc_hanh';  // tên CSDL đã tạo ở phpMyAdmin
$db_user = 'root'; // máy windows xampp mặc định là root
$db_pass = ''; // // máy windows xampp mặc định là rỗng không viết gì.

try {

    $objConn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $objConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Ket noi CSDL thanh cong';
} catch (Exception $e) {

    die('Loi ket noi CSDL: ' . $e->getMessage());
}