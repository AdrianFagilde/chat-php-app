<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="d-flex
            justify-content-center
            align-items-center
            vh-100">
    <div class="w-400 p-5 shadow rounded">
        <form method="post" action="app/http/signup.php" enctype="multipart/form-data">
            <div class="d-flex
                        justify-content-center
                        align-items-center
                        flex-column">
                <img src="img/logo.png" class="w-25">
                <h3 class="display-4 fs-1 text-center">Sign Up</h3>
            </div>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php }

            if (isset($_GET['name'])) {
                $name = $_GET['name'];
            } else $name = '';

            if (isset($_GET['username'])) {
                $username = $_GET['username'];
            } else $username = '';
            ?>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" value="<?= $name ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" value="<?= $username ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="birthDate" class="form-label">Birth Date</label>
                <input type="date" name="birthDate" class="form-control">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="<?= $gender = 'm' ?>">Male</option>
                    <option value="<?= $gender = 'f' ?>">Female</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" name="pp">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary"> Sign Up</button>
            <a href="index.php">Login</a>
        </form>
    </div>
</body>

</html>