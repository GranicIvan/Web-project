<!DOCTYPE html>
<html lang="en">

<?php

require_once("db_utils.php");
session_start();
$d = new Database();
$errors = [];
$messages = [];

if (isset($_GET["logout"])){
    session_destroy();
} elseif (isset($_SESSION["user"])) {
    header( "Location: feed.php" );
}

function outputError($errorCode)
{
    global $errors;
    if (isset($errors[$errorCode])) {
        echo '<div class="error">' . $errors[$errorCode] . '</div>';
    }
}



$name = $surname  = $email = $password1 = $password2 = $birthday =  "";





function getKorisniciHTML($korisnik)
{
    return
        "<div class=\"kontejner\">
				<div class=\"korisnik\">
					<h4>{$korisnik[COL_KORISNIK_IME]} {$korisnik[COL_KORISNIK_PREZIME]}</h4>
                    <h4>{$korisnik[COL_KORISNIK_EMAIL]}</h4>
                    <h4>{$korisnik[COL_KORISNIK_RODJENJE]}</h4>
                    <br/>

					
				</div>
			</div>";
}

//$kreator = $d->getUserByID($objava[COL_OBJAVA_KREATOR]);
function getObjavaiHTML($objava, $kreator)
{
   
    $imePrezime = $kreator[COL_KORISNIK_IME] .' ' .  $kreator[COL_KORISNIK_PREZIME];

    return
        "<div class=\"kontejner\">
				<div class=\"objava\">
                    <h2>{$objava[COL_OBJAVA_NASLOV]}</h2>
					<h3>{$imePrezime} </h3>
                    
                    <p>{$objava[COL_OBJAVA_TEKST]}</p>
                    <p>{$objava[COL_OBJAVA_DATUM]}</p>
                   
					 <br/>

				</div>
			</div>";
}


if (isset($_GET["login-fail"])) {
    $messages[] = "Pogrešan username ili šifra";
}




if (isset($_POST["registerButton"])) {
    
    // Setovanje promenljivih iz registracione forme
    if ($_POST["name"]) {
        $name = htmlspecialchars($_POST["name"]);
    }	
    if ($_POST["surname"]) {
        $surname = htmlspecialchars($_POST["surname"]);
    }	
    if ($_POST["email"]) {
        $email = htmlspecialchars($_POST["email"]);
    }
    
    if ($_POST["password1"]) {
        $password1 = $_POST["password1"];
    }	
    if ($_POST["password2"]) {
        $password2 = $_POST["password2"];
    }
    if ($_POST["birthday"]) {
        $birthday = htmlspecialchars($_POST["birthday"]);
    }


    // Validacija podataka iz registracione forme
    if (!$name) {
        $errors["name"] = "Unesite ime";
    }		
    if (!$surname) {
        $errors["surname"] = "Unesite prezime";
    }		
    	
    if (!$email) {
        $errors["email"] = "Unesite email adresu";
    }		
    if (!$password1) {
        $errors["password1"] = "Unesite lozinku";
    }
    if ($password1 != $password2){
        $errors["poklapanjeLozinki"] = "Lozinke su različite";
    }		
    if (!$birthday) {
        $errors["birthday"] = "Unesite datum rođenja";
    }

    if (empty($errors)) {
        
        $success = $d->insertUser($surname, $password1, $name, $email, $birthday);
        $messages[] = $success ? "Uspešno ste se registrovali" : "Registracija nije uspela";
    }
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <h1>Forum Prirodno Matematickog Fakulteta</h1>


    <div id="sadrzaj">


    

    <?php
    if (!empty($messages)) {
        echo "<div class=\" poruke svetlo\">";
        foreach ($messages as $message) {
            echo "<div>$message</div>";
        }
        echo "</div><br>";
    }
    ?>

    <!-- OVDE SREDI ZA CSS -->
    <div class="kontejner login">
        <h2>Uloguj se</h2>
        <form method="post" action="feed.php">
            <label for="username">Email:</label>
            <input type="text" name="email" value="<?php echo isset($_COOKIE["username"]) ? $_COOKIE["username"] : ""; ?>"><br>

            <label for="password">Sifra:</label>
            <input type="password" name="password"><br>

            <input type="checkbox" name="remember-me" checked> Zapamti moj username<br>
            <a href="?forget-me">Forget me</a>
            <br>

            <input type="submit" name="loginButton" value="Uloguj se">
        </form>
    </div>



    <div class="kontejner registracija svetlo">
        <h2>Registruj se</h2>
        <p>* Obavezno polje.</p>
        <form method="post" action="">
            <label for="name" class="obavezno-polje">Ime:</label>
            <?php outputError("name"); ?>
            <input type="text" name="name" value="<?php echo $name; ?>"><br>
              
            <label for="surname" class="obavezno-polje">Prezime:</label>
            <?php outputError("surname"); ?>
            <input type="text" name="surname" value="<?php echo $surname; ?>"><br>
              
            <label for="email" class="obavezno-polje">Email adresa:</label>
            <?php outputError("email"); ?>
            <input type="text" name="email" value="<?php echo $email; ?>"><br>
              
            <label for="password1" class="obavezno-polje">Lozinka:</label>
            <?php outputError("password1"); ?>
            <input type="password" name="password1" value="<?php echo $password1; ?>"><br>
              
            <label for="password2" class="obavezno-polje">Ponovi lozinku:</label>
            <?php outputError("password2"); ?>
            <?php outputError("poklapanjeLozinki"); ?>
            <input type="password" name="password2" value="<?php echo $password2; ?>"><br>
              
            <label for="date" class="obavezno-polje">Datum rođenja:</label>
            <?php outputError("birthday"); ?>
            <input type="date" name="birthday" value="<?php echo $birthday; ?>"><br>
              

            <input type="submit" name="registerButton" value="Registruj me">
        </form>
    </div>

    <?php
 


    ?>

    <div class="anonimno ">
       
        <button  class="buttonAnonimno" onclick="window.location.href='feed.php';">Gledajte postove bez logovanja</button>
    
    </div>
    

    </div>
</body>

</html>