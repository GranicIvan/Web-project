<!DOCTYPE html>
<html lang="en">

<?php 

require_once("db_utils.php");
$d = new Database();
session_start();

if(isset($_POST["formaPost"]) ){
    $kreator = $_SESSION["user"];

    $naslov = htmlspecialchars($_POST["Naslov"]);
    $tekst = htmlspecialchars($_POST["formaPost"]);

    $uspelo =  $d->postaviPost($naslov, $tekst, $kreator);
    if($uspelo){
        echo "  <br/>   Ubacivanje posta je uspelo";
    }else{
        echo "  <br/>   UBACIVANJE POSTA JE PUKLO";
    }

}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ObjavaKomentara</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="pisanjePosta kontejner">
    <form method="post" action="objavaPosta.php">

        <input type="text" size="20" name="Naslov" value="Naslov" >
        <br/>
        <textarea id="formaPost" name="formaPost" rows="9" cols="150">Vasa objava</textarea>
        <br/>

        

        <input type="submit" name="Objavi" value="Objavi">
        <br/>
    </form>
    </div>

    
    <div class="vracanje">
    <button class="buttonVracanje" onclick="history.back()">Vratite se na feed</button>
    </div>"

    
</body>
</html>