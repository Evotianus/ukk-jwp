<?php
// include securityManage untuk memastikan bahwa hanya user yang sudah login yang dapat masuk ke page ini
include "ActionManager/securityManage.php";

// include connectionManage karena membutuhkan variable $conn
include "ActionManager/connectionManage.php";

// include function untuk menggunakan function dengan reusable
include "function.php";
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

<style>
    /* Mengubah cursor saat hover ke item menjadi panah */
    .show-detail {
        cursor: pointer;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PT. XYZ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                </ul>
                <form class="d-flex mx-5">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="filter" id="filter">
                    <button class="btn btn-outline-success" type="button" onclick="searchHashtag(this.value)">Search</button>
                </form>
                <button class="btn btn-danger" onclick="userLogout()">Logout</button>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <button class="btn btn-primary" onclick="userCreate()">Create Post</button>

        <div class="content">
            <div class="row mb-3" id="content-items">
                <?php
                // Digunakan untuk membuat card bootstrap berdasarkan jumlah dan data yang didapatkan dari database table tweets
                $sqlTweets = "SELECT * FROM tweets";
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
            </div>
        </div>
    </div>

    <script>
        const SEARCH_URL = "ActionManager/searchManage.php";
        // Untuk logout, diarahkan ke file logoutManage
        function userLogout() {
            location.href = "ActionManager/logoutManage.php";
        }

        function userCreate() {
            location.href = "create.php";
        }

        // Menampilkan detail post
        function postShow(post_id) {
            location.href = `show.php?post=${post_id}`;
        }

        function searchHashtag(filter) {
            $.ajax({
                type: "POST",
                url: SEARCH_URL,
                data: filter,
                dataType: "html",
                success: res => {
                    console.log(res);
                }
            })
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</body>

</html>