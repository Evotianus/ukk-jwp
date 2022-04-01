<?php
session_start();
include "connectionManage.php";

// 'php://input' digunakan untuk mendapatkan data yang dikirimkan oleh file php
$data = json_decode(file_get_contents('php://input'), true);

$sqlDeleteComment = "DELETE FROM comments WHERE id = '{$data['id']}'";
$queryDeleteComment = mysqli_query($conn, $sqlDeleteComment);

echo json_encode(['message' => 'Comment deleted']);
