<!DOCTYPE html>
<html lang="en">


<?php 


require_once("db_utils.php");
$d = new Database();

session_start();

if (isset($_GET["izabranPost"])) {
    //Ovo okrenuti
}else{
    //echo 'ispisiGresku';
    header( "Location: feed.php" );
}

$trenutnaObjava = $d->getPostByID($_GET["izabranPost"]);
$kreator = $d->getUserByID($trenutnaObjava[COL_OBJAVA_KREATOR]);
$komentari = $d->getKomentariByObjava($_GET["izabranPost"]);

function getKomentariHTML($komentari, $d){


    if(count($komentari) >0){
        $rez = "<div class=\"kontejner\">
        <div class=\"komentar\">";

        foreach($komentari as $jedanKomentar){
            $kreatorKomentara = $d->getKreatorKomentaraByID($jedanKomentar[COL_KOMENTAR_KREATOR]);
           
            $imeIPrezimeKreatoraKomentara = $d->getImePrezimeKreatoraKomentara($kreatorKomentara["Kreator_Komentara"]);
            $imePrezimeKreat = $imeIPrezimeKreatoraKomentara["Ime"]. " " . $imeIPrezimeKreatoraKomentara["Prezime"];
            
            $temp = "
            <div class=\"jedanKomentar\">
                <p>$imePrezimeKreat</p>
                <p>{$jedanKomentar[COL_KOMENTAR_TEKST]}</p>
                

            <div/>
            ";
            $rez = $rez . $temp;
        }


        $rez= $rez. "</div>
        </div>";
        return $rez;
    }else{
        return "
        <div class=\"kontejner\">
				<div class=\"komentar\">
                    
                    <p>Ovaj post nema komentare. Budite prvi koji ce komentarisati </p>
					 <br/>
                     
				</div>
			</div>
        ";
    }


}

function getObjavaiHTMLObjava($objava, $kreator)
{

    $imePrezime = $kreator[COL_KORISNIK_IME] . ' ' .  $kreator[COL_KORISNIK_PREZIME];

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



function pisanjeKomentara(){
    if (isset($_SESSION["user"]) ){
        $temp = $_SESSION["user"];
        $idPosta = $_GET["izabranPost"];
    
        return "
            
        <form method=\"post\" action=\"objavaKomentara.php\">

                <textarea id=\"formaKom\" name=\"formaKom\" rows=\"4\" cols=\"50\">Vas kometar</textarea>
                <br/>
                
                <input type=\"hidden\" id=\"izabranPost\" name=\"izabranPost\" value=$idPosta>

                <input type=\"submit\" name=\"Komentarisi\" value=\"Komentarisi\">
		</form>

           
        ";
    }else{
        return "
            <div class='ulogujSeDaPisesKomentar'>
                <p>Morate biti ulogovoni da bi pisali komentare<p/>
            <div/>
        ";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objava</title>
</head>
<body>
    
    <div class="glavniPost">
        
        <?php 
        echo getObjavaiHTMLObjava($trenutnaObjava, $kreator);
        ?>

    </div>



    <div class="komentari">
        <?php 
        echo getKomentariHTML($komentari, $d);
        ?>

    </div>


    <div class="pisanjeKomentara">
        <?php 
           echo pisanjeKomentara();
        ?>
       

    </div>
    <button onclick="history.back()">Vratite se na sve postove</button>

</body>
</html>