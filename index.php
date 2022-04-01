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
            <form>
                <h3>Login</h3>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <button type="button" class="btn btn-primary" onclick="userLogin()">Login</button>
                <a href="register.php"><button type="button" class="btn btn-warning">Register</button></a>
            </form>
        </div>
    </div>

    <script>
        function userLogin() {
            const USERNAME = document.querySelector('#username').value;
            const PASSWORD = document.querySelector('#password').value;

            // Data dijadikan object
            let data = {
                USERNAME,
                PASSWORD
            }

            // Menggunakan fetch untuk mengirim data ke sebuah file
            fetch(`ActionManager/loginManage.php`, {
                    method: "POST",
                    body: JSON.stringify(data)
                })
                // then untuk menangkap response dari fetch
                .then(res => res.json())
                .then(res => {
                    if (res.message == "Success") {
                        location.href = "home.php";
                    } else {
                        alert("Invalid Login");
                    }
                });
        }
    </script>
</body>

</html>