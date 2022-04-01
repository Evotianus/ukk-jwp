<?php
include "connectionManage.php";

$filter = $_POST['filter'];

$sqlTweets = "SELECT * FROM tweets WHERE content LIKE '$filter'";
$queryTweets = mysqli_query($conn, $sqlTweets);

while ($resultTweets = mysqli_fetch_assoc($queryTweets)) {
    $post_id = $resultTweets['id'];
    $title = $resultTweets['title'];
    $content = $resultTweets['content'];

    $user_id = $resultTweets['user_id'];
?>
    <div class="card mb-3 show-detail my-3" onclick="postShow(<?= $post_id ?>)">
        <div class="card-body">
            <h5 class="card-title"><?= $title ?></h5>
            <p class="card-text"><?= $content ?></p>
            <p class="card-text"><small class="text-muted">By: <?= getUsername($user_id) ?></small></p>
        </div>
    </div>
<?php
}
?>