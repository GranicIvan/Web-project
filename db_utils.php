<?php

require_once("constants.php");


class Database
{
    private $conn;


    public function __construct($configFile = "config.ini")
    {
        if ($config = parse_ini_file($configFile)) {
            $host = $config["host"];
            $database = $config["database"];
            $user = $config["user"];
            $password = $config["password"];
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }


    //
    //public function ubaciKorisnika($ime, $prezime, $email, $password, $birthday)
    public function insertUser($surname, $password1, $name, $email, $birthday){
    
        try {

            $sql_existing_user = "SELECT * FROM " . TBL_KORISNIK . " WHERE " . COL_KORISNIK_EMAIL . "= :email";
            
            $st = $this->conn->prepare($sql_existing_user);
            $st->bindValue(":email", $email, PDO::PARAM_STR);
            //Vec postoji korisnik sa tim mejlom
            $st->execute();
            if ($st->fetch()) {
                return false;
            }


            $sql_insert = "INSERT INTO " . TBL_KORISNIK . " (" . COL_KORISNIK_EMAIL . ","
                . COL_KORISNIK_IME . ","
                . COL_KORISNIK_PREZIME . ","
                . COL_KORISNIK_SIFRA . ","                
                . COL_KORISNIK_RODJENJE . ")" 
                . " VALUES (:email, :name, :surname, :password, :birthday)";
                // VALUES (NULL, 'zala', 'gaza', 'laza@', '1234', '2024-01-18', NULL);

                //echo $sql_insert;

                $st = $this->conn->prepare($sql_insert);
                $st->bindValue("name", $name, PDO::PARAM_STR);
                $st->bindValue("surname", $surname, PDO::PARAM_STR);
                $st->bindValue("password", $password1, PDO::PARAM_STR);
                $st->bindValue("email", $email, PDO::PARAM_STR);                
                $st->bindValue("birthday", $birthday, PDO::PARAM_STR);                
                
                return $st->execute();

        } catch (PDOException $e) {
            echo '<dialog>
            <p>Greska mi kreiranju naloga.</p>
            </dialog>';
            return false;
        }
    }


    public function getKorisniks()
    {
        try {
            $sql = "SELECT * FROM " . TBL_KORISNIK ;
            $st = $this->conn->prepare($sql);
            $st->execute();
            return $st->fetchAll();
        } catch (PDOException $e) {
            return array();
        }
    }


    public function getPosts()
    {
        try {
            $sql = "SELECT * FROM " . TBL_OBJAVA ;
            $st = $this->conn->prepare($sql);
            $st->execute();
            return $st->fetchAll();
        } catch (PDOException $e) {
            return array();
        }
    }

    public function getUserByID($id){
        try {
            $sql = "SELECT * FROM " . TBL_KORISNIK . " WHERE " . COL_KORISNIK_ID . "=:user";
            $st = $this->conn->prepare($sql);
            $st->bindValue("user", $id, PDO::PARAM_INT);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getPostByID($id){
        try {
            $sql = "SELECT * FROM " . TBL_OBJAVA . " WHERE " . COL_OBJAVA_ID . "=:objava";
            $st = $this->conn->prepare($sql);
            $st->bindValue("objava", $id, PDO::PARAM_INT);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }



    public function checkLogin($username, $password)
    {
        try {
            
            $sql = "SELECT * FROM " . TBL_KORISNIK . " WHERE " . COL_KORISNIK_EMAIL . "=:username and " . COL_KORISNIK_SIFRA . "=:password";
            $st = $this->conn->prepare($sql);
            $st->bindValue("username", $username, PDO::PARAM_STR);
            $st->bindValue("password", $password, PDO::PARAM_STR);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }


    public function getKomentariByObjava($idObjava){
        try {
            $sql = "SELECT * FROM " . TBL_KOMENTAR . " WHERE " . COL_KOMENTAR_OBJAVA . "=:objava";
            $st = $this->conn->prepare($sql);
            $st->bindValue("objava", $idObjava, PDO::PARAM_INT);
            $st->execute();
            return $st->fetchAll();
        } catch (PDOException $e) {
            return array();
        }
    }
    
    function getKreatorKomentaraByID($kreator){
        try {
            $sql = "SELECT * FROM " . TBL_KOMENTAR . " WHERE " . COL_KOMENTAR_KREATOR . "=:kreator";
            $st = $this->conn->prepare($sql);
            $st->bindValue("kreator", $kreator, PDO::PARAM_INT);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }


    function getImePrezimeKreatoraKomentara($kreatorKomentaraID){
        try {
            $sql = "SELECT * FROM " . TBL_KORISNIK . " WHERE " . COL_KORISNIK_ID . "=:kreator";
            $st = $this->conn->prepare($sql);
            $st->bindValue("kreator", $kreatorKomentaraID, PDO::PARAM_INT);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    function postaviKomentar($tekstKomentara, $zaPost, $komentator){
        try {
            
            $komentatorID = $komentator[COL_KORISNIK_ID];
            
            $sql_insert = "INSERT INTO " . TBL_KOMENTAR . " (".COL_KOMENTAR_TEKST.","
                                                          .COL_KOMENTAR_OBJAVA.","
                                                          .COL_KOMENTAR_KREATOR.")"
                        ." VALUES (:tekst, :objava, :kreator)";

            $st = $this->conn->prepare($sql_insert);
            $st->bindValue("tekst", $tekstKomentara, PDO::PARAM_STR);
            $st->bindValue("objava", $zaPost, PDO::PARAM_STR);
            $st->bindValue("kreator", $komentatorID, PDO::PARAM_STR);         
            
            return $st->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    //$naslov, $tekst, $kreator
    function postaviPost($naslov, $tekst, $kreator){
        try {
            
            $kreatorID = $kreator[COL_KORISNIK_ID];
            
            $sql_insert = "INSERT INTO " . TBL_OBJAVA . " (".COL_OBJAVA_NASLOV.","
                                                          .COL_OBJAVA_TEKST.","
                                                          .COL_OBJAVA_KREATOR.","
                                                          .COL_OBJAVA_DATUM.")"
                        ." VALUES (:naslov, :tekst, :kreator, :datum)";

            $st = $this->conn->prepare($sql_insert);
            $st->bindValue("naslov", $naslov, PDO::PARAM_STR);
            $st->bindValue("tekst", $tekst, PDO::PARAM_STR);
            $st->bindValue("kreator", $kreatorID, PDO::PARAM_STR);     
            $st->bindValue("datum", date("Y-m-d H:i:s"), PDO::PARAM_STR);      
            
            return $st->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
