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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['name']) || trim($_POST['name']) === '') {
        $errors['name'] = 'Name is mandatory';
    } 

    if (!isset($_POST['type']) || trim($_POST['type']) === '') {
        $errors['type'] = 'Type is mandatory';
    }

    if (!isset($_POST['hp']) || trim($_POST['hp']) === '') {
        $errors['hp'] = 'HP is mandatory';
    } elseif (!is_numeric($_POST['hp']) || $_POST['hp'] < 0) {
        $errors['hp'] = 'HP is not valid';
    }

    if (!isset($_POST['attack']) || trim($_POST['attack']) === '') {
        $errors['attack'] = 'Attack is mandatory';
    } elseif (!is_numeric($_POST['attack']) || $_POST['attack'] < 0) {
        $errors['attack'] = 'Attack is not valid';
    }

    if (!isset($_POST['price']) || trim($_POST['price']) === '') {
        $errors['price'] = 'Price is mandatory';
    } elseif (!is_numeric($_POST['price']) || $_POST['price'] < 0) {
        $errors['price'] = 'Price is not valid';
    }

    if (!isset($_POST['defense']) || trim($_POST['defense']) === '') {
        $errors['defense'] = 'Defense is mandatory';
    } elseif (!is_numeric($_POST['defense']) || $_POST['defense'] < 0) {
        $errors['defense'] = 'Defense is not valid';
    }

    if (!isset($_POST['image']) || filter_var($_POST['image'], FILTER_VALIDATE_URL) === false) {
        $errors['image'] = 'Image is not valid';
    }

    if (!isset($_POST['description']) || trim($_POST['description']) === '') {
        $errors['description'] = 'Description cannot be empty.';
    } elseif (strlen($_POST['description']) < 5 || strlen($_POST['description']) > 1000) {
        $errors['description'] = 'Description must be between 5 and 1000 characters.';
    }

    if (empty($errors)) {
        // Process the form data here
        $name = $_POST['name'];
        $type = $_POST['type'];
        $hp = $_POST['hp'];
        $attack = $_POST['attack'];
        $price = $_POST['price'];
        $defense = $_POST['defense'];
        $image = $_POST['image'];
        $description = $_POST['description'];
        $id = uniqid();

        $dataFilePath = 'data.json';

        // Create pokemon data array
        $newPokemon = [
            'name' => $name,
            'type' => $type,
            'hp' => $hp,
            'attack' => $attack,
            'defense' => $defense,
            'price' => $price,
            'image' => $image,
            'description' => $description,
            'id' =>  $id,
        ];

        // Add the new user to users.json
        addCard($dataFilePath, $newPokemon, $id);

        // Redirect to success page
        header("Location: success.php");
        exit();
    }
}

// Function to add a user to users.json
function addCard($dataFile,$pokemonData,$id)
{
    // Load existing data from users.json
    $jsonData = file_get_contents($dataFile);
    $data = json_decode($jsonData, true);
    // Add the new user to the data array
    $data[$id] = $pokemonData;

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
                        <a href="register.php" class="navbar-item">
                            register
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
                    <h2 class="title has-text-centered">Register</h2>
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
                            <label class="label">Type:</label>
                            <div class="control">
                                <input class="input" type="text" name="type" placeholder="e.g. grass">
                            </div>
                            <p class="help is-danger">
                                <?= $errors['type'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field">
                            <label class="label">
                                <label class="label">hp:</label>
                                <div class="control">
                                    <input type="number" class="input" name="hp" placeholder="e.g. 23">
                                </div>
                                <p class="help is-danger">
                                    <?= $errors['hp'] ?? '' ?>
                                </p>
                        </div>
                        <div class="field">
                            <label class="label">attack:</label>
                            <div class="control">
                                <input class="input" type="number" name="attack" placeholder="e.g. 23">
                            </div>
                            <p class="help is-danger">
                                <?= $errors['attack'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field">
                            <label class="label">defense:</label>
                            <div class="control">
                                <input class="input" type="number" name="defense" placeholder="e.g. 23">
                            </div>
                            <p class="help is-danger">
                                <?= $errors['defense'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field">
                            <label class="label">price:</label>
                            <div class="control">
                                <input class="input" type="number" name="price" placeholder="e.g. 500">
                            </div>
                            <p class="help is-danger">
                                <?= $errors['price'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field">
                            <label class="label">image:</label>
                            <div class="control">
                                <input class="input" type="url" name="image" placeholder="e.g. https://example">
                            </div>
                            <p class="help is-danger">
                                <?= $errors['image'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field">
                            <label class="label">description:</label>
                            <textarea class="textarea is-primary" placeholder="Primary" name="description"
                                rows="3"></textarea>
                            <p class="help is-danger">
                                <?= $errors['description'] ?? '' ?>
                            </p>
                        </div>
                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-primary is-fullwidth" type="submit">Submit</button>
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