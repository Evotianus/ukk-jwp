<?php

function getUsername($id)
{
    include "ActionManager/connectionManage.php";

    $sqlUsername = "SELECT username FROM users WHERE id = '$id'";
    $resultUsername = mysqli_fetch_assoc(mysqli_query($conn, $sqlUsername));

    return $resultUsername['username'];
}
