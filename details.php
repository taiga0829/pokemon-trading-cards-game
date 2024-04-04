<?php
include 'functions.php';

// Read JSON data from the file
$jsonData = file_get_contents("data.json");

// Check if the JSON data is successfully retrieved
if ($jsonData === false) {
    die('Error reading data.json');
}

// Decode the JSON data
$data = json_decode($jsonData, true);

// Check if JSON decoding was successful
if ($data === null) {
    die('Error decoding JSON data');
}

// Get the card name from the URL parameter
$id = isset($_GET['card']) ? $_GET['card'] : '';

print_r($id);

$cardDetails = null;  // Initialize $cardDetails

// Find card in $data having given $id
foreach ($data as $card) {
    if ($card["id"] === $id) {
        $cardDetails = $card;  // Assign $card to $cardDetails if ID is found
        break;  // Break the loop once the card is found
    }
}


// Display card details
if ($cardDetails) {
    // Sample usage
    $adminUser = 'admin';
    $adminPassword = 'adminpass';

    // Log in as the admin user
    login($adminUser, $adminPassword);

    // Sample user data
    $users = [
        $adminUser => [
            "password" => $adminPassword,
            "cards" => ["card0"],
        ],
    ];

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
            default:
                return "";
        }
    }


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
    #footer-page {
        padding: 20px;
        /* Adjust the padding as needed to increase height */
        text-align: center;
        color: white;
    }
    </style>
</head>

<body>
    <h1 class="title is-3 has-text-white" style="background-color: #5D9CEC;">IKmon -> <?=$id?> </h1>
    <div class="card">
        <div class="card-image">
            <p class="title is-1">
                <?= $cardDetails["name"] ?>
            </p>
            <img src="<?= $cardDetails["image"] ?>" style="<?= imageBackgroundColor($cardDetails['type']) ?>"
                alt="pokemon image" class="is-small">
        </div>
        <div class="card-content">
            <div class="media">
                <div class="property-dedescription">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>type</th>
                                <th>hp</th>
                                <th>attack</th>
                                <th>defense</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th>
                                    <?= $cardDetails["type"] ?>
                                </th>
                                <td>
                                    <?= $cardDetails["hp"] ?>
                                </td>
                                <td>
                                    <?= $cardDetails["attack"] ?>
                                </td>
                                <td>
                                    <?= $cardDetails["defense"] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="content">
                <?= $cardDetails["description"] ?>
                <br>
            </div>
        </div>
    </div>
    <footer style="background-color: #5D9CEC;" id="footer-page">
        Ikemon | ELTE IK Webprogramming
    </footer>
</body>

</html>