<?php
// Gettings old values from url or setting default values -> to keep the same values when the form is submitted
if (isset($_GET['longueur'])) {
    $old_length = $_GET['longueur'];
} else {
    $old_length = 16; // Default length
}
if (isset($_GET['minuscule'])) {
    $old_min = $_GET['nbr-min'];
    $old_min_checked = 'checked';
} else {
    $old_min = 4; // Default number of lowercase characters
    $old_min_checked = '';
}
if (isset($_GET['majuscule'])) {
    $old_maj = $_GET['nbr-maj'];
    $old_maj_checked = 'checked';
} else {
    $old_maj = 4; // Default number of uppercase characters
    $old_maj_checked = '';
}
if (isset($_GET['chiffre'])) {
    $old_chiffre = $_GET['nbr-chiffre'];
    $old_chiffre_checked = 'checked';
} else {
    $old_chiffre = 4; // Default number of numbers
    $old_chiffre_checked = '';
}
if (isset($_GET['special'])) {
    $old_special = $_GET['nbr-special'];
    $old_special_checked = 'checked';
} else {
    $old_special = 4; // Default number of special characters
    $old_special_checked = '';
}

// Generating password according to the settings
if (!isset($_GET['majuscule']) && !isset($_GET['minuscule']) && !isset($_GET['chiffre']) && !isset($_GET['special'])) {
    $password = "Select at least one character type";
} else {
    $alphabet = '';
    $password = '';

    if (isset($_GET['majuscule'])) {
        $alphabet .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $_GET['nbr-maj']; $i++) {
            $password .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'[rand(0, 25)];
        }
    }
    if (isset($_GET['minuscule'])) {
        $alphabet .= 'abcdefghijklmnopqrstuvwxyz';
        for ($i = 0; $i < $_GET['nbr-min']; $i++) {
            $password .= 'abcdefghijklmnopqrstuvwxyz'[rand(0, 25)];
        }    
    }
    if (isset($_GET['chiffre'])) {
        $alphabet .= '0123456789';
        for ($i = 0; $i < $_GET['nbr-chiffre']; $i++) {
            $password .= '0123456789'[rand(0, 9)];
        }
    }
    if (isset($_GET['special'])) {
        $alphabet .= '!@#$%^&*()_-+=;:,./?';
        for ($i = 0; $i < $_GET['nbr-special']; $i++) {
            $password .= '!@#$%^&*()_-+=;:,./?'[rand(0, 19)];
        }
    }

    $password = str_shuffle($password);
    while (strlen($password) < $_GET['longueur']) {
        $password .= $alphabet[rand(0, strlen($alphabet) - 1)];
    }
}
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="author" content="Ioka">
    <meta name="robots" content="none">
    <meta name="description" content="A configurable password generator made by Ioka using php.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@500&display=swap" rel="stylesheet">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔐</text></svg>"/>
	<title>Password Generator by Ioka</title>
</head>
<body>
	<h1>&#128272 Password Generator</h1>
        <p><input type="text" value="<?php echo $password; ?>" readonly>
    <form method="get" action="index.php">
        <fieldset>
            <legend>Generation settings :</legend>
            <p><label for="longueur">
                Length :<br>
                <input type="range" name="longueur" id="longueur" step="1" min="6" max="64", value="<?=$old_length?>" oninput="this.nextElementSibling.value = this.value">
                <output><?=$old_length?></output>
            </label>
            <p><label for="minuscule">
                <input type="checkbox" name="minuscule" id="minuscule" <?=$old_min_checked?>>
                Lowercase
                <input type="number" name="nbr-min" step="1" min="1" max="64" value="<?=$old_min?>">
            </label>
            <p><label for="majuscule">
                <input type="checkbox" name="majuscule" id="majuscule" <?=$old_maj_checked?>>
                Uppercase
                <input type="number" name="nbr-maj" step="1" min="1" max="64" value="<?=$old_maj?>">
            </label>
            <p><label for="chiffre">
                <input type="checkbox" name="chiffre" id="chiffre" <?=$old_chiffre_checked?>>
                Numbers
                <input type="number" name="nbr-chiffre" step="1" min="1" max="64" value="<?=$old_chiffre?>">
            </label>
            <p><label for="special">
                <input type="checkbox" name="special" id="special" <?=$old_special_checked?>>
                Special characters
                <input type="number" name="nbr-special" step="1" min="1" max="64" value="<?=$old_special?>">
            </label>
            <p><input type="submit" name="generate" value="Generate">
        </fieldset>
    </form>
    <footer>
        <p>Made with love by Ioka &#128150</p>
    </footer>
</body>
</html>
