<?php
session_start();
$error="";
$jsonData = file_get_contents("users.json");
$data = json_decode($jsonData, true);
$users = $data;
//print_r(array_key_exists("taiga", $users));
//print_r($users["taiga"]);


// Function to validate login credentials
function validateLogin($username, $password, $users) {
    if (array_key_exists($username, $users) && $password==$users[$username]["password"]) {
        // Successful login
        return $users[$username];
    } else {
        // Invalid login
        return false;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate CSRF token
    // if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    //     // CSRF token mismatch, handle accordingly
    //     exit("CSRF token mismatch");
    // }

    // Get user input
    $username = filter_var($_POST["username"], FILTER_UNSAFE_RAW);
    $password = $_POST["password"];
    print_r($username);
    print_r($password);
    print_r(array_key_exists($username, $users));
    print_r(password_verify($password, $users[$username]["password"]));

    // Validate login
    $user = validateLogin($username, $password, $users);

    if ($user) {
        $_SESSION["user"] = $user;
        // Successful login, redirect to main page
        header("Location: index.php");
        exit();
    } else {
        // Invalid login, display error message
        $error = "Invalid username or password. Please try again.";
    }
}

// Generate and store CSRF token
// $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <style>
    .hero-head {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar-brand,
    .navbar-item {
        color: #fff;
    }

    .navbar-item:hover {
        background-color: transparent;
        color: #fff;
    }

    .box {
        max-width: 400px;
        margin: auto;
        margin-top: 50px;
    }

    .help.is-danger {
        color: #ff3860;
    }

    .hero.is-info .title {
        color: black;
    }

    #footer-page {

        padding: 20px;
        text-align: center;
        color: white;
        width: 100%;
        box-sizing: border-box;
        position: fixed;
        bottom: 0;
    }
    </style>
</head>

<body>
    <section class="hero is-info is-fullheight">
        <div class="hero-head">
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-brand">
                        <a class="navbar-item" href="/">
                            <h2>Ikemon - main</h2>
                        </a>
                        <a href="resister.php" class="navbar-item">
                            resister
                        </a>
                        <a href="login.php" class="navbar-item">
                            login
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div class="hero-body">
            <div class="container">
                <div class="box">
                    <h1 class="title has-text-centered">Login</h1>
                    <?php if (isset($error)) : ?>
                    <p class="has-text-danger has-text-centered"><?= $error; ?></p>
                    <?php endif; ?>
                    <form method="post" action="" class="box">
                        <div class="field">
                            <label for="username" class="label">Username:</label>
                            <div class="control">
                                <input type="text" id="username" name="username" class="input" required>
                            </div>
                        </div>

                        <div class="field">
                            <label for="password" class="label">Password:</label>
                            <div class="control">
                                <input type="password" id="password" name="password" class="input" required>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-primary is-fullwidth"
                                    value="Log In!">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer id="footer-page">
            Ikemon | ELTE IK Webprogramming
        </footer>
    </section>
</body>

</html>