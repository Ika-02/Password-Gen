<?php
$old_length = 16; // Default length
$lowercase = 4; // Default number of lowercase characters
$uppercase = 4; // Default number of uppercase characters
$numbers = 4; // Default number of numbers
$specials = 4; // Default number of special characters
$characters_list = ['lowercase', 'uppercase', 'numbers', 'specials'];
$selected_options = [];

if (isset($_GET['longueur'])) {
    if ($_GET['longueur'] < 6) { $old_length = 6; }
    elseif ($_GET['longueur'] > 64) { $old_length = 64; }
    else { $old_length = $_GET['longueur']; }
} 

if ( isset($_GET['characters']) ) {
    foreach ($_GET['characters'] as $option) {
        if ( in_array($option, $characters_list)) {
            $selected_options[$option] = $_GET['nbr-'.$option];
            switch ($option) {
                case 'lowercase':
                    $lowercase = $_GET['nbr-'.$option];
                    break;
                case 'uppercase':
                    $uppercase = $_GET['nbr-'.$option];
                    break;
                case 'numbers':
                    $numbers = $_GET['nbr-'.$option];
                    break;
                case 'specials':
                    $specials = $_GET['nbr-'.$option];
                    break;
            }
        }
    }
}

// Generating password according to the settings
if (empty($_GET['characters'])) {
    $password = "Select at least one character type";
} else {
    $length = 0;
    foreach ($selected_options as $option => $value) { $length += intval($value); }
    if ($length > $old_length) { $password = "The sum of the number of characters of each type must be less than the length of the password"; }

    else {
        $alphabet = '';
        $password = '';
        foreach ($selected_options as $option => $value) {
            switch ($option) {
                case 'lowercase':
                    $alphabet .= 'abcdefghijklmnopqrstuvwxyz';
                    for ($i = 0; $i < $value; $i++) { $password .= 'abcdefghijklmnopqrstuvwxyz'[rand(0, 25)]; }
                    break;
                case 'uppercase':
                    $alphabet .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    for ($i = 0; $i < $value; $i++) { $password .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'[rand(0, 25)]; }
                    break;
                case 'numbers':
                    $alphabet .= '0123456789';
                    for ($i = 0; $i < $value; $i++) { $password .= '0123456789'[rand(0, 9)]; }
                    break;
                case 'specials':
                    $alphabet .= '!@#$%^&*()_-+=;:,./?';
                    for ($i = 0; $i < $value; $i++) { $password .= '!@#$%^&*()_-+=;:,./?'[rand(0, 19)]; }
                    break;
            }
        }
        $password = str_shuffle($password);
        while (strlen($password) < $old_length) { $password .= $alphabet[rand(0, strlen($alphabet) - 1)]; }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <?php foreach ($characters_list as $option) { ?>
			<p><label for="choix<?=$option?>">
				<input type="checkbox" name="characters[]" value="<?=$option?>" id="choix<?=$option?>"
                <?php if ( array_key_exists($option, $selected_options) ) echo ' checked'; ?>>
                <?=ucfirst($option)?>
                <input type="number" name="nbr-<?=$option?>" min="1" max="64" value="<?=$$option?>">
            </label>
            <?php } ?>
            <p><input type="submit" name="generate" value="Generate">
        </fieldset>
    </form>
    <footer>
        <p>Made with love by Ioka &#128150</p>
    </footer>
</body>
</html>
