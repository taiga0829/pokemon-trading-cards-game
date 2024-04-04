<?php

session_start();
$error = "";
if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
}

$errors = [];
$jsonData = file_get_contents("users.json");
$data = json_decode($jsonData, true);
$users = array_keys($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['name']) || trim($_POST['name']) === '') {
        $errors['name'] = 'Name is mandatory';
    } elseif (in_array($_POST['name'], $users)) {
        $errors['name'] = 'User has already been registered';
    }

    if (!isset($_POST['password']) || trim($_POST['password']) === '') {
        $errors['password'] = 'Password is mandatory';
    }
    if (!isset($_POST['confirmation-password']) || trim($_POST['confirmation-password']) === '') {
        $errors['confirmation-password'] = 'Confirmation password is mandatory';
    }

    // Validate email
    if (!isset($_POST['email']) || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Email is not valid';
    } elseif ($_POST['password'] != $_POST['confirmation-password']) {
        $errors['email'] = 'Confirmation of password is failed';
    }

    if (empty($errors)) {
        // Process the form data here
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        // Define the path to your users.json file
        $dataFilePath = 'users.json';

        // Create user data array
        $newUser = [
            'name' => $name,
            'money' => 500,
            'email' => $email,
            'password' => $password,
            'cards' => [],  // Initialize with an empty array for cards
        ];

        // Add the new user to users.json
        addUser($dataFilePath, $newUser);

        // Redirect to success page
        header("Location: success.php");
        exit();
    }
}

// Function to add a user to users.json
function addUser($dataFile, $userData)
{
    // Load existing data from users.json
    $jsonData = file_get_contents($dataFile);
    $data = json_decode($jsonData, true);

    // Generate a unique ID for the new user
    $userId = $userData["name"];

    // Add the new user to the data array
    $data[$userId] = $userData;

    // Encode the updated data array back to JSON
    $updatedJsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Save the updated data to users.json
    file_put_contents($dataFile, $updatedJsonData);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <title>Registration Form</title>
    <style>
    /* Add some custom styles if needed */
    .path {
        background-color: #5D9CEC;
        text-align: center;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    .box {
        max-width: 400px;
        margin: auto;
        margin-top: 30px;
    }

    .field {
        margin-bottom: 1em;
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

    .navbar-item:hover {
        background-color: transparent;
        color: #fff;
    }

    .hero.is-info .title {
        color: black;
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
            <div class="container is-flex is-flex-direction-column is-justify-content-center">
                <div class="box">
                    <h2 class="title has-text-centered">Resister</h2>
                    <form method="post" class="box">
                        <div class="field">
                            <label class="label">Name:</label>
                            <div class="control has-icons-right">
                                <input class="input" type="text" name="name" placeholder="e.g Pikachu">
                            </div>
                            <p class="help is-danger">
                                <?= $errors['name'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field">
                            <label class="label">Email:</label>
                            <div class="control">
                                <input class="input" type="email" name="email" placeholder="e.g. example@gmail.com">
                            </div>
                            <p class="help is-danger">
                                <?= $errors['email'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field">
                            <label class="label">Password:</label>
                            <div class="control">
                                <input type="password" class="input " name="password" placeholder="Enter password">
                            </div>
                            <p class="help is-danger">
                                <?= $errors['password'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field">
                            <label class="label">Confirmation Password:</label>
                            <div class="control">
                                <input class="input" type="password" name="confirmation-password"
                                    placeholder="Confirm password">
                            </div>
                            <p class="help is-danger">
                                <?= $errors['confirmation-password'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button  is-primary is-fullwidth" type="submit">Submit</button>
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