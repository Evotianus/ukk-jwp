<?php
session_start();
include "connectionManage.php";

// 'php://input' digunakan untuk mendapatkan data yang dikirimkan oleh file php
$data = json_decode(file_get_contents('php://input'), true);

// Update content dari comment berdasarkan id yang dikirimkan
$sqlUpdateComment = "UPDATE comments SET content = '{$data['CONTENT']}' WHERE id = '{$data['id']}'";
$queryUpdateComment = mysqli_query($conn, $sqlUpdateComment);

echo json_encode(['message' => 'Comment updated']);
