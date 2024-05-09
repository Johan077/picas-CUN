<?php
session_start();

function generateSecretNumber() {
    return strval(rand(1000, 9999));
}

function calculatePicasAndFijas($guess, $secret) {
    $picas = 0;
    $fijas = 0;

    for ($i = 0; $i < 4; $i++) {
        if ($guess[$i] == $secret[$i]) {
            $fijas++;
        } elseif (strpos($secret, $guess[$i]) !== false) {
            $picas++;
        }
    }

    return array($picas, $fijas);
}

function checkGuess($guess) {
    if (!isset($_SESSION['secret'])) {
        $_SESSION['secret'] = generateSecretNumber();
    }

    list($picas, $fijas) = calculatePicasAndFijas($guess, $_SESSION['secret']);

    if ($fijas == 4) {
        unset($_SESSION['secret']);
        return "¡Has ganado!";
    } else {
        return "Picas: $picas, Fijas: $fijas";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guess = $_POST['numero'];
    $message = checkGuess($guess);
    echo $message;
}
?>
