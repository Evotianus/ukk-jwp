<?php
session_start();
include "connectionManage.php";

$loggedUsername = $_SESSION['username'];

// Mengambil id dari user yang sedang login
$sqlUserId = "SELECT id FROM users WHERE username = '$loggedUsername'";
$queryUserId = mysqli_query($conn, $sqlUserId);
$resUserId = mysqli_fetch_assoc($queryUserId);

// File diambil dan dijadikan variable php
$data = json_decode(file_get_contents('php://input'), true);

$arrHashtag = $data['arrHashtag'];

$sqlPost = "INSERT INTO tweets (user_id, title, content, picture, file)
                        VALUES ('{$resUserId['id']}', '{$data['TITLE']}', '{$data['CONTENT']}', '', '')";
$queryPost = mysqli_query($conn, $sqlPost);

if (count($arrHashtag) != 0) {
    foreach ($arrHashtag as $hashtag) {
        // Setiap kata # diubah menjadi string kosong kemudian di insert ke dalam table
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
        $sqlTweetRelation = "SELECT id FROM tweets ORDER BY id DESC LIMIT 1";
        $queryTweetRelation = mysqli_query($conn, $sqlTweetRelation);
        $resultTweetRelation = mysqli_fetch_assoc($queryTweetRelation);
        $idTweet = $resultTweetRelation['id'];

        // Insert ke tag_tweet dengan id yang terbaru
        $sqlTagTweet = "INSERT INTO tag_tweet (tag_id, tweet_id)
                                        VALUES('$idTag', '$idTweet')";
        $queryTagTweet = mysqli_query($conn, $sqlTagTweet);
    }
}

echo json_encode(['message' => 'Post Created!']);
