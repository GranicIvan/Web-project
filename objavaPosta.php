<!DOCTYPE html>
<html lang="en">

<?php 

require_once("db_utils.php");
$d = new Database();
session_start();

if(isset($_POST["formaPost"]) ){
    $kreator = $_SESSION["user"];

    $naslov = $_POST["Naslov"];
    $tekst = $_POST["formaPost"];

    $uspelo =  $d->postaviPost($naslov, $tekst, $kreator);
    if($uspelo){
        echo "Ubacivanje posta je uspelo";
    }else{
        echo "UBACIVANJE POSTA JE PUKLO";
    }

}

function vracanje(){

    if(isset($_POST["formaPost"])){
        return "<button onclick=\"history.back().back()\">Vratite se na feed.</button>";
    }
    return "<button onclick=\"history.back()\">Vratite se na feed</button>";
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ObjavaKomentara</title>
</head>
<body>
    
    <form method="post" action="objavaPosta.php">

        <input type="text" name="Naslov" value="Naslov">
        <br/>
        <textarea id="formaPost" name="formaPost" rows="6" cols="60">Vasa objava</textarea>
        <br/>

        

        <input type="submit" name="Objavi" value="Objavi">
        <br/>
    </form>


    <?php 
        echo vracanje();
    ?>

    
</body>
</html>