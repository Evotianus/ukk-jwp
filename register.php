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
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="p-3 border border-primary rounded" style="width: 40%">
            <form action="ActionManager/registerManage.php" method="POST">
                <h3>Register</h3>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <button type="button" class="btn btn-primary" onclick="registerUser()">Register</button>
                <a href="index.php"><button type="button" class="btn btn-warning">Login</button></a>
            </form>
        </div>
    </div>

    <script>
        function registerUser() {
            const USERNAME = document.querySelector('#username').value;
            const PASSWORD = document.querySelector('#password').value;

            // Data dijadikan object
            let data = {
                USERNAME,
                PASSWORD
            }

            fetch(`ActionManager/registerManage.php`, {
                    method: "POST",
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.message == "Success") {
                        alert('User Created');
                        location.href = "home.php";
                    } else {
                        alert("Username Owned");
                    }
                });
        }
    </script>
</body>

</html>