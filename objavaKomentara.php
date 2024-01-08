<!DOCTYPE html>
<html lang="en">

<?php 

require_once("db_utils.php");
$d = new Database();

session_start();

if(isset($_POST["formaKom"]) ){
    $tekstKomentara = $_POST["formaKom"];
    $zaPost = $_POST["izabranPost"];
    $komentator = $_SESSION["user"];

    $uspelo =  $d->postaviKomentar($tekstKomentara, $zaPost, $komentator);
    if($uspelo){
        echo "Ubacivanje kometara je uspelo";
    }else{
        echo "UBACIVANJE KOMENTARA JE PUKLO";
    }

}else{
    header( "Location: feed.php" );
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ObjavaKomentara</title>
</head>
<body>
    <p>OBJAVILI STE KOMETAR</p>
    <button onclick="history.back()">Vratite se na post</button>
</body>
</html>