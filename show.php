<?php
include "ActionManager/connectionManage.php";
include "ActionManager/securityManage.php";
include "function.php";

// Mengambil id post untuk mencari key di database
$post = $_GET['post'];

$sqlDetail = "SELECT * FROM tweets WHERE id = '$post'";
$queryDetail = mysqli_query($conn, $sqlDetail);
$resultDetail = mysqli_fetch_assoc($queryDetail);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>

    <div class="container mt-5">
        <a href="home.php"><button class="btn btn-success">Back</button></a>
        <h1><?= $resultDetail['title'] ?></h1>
        <h5 class="mx-3 mb-5"><?= $resultDetail['content'] ?></h5>

        <?php
        // Cek apakah username dari database sama dengan session agar pemilik dari post dapat mengupdate atau mengdelete
        if (getUsername($resultDetail['user_id']) == $_SESSION['username']) {
        ?>
            <button class="btn btn-warning" onclick="postEdit('<?= $post ?>', '<?= $_SESSION['username'] ?>')">Edit</button>
            <button class="btn btn-danger" onclick="postDelete('<?= $post ?>', '<?= $_SESSION['username'] ?>')">Delete</button>
        <?php
        }
        ?>

        <div class="border border-secondary p-4 rounded my-4">
            <button class="btn btn-primary" onclick="toggleComment()">Add Comment</button>
            <div class="comment">
                <input type="text" class="form-control my-2" id="content" placeholder="Type your comment">
                <button class="btn btn-info btn-post" onclick="postComment(<?= $post ?>)">Post</button>
                <button class="btn btn-info btn-update" onclick="updateComment(<?= $post ?>)">Update</button>
            </div>

            <div class="comment-section">
                <?php
                // Join table agar mendapatkan nama user dan juga content dari comment
                $sqlComment = "SELECT *, comments.id AS id_comment FROM comments INNER JOIN users ON comments.user_id = users.id WHERE tweet_id = '$post'";
                $queryComment = mysqli_query($conn, $sqlComment);

                while ($resultComment = mysqli_fetch_assoc($queryComment)) {
                    $username = $resultComment['username'];
                    $content = $resultComment['content'];
                    $id_comment = $resultComment['id_comment'];
                ?>
                    <div class="p-2 my-2 border d-flex justify-content-between">
                        <div class="">
                            <h5><?= $username ?></h5>
                            <p><?= $content ?></p>
                        </div>
                        <?php if ($_SESSION['username'] == $username) {
                        ?>
                            <div class="action-comment">
                                <button class="btn btn-warning" onclick="commentEdit('<?= $id_comment ?>', '<?= $content ?>')">Edit</button>
                                <button class="btn btn-danger" onclick="commentDelete('<?= $id_comment ?>')">Delete</button>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <input type="hidden" id="comment-id">

    <script>
        const COMMENT = document.querySelector('.comment');
        const BTN_POST = document.querySelector('.btn-post');
        const BTN_UPDATE = document.querySelector('.btn-update');

        // Secara default disembunyikan
        COMMENT.style.display = 'none';
        BTN_UPDATE.style.display = 'none';

        function postEdit(post_id, user) {
            location.href = `edit.php?post=${post_id}&user=${user}`;
        }

        function postDelete(post_id, user) {
            location.href = `ActionManager/deleteManage.php?post=${post_id}&user=${user}`;
        }

        // Menampilkan/menyembunyikan section untuk comment
        function toggleComment() {
            if (COMMENT.style.display == 'none') {
                COMMENT.style.display = 'block';
            } else {
                COMMENT.style.display = 'none';
            }
        }

        // Upload comment ke database
        function postComment(post_id) {
            const CONTENT = document.querySelector('#content').value;

            let tempContent = CONTENT.split(' ');

            let arrHashtag = [];

            // Setiap kata yang memiliki hashtag dimasukkan kedalam variable array
            tempContent.forEach(value => {
                if (value.includes("#")) {
                    arrHashtag.push(value);
                }
            })

            let data = {
                CONTENT,
                post_id,
                arrHashtag
            }

            fetch(`ActionManager/commentManage.php`, {
                    method: "POST",
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    location.reload();
                })
        }

        // Tampilan diubabh kemudian input diberi value comment yang ingin di update
        function commentEdit(id, content) {
            BTN_POST.style.display = 'none';
            BTN_UPDATE.style.display = 'block';
            COMMENT.style.display = 'block';

            document.querySelector('#content').value = content;
            document.querySelector('#comment-id').value = id;
        }

        // Update comment dengan id yang di set kedalam input type hidden
        function updateComment() {
            let id = document.querySelector('#comment-id').value;
            const CONTENT = document.querySelector('#content').value;

            let data = {
                id,
                CONTENT
            }

            fetch(`ActionManager/updateCommentManage.php`, {
                    method: "POST",
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => location.reload());
        }

        // Data di delete dengan menggunakan id dari masing-masing comment
        function commentDelete(id) {
            let data = {
                id
            }

            fetch(`ActionManager/deleteCommentManage.php`, {
                    method: "POST",
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => location.reload());
        }
    </script>
</body>

</html>