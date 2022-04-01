<?php
include "ActionManager/securityManage.php";
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PT. XYZ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                </ul>
                <button class="btn btn-danger" onclick="userLogout()">Logout</button>
            </div>
        </div>
    </nav>
    <div class="container mt-4" style="width: 60%;">
        <a href="home.php"><button class="btn btn-success">Back</button></a>
        <h2>Create Post</h2>
        <form onsubmit="">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" id="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" id="content" cols="30" rows="10" class="form-control" maxlength="250" required></textarea>
            </div>
            <button type="button" class="btn btn-primary" onclick="postCreate()">Post</button>
        </form>
    </div>

    <script>
        function postCreate() {
            const TITLE = document.querySelector('#title').value;
            const CONTENT = document.querySelector('#content').value;

            // Tiap kata dipecah menjadi array menggunakan method split
            let tempContent = CONTENT.split(' ');

            let arrHashtag = [];

            // Setiap value dalam array yang mengandung # dimasukkan kedalam variable array
            tempContent.forEach(value => {
                // console.log(value);
                if (value.includes("#")) {
                    console.log(value);
                    arrHashtag.push(value);
                }
            })

            let data = {
                TITLE,
                CONTENT,
                arrHashtag
            }
            
            fetch(`ActionManager/createManage.php`, {
                    method: "POST",
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    location.href = "home.php";
                })
        }
    </script>
</body>

</html>