<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
</head>

<body class="d-flex
            justify-content-center
            align-items-center
            vh-100">
    <div class="w-400 p-5 shadow rounded">
        <form method="post" action="app/http/auth.php">
            <div class="d-flex
                        justify-content-center
                        align-items-center
                        flex-column">
                <img src="img/logo.png" class="w-25">
                <h3 class="display-4 fs-1 text-center">LOGIN</h3>
            </div>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">LOGIN</button>
            <a href="signup.php">Sign Up</a>
        </form>
    </div>
</body>

</html>