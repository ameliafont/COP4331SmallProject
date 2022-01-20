create database COP4331;
use COP4331;

CREATE TABLE `COP4331`.`Users` 
( 
  `ID` INT NOT NULL AUTO_INCREMENT , 
    `DateCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `DateLastLoggedIn` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `FirstName` VARCHAR(50) NOT NULL DEFAULT '' , 
    `LastName` VARCHAR(50) NOT NULL DEFAULT '' ,
    `Login` VARCHAR(50) NOT NULL DEFAULT '' , 
    `Password` VARCHAR(50) NOT NULL DEFAULT '' , 
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB;

CREATE TABLE `COP4331`.`Contacts` 
( 
  `ID` INT NOT NULL AUTO_INCREMENT , 
  `FirstName` VARCHAR(50) NOT NULL DEFAULT '' , 
  `LastName` VARCHAR(50) NOT NULL DEFAULT '' ,
  `EMail` VARCHAR(50) NOT NULL DEFAULT '' ,
  `UserID` INT NOT NULL DEFAULT '0' , 
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB;

USE COP4331;

insert into Users (FirstName,LastName,Login,Password) VALUES ('Rick','Leinecker','RickL','COP4331');
insert into Users (FirstName,LastName,Login,Password) VALUES ('Sam','Hill','SamH','Test');
insert into Users (FirstName,LastName,Login,Password) VALUES ('Rick','Leinecker','RickL','5832a71366768098cceb7095efb774f2');
insert into Users (FirstName,LastName,Login,Password) VALUES ('Sam','Hill','SamH','0cbc6611f5540bd0809a388dc95a615b');

insert into Contacts (Firstname,LastName,UserID) VALUES ('Jay','Brown', 3)
