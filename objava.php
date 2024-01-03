<!DOCTYPE html>
<html lang="en">


<?php 

if (isset($_GET["izabranPost"])) {
    echo 'ispisiStranicu';
}else{
    echo 'ispisiGresku';
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objava</title>
</head>
<body>
    
    <div class="glavniPost">
        <p>Ovde pise post</p>

    </div>



    <div class="komentari">
        <p>Ovde pisu komentari</p>

    </div>


    <div class="pisanjeKomentara">
        <p>Ovde je text field za pisanje komentara za odredeni post i dugme submit</p>

    </div>

</body>
</html>