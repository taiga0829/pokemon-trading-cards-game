<?php
include 'functions.php';
session_start();

// Read JSON data from the file
$jsonData = file_get_contents("data.json");

// Check if the JSON data is successfully retrieved
if ($jsonData === false) {
    die('Error reading data.json');
}

$filteredCards = [];
if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
    // Decode the JSON data
    $pokemonData = json_decode($jsonData, true);

    // Keys to filter
    $selectedKeys = $_SESSION["user"]["cards"];

    // Filter the cards based on keys
    $filteredCards = array_filter($pokemonData, function ($key) use ($selectedKeys) {
        return in_array($key, $selectedKeys);
    }, ARRAY_FILTER_USE_KEY);
}

// Decode the JSON data
$data = json_decode($jsonData, true);

// Check if JSON decoding was successful
if ($data === null) {
    die('Error decoding JSON data');
}

function imageBackgroundColor($type)
{
    switch ($type) {
        case "electric":
            return "background-color: #F7D02C;";
        case "fire":
            return "background-color: #EE8130;";
        case "grass":
            return "background-color: #7AC74C;";
        case "bug":
            return "background-color: #A8B820;";
        case "normal":
            return "background-color: #A8A878;";
        case "poison":
            return "background-color: #A33EA1;";
        case "water":
            return "background-color: #6890F0;";
        default:
            return ""; // default color or empty string for unknown types
    }
}

function sellCard($user, $pokemon)
{
    $jsonData = file_get_contents("users.json");
    $userData = json_decode($jsonData, true);

    $targetUserId = $user["name"]; // Assuming the user has a "name" property as an identifier
    $target_id = $pokemon["id"];

    // Find the target user in the $userData array
    if (isset($userData[$targetUserId])) {
        // Get the target user's cards
        $targetUserCards = $userData[$targetUserId]["cards"];

        // Filter the cards based on the target ID
        $filteredCards = array_filter($targetUserCards, function ($card) use ($target_id) {
            return $card !== $target_id;
        });

        // Update the target user's cards with the filtered result
        $userData[$targetUserId]["cards"] = array_values($filteredCards);
    }

    // Save the modified data back to the JSON file
    $jsonData = json_encode($userData, JSON_PRETTY_PRINT);
    file_put_contents("users.json", $jsonData);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your PHP Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <style>
    /* Add some custom styles if needed */
    .card {
        margin-bottom: 20px;
        border-radius: 10px;
        /* Adjust the border-radius as needed */
        overflow: hidden;
        /* Ensure the border-radius applies to the image */
    }

    #footer-page {
        padding: 20px;
        /* Adjust the padding as needed to increase height */
        text-align: center;
        color: white;
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
                        <?php if (isset($_SESSION["user"]) && !empty($_SESSION["user"])): ?>
                        <!-- Logout button for authenticated users -->
                        <a href="logout.php" class="navbar-item">
                            logout
                        </a>
                        <a href="user_detail.php" class="navbar-item">
                            <?= $_SESSION["user"]["name"] ?>
                        </a>
                        <p class="navbar-item">
                            <?= $_SESSION["user"]["money"] ?>💰
                        </p>
                        <p class="navbar-item">
                            <?= $_SESSION["user"]["email"] ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <section class="section">
            <div class="container">
                <div class="columns is-multiline is-desktop">
                    <?php foreach ($filteredCards as $pokemon): ?>
                    <div class="column is-one-fifth">
                        <div class="card">
                            <div class="card-image" style="<?= imageBackgroundColor($pokemon['type']) ?>">
                                <figure class="image is-4by3">
                                    <img src="<?= $pokemon['image'] ?>" alt="pokemon image">
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-content">
                                        <!-- Wrap the card name in an anchor tag with a link to the details page -->
                                        <a href="details.php?card=<?= $pokemon['id'] ?>" class="title is-4">
                                            <?= $pokemon['name'] ?>
                                        </a>
                                    </div>
                                    <div>
                                        🔖 <?= $pokemon['type'] ?>
                                    </div>
                                </div>
                                <footer class="card-footer">
                                    <p href="#" class="card-footer-item">
                                        💖 <?= $pokemon['hp'] ?>
                                    </p>
                                    <p href="#" class="card-footer-item">⚔️ <?= $pokemon['attack'] ?></p>
                                    <p href="#" class="card-footer-item">🛡️ <?= $pokemon['defense'] ?></p>
                                </footer>
                                <footer class="card-footer">
                                    <p href="#" class="card-footer-item">💰 <?= $pokemon['price'] ?></p>
                                    <form method="post">
                                        <!-- Include the Pokemon's ID in the form attributes -->
                                        <input type="hidden" name="pokemon_id" value="<?= $pokemon['id'] ?>">
                                        <input type="submit" name="sell" class="button" value="Sell" />
                                    </form>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <footer id="footer-page">
            Ikemon | ELTE IK Webprogramming
        </footer>
</body>

</html>