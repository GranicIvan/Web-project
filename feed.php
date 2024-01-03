<!DOCTYPE html>
<html lang="en">

<?php


require_once("db_utils.php");
session_start();
$d = new Database();


$main_user = false;
if (isset($_POST["loginButton"])) {
    $main_user = $d->checkLogin($_POST["email"], $_POST["password"]);
    if (!$main_user) {
        header( "Location: index.php?login-fail" );
    } else {
        $_SESSION["user"] = $main_user;
        if ($_POST["remember-me"]) {
            setcookie("email", $main_user[COL_KORISNIK_EMAIL], time()+60*60*24*365);
        }
        header( "Location: feed.php" );
    }
}else {
    
    echo "TODO ovde da se proveri da li smo logged in i ispisemo sta treba";
}


function getObjavaiHTML($objava, $kreator)
{

    $imePrezime = $kreator[COL_KORISNIK_IME] . ' ' .  $kreator[COL_KORISNIK_PREZIME];

    return
        "<div class=\"kontejner\">
				<div class=\"objava\">
                    <a href='objava.php?izabranPost={$objava[COL_OBJAVA_ID]}'>{$objava[COL_OBJAVA_NASLOV]}</a>
                    <h2>{$objava[COL_OBJAVA_NASLOV]}</h2>
					<h3>{$imePrezime} </h3>
                    
                    <p>{$objava[COL_OBJAVA_TEKST]}</p>
                    <p>{$objava[COL_OBJAVA_DATUM]}</p>
                   
                    //Ovde bi dosli komentari
					 <br/>
                     
				</div>
			</div>";
}

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
</head>

<body>

    <a href="index.php?logout" id="logout-button">LOG OUT</a>
	

    <?php

    $posts = $d->getPosts();
    if (count($posts) > 0) {
        foreach ($posts as $jedanPost) {
            $kreator = $d->getUserByID($jedanPost[COL_OBJAVA_KREATOR]);
            echo getObjavaiHTML($jedanPost, $kreator);
        }
    }

    ?>

</body>

</html>