<?php
include "connectionManage.php";

$data = json_decode(file_get_contents('php://input'), true);

// Update data tweet yang di kirimkan melalui edit berdasarkan id
$sqlUpdate = "UPDATE tweets SET title = '{$data['TITLE']}', content = '{$data['CONTENT']}', picture = '', file = '' WHERE id = '{$data['id']}'";
$queryUpdate = mysqli_query($conn, $sqlUpdate);

echo json_encode(['message' => 'Post Updated']);
