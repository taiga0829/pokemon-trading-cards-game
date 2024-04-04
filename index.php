<?php
include 'functions.php';
session_start();

if(isset($_GET["target-type"]) && !empty($_GET["target-type"])){
    $target_type = $_GET["target-type"];
}

// Read JSON data from the file
$jsonData = file_get_contents("data.json");

// Check if the JSON data is successfully retrieved
if ($jsonData === false) {
    die('Error reading data.json');
}

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



// Trade a card from the admin to a user
// tradeCard($adminUser, 'user1', 'card0');

// // Display user's cards
// displayUserCards('user1');

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
        case "fairy":
            return "background-color: #EE99AC;";
        case "ice":
            return "background-color: #98D8D8;";
        case "fighting":
            return "background-color: #C03028;";
        case "ground":
            return "background-color: #E0C068;";
        case "flying":
            return "background-color: #A890F0;";
        case "psychic":
            return "background-color: #F85888;";
        case "rock":
            return "background-color: #B8A038;";
        case "ghost":
            return "background-color: #705898;";
        case "dragon":
            return "background-color: #7038F8;";
        case "dark":
            return "background-color: #705848;";
        case "steel":
            return "background-color: #B8B8D0;";
        default:
            return "";
    }
}

function buyCard(){
    
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
                        <?php if (isset($_SESSION["user"]) && !empty($_SESSION["user"]) && $_SESSION["user"]["name"]!="admin"): ?>
                        <!-- Logout button for authenticated users -->
                        <a href="logout.php" class="navbar-item">
                            logout
                        </a>
                        <a href="user_detail.php" class="navbar-item">
                            <?=$_SESSION["user"]["name"]?>
                        </a>
                        <p class="navbar-item">
                            <?=$_SESSION["user"]["money"]?>💰
                        </p>
                        <?php endif; ?>
                        <?php if (isset($_SESSION["user"]) && !empty($_SESSION["user"]) && $_SESSION["user"]["name"]=="admin"): ?>
                        <a href="logout.php" class="navbar-item">
                            logout
                        </a>
                        <a href="user_detail.php" class="navbar-item">
                            <?=$_SESSION["user"]["name"]?>
                        </a>
                        <a href="create.php" class="navbar-item is-primary">
                            create
                        </a>
                        <?php endif; ?>
                        <div class="navbar-end">
                            <form class="is-marginless" action="/pages/search/" method="get">
                                <div class="navbar-item">
                                    <input class="input is-small is-rounded" type="text" name="target-type"
                                        placeholder="By type..." aria-label="Search">
                                    &nbsp;
                                    <button class="button is-light is-small" type="submit">Search</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </nav>
        </div>
        <section class="section">
            <div class="container">
                <div class="columns is-multiline is-desktop">
                    <?php if (isset($_GET["target-type"]) && !empty($_GET["target-type"])): ?>
                    <?php foreach ($data as $pokemon): ?>
                    <?php if ($target_type === $pokemon["type"]): ?>
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
                                        🔖
                                        <?= $pokemon['type'] ?>
                                    </div>
                                </div>
                                <footer class="card-footer">
                                    <p href="#" class="card-footer-item">
                                        💖
                                        <?= $pokemon['hp'] ?>
                                    </p>
                                    <p href="#" class="card-footer-item">⚔️
                                        <?= $pokemon['attack'] ?>
                                    </p>
                                    <p href="#" class="card-footer-item">🛡️
                                        <?= $pokemon['defense'] ?>
                                    </p>
                                </footer>
                                <footer class="card-footer">
                                    <p href="#" class="card-footer-item">💰
                                        <?= $pokemon['price'] ?>
                                    </p>
                                    <a href="#" class="card-footer-item">Buy</a>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <?php foreach ($data as $pokemon): ?>
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
                                        🔖
                                        <?= $pokemon['type'] ?>
                                    </div>
                                </div>
                                <footer class="card-footer">
                                    <p href="#" class="card-footer-item">
                                        💖
                                        <?= $pokemon['hp'] ?>
                                    </p>
                                    <p href="#" class="card-footer-item">⚔️
                                        <?= $pokemon['attack'] ?>
                                    </p>
                                    <p href="#" class="card-footer-item">🛡️
                                        <?= $pokemon['defense'] ?>
                                    </p>
                                </footer>
                                <footer class="card-footer">
                                    <p href="#" class="card-footer-item">💰
                                        <?= $pokemon['price'] ?>
                                    </p>
                                    <?php if (isset($_SESSION["user"]) && !empty($_SESSION["user"])&&$_SESSION["user"]!=="admin"): ?>
                                    <form method="post">
                                        <!-- Include the Pokemon's ID in the form attributes -->
                                        <input type="hidden" name="pokemon_id" value="<?= $pokemon['id'] ?>">
                                        <input type="submit" name="buy" class="button" value="Buy" />
                                    </form>
                                    <?php endif;?>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <footer id="footer-page">
            Ikemon | ELTE IK Webprogramming
        </footer>
</body>

</html>