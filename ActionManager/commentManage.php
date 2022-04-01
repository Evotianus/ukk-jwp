<?php
session_start();
include "connectionManage.php";

// 'php://input' digunakan untuk mendapatkan data yang dikirimkan oleh file php
$data = json_decode(file_get_contents('php://input'), true);

$arrHashtag = $data['arrHashtag'];

// Mengambil id dari user yang login untuk dimasukkan kedalam user_id di database
$sqlUser = "SELECT id FROM users WHERE username = '{$_SESSION['username']}'";
$queryUser = mysqli_query($conn, $sqlUser);
$resultUser = mysqli_fetch_assoc($queryUser);

$sqlComment = "INSERT INTO comments (user_id, tweet_id, content)
                            VALUES ('{$resultUser['id']}', '{$data['post_id']}', '{$data['CONTENT']}')";
$queryComment = mysqli_query($conn, $sqlComment);

// Mencari kata yang mengandung # disetiap kata pada arrHashtag, kemudian di insert satu persatu
if (count($arrHashtag) != 0) {
    foreach ($arrHashtag as $hashtag) {
        $hashtag = str_replace('#', '', $hashtag);
        $sqlTags = "INSERT INTO tags (tag)
                                VALUES ('$hashtag')";
        $queryTags = mysqli_query($conn, $sqlTags);

        // Select id dari tags terbaru
        $sqlTagRelation = "SELECT id FROM tags ORDER BY id DESC LIMIT 1";
        $queryTagRelation = mysqli_query($conn, $sqlTagRelation);
        $resultTagRelation = mysqli_fetch_assoc($queryTagRelation);
        $idTag = $resultTagRelation['id'];

        // Select id dari tweet terbaru
        $sqlCommentsRelation = "SELECT id FROM comments ORDER BY id DESC LIMIT 1";
        $queryCommentsRelation = mysqli_query($conn, $sqlCommentsRelation);
        $resultCommentsRelation = mysqli_fetch_assoc($queryCommentsRelation);
        $idComments = $resultCommentsRelation['id'];

        // Insert ke tag_tweet dengan id yang terbaru
        $sqlTagComment = "INSERT INTO tag_comment (tag_id, comment_id)
                                        VALUES('$idTag', '$idComments')";
        $queryTagComment = mysqli_query($conn, $sqlTagComment);
    }
}


echo json_encode(['message' => 'Comment sent']);
