<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate name
    if (!isset($_POST['name']) || trim($_POST['name']) === '') {
        $errors[] = 'Name is mandatory';
    }

    $pokemonTypes = [
        "normal",
        "fire",
        "water",
        "electric",
        "grass",
        "ice",
        "fighting",
        "poison",
        "ground",
        "flying",
        "psychic",
        "bug",
        "rock",
        "ghost",
        "dragon",
        "dark",
        "steel",
        "fairy",
        "stellar"
    ];

    // Validate type
    if (!isset($_POST['type']) || trim($_POST['type']) === '') {
        $errors[] = 'Type is mandatory';
    } else {
        // Check if the submitted type is a valid Pokémon type
        $submittedType = strtolower($_POST['type']);
        if (!in_array($submittedType, $pokemonTypes)) {
            $errors[] = 'Invalid Pokemon type';
        }
    }

    // Validate numeric fields
    $numericFields = ['hp', 'attack', 'defence', 'price'];
    foreach ($numericFields as $field) {
        if (!isset($_POST[$field]) || !is_numeric($_POST[$field]) || $_POST[$field] < 0) {
            $errors[] = ucfirst($field) . ' should be a non-negative number';
        }
    }

    // Validate image URL
    if (!isset($_POST['image']) || filter_var($_POST['image'], FILTER_VALIDATE_URL) === false) {
        $errors[] = 'Image URL is not valid';
    }

    // Validate description
    if (!isset($_POST['description']) || trim($_POST['description']) === '') {
        $errors[] = 'Description is mandatory';
    }

    if (empty($errors)) {
        // Process the form data here
        $name = $_POST['name'];
        $type = $_POST['type'];
        $hp = $_POST['hp'];
        $attack = $_POST['attack'];
        $defence = $_POST['defence'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $description = $_POST['description'];

        // Perform further processing, database operations, etc.

        // Redirect to a success page or display a success message
        header("Location: success.php");
        exit();
    }

    // Function to add a card to data.json
function addCard($dataFile, $cardData)
{
    // Load existing data from data.json
    $jsonData = file_get_contents($dataFile);
    $data = json_decode($jsonData, true);

    // Generate a unique ID for the new card
    $cardId = uniqid();

    // Add the new card to the data array
    $data["card" . $cardId] = $cardData;

    // Encode the updated data array back to JSON
    $updatedJsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Save the updated data to data.json
    file_put_contents($dataFile, $updatedJsonData);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Define the path to your data.json file
    $dataFilePath = 'data.json';

    // Get form data
    $cardName = $_POST['name'];
    $cardType = $_POST['type'];
    $cardHp = $_POST['hp'];
    $cardAttack = $_POST['attack'];
    $cardDefense = $_POST['defense'];
    $cardPrice = $_POST['price'];
    $cardDescription = $_POST['description'];
    $cardImage = $_POST['image'];

    // Create card data array
    $newCard = [
        'name' => $cardName,
        'type' => $cardType,
        'hp' => $cardHp,
        'attack' => $cardAttack,
        'defense' => $cardDefense,
        'price' => $cardPrice,
        'description' => $cardDescription,
        'image' => $cardImage,
        'id' => uniqid(),
    ];

    // Add the new card to data.json
    addCard($dataFilePath, $newCard);
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
    /* Add some custom styles if needed */
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    .path {
        background-color: #5D9CEC;
        text-align: center;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    form {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .field {
        margin-bottom: 1em;
    }

    .textarea {
        resize: none;
    }

    #footer-page {
        background-color: #5D9CEC;
        padding: 20px;
        text-align: center;
        color: white;
        width: 100%;
        box-sizing: border-box;
    }
    </style>
</head>

<body>
    <div class="path" style="background-color: #5D9CEC;">
        <h1 class="title is-2 has-text-white">IKmon -> admin</h1>
    </div>
    <form method="post">
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" name="name" placeholder="e.g Pikachu">
            </div>
        </div>

        <div class="field">
            <label class="label">type</label>
            <div class="control">
                <input class="input" type="text" name="type" placeholder="e.g. type">
            </div>
        </div>

        <div class="field">
            <label class="label">hp</label>
            <div class="control">
                <input class="input" type="number" name="hp" placeholder="e.g. 60">
            </div>
        </div>
        <div class="field">
            <label class="label">attack</label>
            <div class="control">
                <input class="input" type="number" name="attack" placeholder="e.g. 50">
            </div>
        </div>
        <div class="field">
            <label class="label">defence</label>
            <div class="control">
                <input class="input" type="number" name="defense" placeholder="e.g. 30">
            </div>
        </div>
        <div class="field">
            <label class="label">price</label>
            <div class="control">
                <input class="input" type="number" name="price" placeholder="e.g. 500">
            </div>
        </div>
        <div class="field">
            <label class="label">image</label>
            <div class="control">
                <input class="input" name="image" type="url">
            </div>
        </div>
        <label class="label">description</label>

        <textarea class="textarea is-primary" name="description" placeholder="Primary textarea"></textarea>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link" type="submit">Submit</button>
            </div>
        </div>
    </form>
    <footer style="background-color: #5D9CEC;" id="footer-page">
        Ikemon | ELTE IK Webprogramming
    </footer>
</body>

</html>