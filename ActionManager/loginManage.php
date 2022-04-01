<?php
// Session diperlukan untuk meng set variable didalam session
session_start();
// Mendapatkan variable $conn
include "connectionManage.php";

// 'php://input' digunakan untuk mendapatkan data yang dikirimkan oleh file php
$data = json_decode(file_get_contents('php://input'), true);

$sqlUsername = "SELECT * FROM users WHERE username = '{$data['USERNAME']}'";
$queryUsername = mysqli_query($conn, $sqlUsername);

if (mysqli_num_rows($queryUsername) != 0) {
    $queryPassword = mysqli_query($conn, $sqlUsername);
    $resPassword = mysqli_fetch_assoc($queryPassword);

    // Data yang diinput oleh user diubah menjadi md5 kemudian di samakan dengan data user di database
    if ($resPassword['password'] == md5($data['PASSWORD'])) {
        $_SESSION['auth'] = true;
        $_SESSION['username'] = $resPassword['username'];

        echo json_encode(['message' => 'Success']);
    } else {
        echo json_encode(['message' => 'Invalid']);
    }
} else {
    echo json_encode(['message' => 'Invalid']);
}
