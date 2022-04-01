<?php
session_start();
include "connectionManage.php";

// Memastikan bahwa user yang menghapus adalah user yang login
if ($_SESSION['username'] != $_GET['user']) {
    header("Location: ../home.php");
} else {
    $sqlDelete = "DELETE FROM tweets WHERE id = '{$_GET['post']}'";
    $queryDelete = mysqli_query($conn, $sqlDelete);

    $sqlDeleteComment = "DELETE FROM comments WHERE tweet_id = '{$_GET['post']}'";
    $queryDeleteComment = mysqli_query($conn, $sqlDeleteComment);

    header("Location: ../home.php");
}
