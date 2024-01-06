-- MySQL Script generated by MySQL Workbench
-- Fri Dec 29 12:54:03 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Web2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Web2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Web2` DEFAULT CHARACTER SET utf8 ;
USE `Web2` ;

-- -----------------------------------------------------
-- Table `Web2`.`Korisnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Web2`.`Korisnik` (
  `idKorisnik` INT NOT NULL AUTO_INCREMENT,
  `Ime` VARCHAR(45) NOT NULL,
  `Prezime` VARCHAR(45) NULL,
  `Email` VARCHAR(45) NOT NULL,
  `Sifra` VARCHAR(45) NOT NULL,
  `Rodjenje` DATE NULL,
  `Slika` VARCHAR(45) NULL,
  PRIMARY KEY (`idKorisnik`))
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `Web2`.`Objava`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Web2`.`Objava` (
  `idObjava` INT NOT NULL AUTO_INCREMENT,
  `Naslov` VARCHAR(65) NOT NULL,
  `Tekst` LONGTEXT NULL,
  `Datum` DATETIME NOT NULL,
  `Kreator_Objave` INT NOT NULL,
  PRIMARY KEY (`idObjava`),
  INDEX `fk_Post_Korisnik_idx` (`Kreator_Objave` ASC),
  CONSTRAINT `fk_Post_Korisnik`
    FOREIGN KEY (`Kreator_Objave`)
    REFERENCES `Web2`.`Korisnik` (`idKorisnik`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `Web2`.`Komentar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Web2`.`Komentar` (
  `idKomentar` INT NOT NULL AUTO_INCREMENT,
  `Tekst` LONGTEXT NOT NULL,
  `Objava_idObjava` INT NOT NULL,
  `Kreator_Komentara` INT NOT NULL,
  PRIMARY KEY (`idKomentar`),
  INDEX `fk_Komentar_Post1_idx` (`Objava_idObjava` ASC),
  INDEX `fk_Komentar_Korisnik1_idx` (`Kreator_Komentara` ASC),
  CONSTRAINT `fk_Komentar_Post1`
    FOREIGN KEY (`Objava_idObjava`)
    REFERENCES `Web2`.`Objava` (`idObjava`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Komentar_Korisnik1`
    FOREIGN KEY (`Kreator_Komentara`)
    REFERENCES `Web2`.`Korisnik` (`idKorisnik`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;