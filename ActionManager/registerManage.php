<?php
include "connectionManage.php";

// 'php://input' digunakan untuk mendapatkan data yang dikirimkan oleh file php
$data = json_decode(file_get_contents('php://input'), true);

$sqlUsername = "SELECT * FROM users WHERE username = '{$data['USERNAME']}'";
$queryUsername = mysqli_query($conn, $sqlUsername);

// Password diubah menjadi md5 terlebih dahulu kemudian di validasi dan di insert ke dalam database
$password = md5($data['PASSWORD']);

if (mysqli_num_rows($queryUsername) == 0) {
    $sqlUser = "INSERT INTO users (username, password)
                            VALUES('{$data['USERNAME']}', '$password')";
    $queryUser = mysqli_query($conn, $sqlUser);

    echo json_encode(['message' => 'Success']);
} else {
    echo json_encode(['message' => 'Username Owned']);
}
