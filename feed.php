<!DOCTYPE html>
<html lang="en">

<?php


require_once("db_utils.php");
session_start();
$d = new Database();


$main_user = false;
if (isset($_POST["loginButton"])) {
    $main_user = $d->checkLogin(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["password"]));
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
    
}


function getObjavaiHTML($objava, $kreator)
{

    $imePrezime = $kreator[COL_KORISNIK_IME] . ' ' .  $kreator[COL_KORISNIK_PREZIME];

    return
        "<div class=\"kontejner\">
				<div class=\"objava\">
                    <h2> <a href='objava.php?izabranPost={$objava[COL_OBJAVA_ID]}'>{$objava[COL_OBJAVA_NASLOV]}</a></h2>
					<h3>{$imePrezime} </h3>
                    
                    <p>{$objava[COL_OBJAVA_TEKST]}</p>
                    <p>{$objava[COL_OBJAVA_DATUM]}</p>
                   
					 <br/>
                     
				</div>
			</div>";
}


function objavaPosta(){
    if (isset($_SESSION["user"]) ){
        
        
    
        return "<a href=\"objavaPosta.php\">Objavite post</a>";
    }else{
        return "<p>Morati biti ulogovani da bi okacilli objavu.</p>";
    }
}


?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="logOut">
        <a  class="logOutColor" href="index.php?logout" id="logout-button">LOG OUT</a>
    </div>

    <?php

    $posts = $d->getPosts();
    if (count($posts) > 0) {
        foreach ($posts as $jedanPost) {
            $kreator = $d->getUserByID($jedanPost[COL_OBJAVA_KREATOR]);
            echo getObjavaiHTML($jedanPost, $kreator);
        }
    }

    ?>

    <div class="vracanje">
    <?php 
        echo objavaPosta();
    ?>
       
    </div>
</body>

</html>