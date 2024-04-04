<?php

function login($username, $password) {
    // Simulate login logic, in a real application, you'd use a secure authentication system
    // For simplicity, we'll just check if the admin user is logging in
    if ($username === 'admin' && $password === 'adminpass') {
        echo "Logged in as $username (Admin).\n";
        return true;
    } else {
        echo "Invalid credentials.\n";
        return false;
    }
}

function tradeCard($fromUser, $toUser, $card) {
    global $users, $cards;

    // Check if users and cards exist
    if (!isset($users[$fromUser]) || !isset($users[$toUser]) || !isset($cards[$card])) {
        echo "Invalid user or card.\n";
        return;
    }

    // Check if the card belongs to the source user
    if (!in_array($card, $users[$fromUser]['cards'])) {
        echo "The card doesn't belong to $fromUser.\n";
        return;
    }

    // Remove the card from the source user
    $index = array_search($card, $users[$fromUser]['cards']);
    unset($users[$fromUser]['cards'][$index]);

    // Add the card to the destination user
    $users[$toUser]['cards'][] = $card;

    echo "Traded $card from $fromUser to $toUser.\n";
}

function displayUserCards($username) {
    global $users, $cards;

    if (!isset($users[$username])) {
        echo "Invalid user.\n";
        return;
    }

    $userCards = $users[$username]['cards'];

    echo "$username's cards:\n";
    foreach ($userCards as $card) {
        echo "- {$cards[$card]['name']} ({$cards[$card]['type']})\n";
    }
}
?>