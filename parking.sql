CREATE TABLE IF NOT EXISTS listedattente (
  positionattente int(2) NOT NULL,
  codeclient int(5) NOT NULL,
  PRIMARY KEY (positionattente),
  KEY codeclient (codeclient)
) ENGINE=InnoDB;


INSERT INTO listedattente (positionattente, codeclient) VALUES
(1, 4);



CREATE TABLE IF NOT EXISTS notifications (
  numnotif int(3) NOT NULL,
  datenotif date NOT NULL,
  nbjours int(3) NOT NULL,
  numuser int(2) NOT NULL,
  PRIMARY KEY (numnotif),
  KEY numuser (numuser),
  KEY numuser_2 (numuser)
) ENGINE=InnoDB;


INSERT INTO notifications (numnotif, datenotif, nbjours, numuser) VALUES
(1, '2015-12-03', 9, 4);



CREATE TABLE IF NOT EXISTS placeoccupee (
  numoccupee int(11) NOT NULL,
  statut_place int(11) NOT NULL,
  codeclient int(11) DEFAULT NULL,
  PRIMARY KEY (numoccupee)
) ENGINE=InnoDB;


INSERT INTO placeoccupee (numoccupee, statut_place, codeclient) VALUES
(1, 1, 2),
(2, 1, 3);



CREATE TABLE IF NOT EXISTS placeparking (
  numplace int(2) NOT NULL AUTO_INCREMENT,
  datedebut date NOT NULL,
  echeance date NOT NULL,
  PRIMARY KEY (numplace)
) ENGINE=InnoDB AUTO_INCREMENT=4 ;



INSERT INTO placeparking (numplace, datedebut, echeance) VALUES
(1, '2015-12-04', '2015-12-09'),
(2, '2015-12-04', '2015-12-13');



CREATE TABLE IF NOT EXISTS utilisateurs (
  numutil int(5) NOT NULL AUTO_INCREMENT,
  nomutil varchar(20) NOT NULL,
  prenomutil varchar(20) NOT NULL,
  email varchar(40) NOT NULL,
  motdepasse varchar(40) NOT NULL,
  dateinscription date NOT NULL,
  admin tinyint(1) NOT NULL,
  PRIMARY KEY (numutil)
) ENGINE=InnoDB AUTO_INCREMENT=5 ;



INSERT INTO utilisateurs (numutil, nomutil, prenomutil, email, motdepasse, dateinscription, admin) VALUES
(1, 'JHINGOOR', 'Akram', 'akram@admin.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-11-10', 1),
(2, 'GILIBERT', 'Kevin', 'kev-gili@m2l.fr', '3b004ac6d8a602681f5ee3587c924855679e21d9', '2015-11-18', 0),
(3, 'AZOULAI', 'Hicham', 'hicham@m2l.fr', 'd9660d6d9bcb38b802942531687d97ea1d3bd8b9', '2015-11-23', 0),
(4, 'CERRUTTI', 'Cerise', 'cerisegroupama@m2l.fr', '1bd4fc6676e2665db5cc6377faa7fe5faeeb0305', '2015-12-01', 0);


ALTER TABLE listedattente
  ADD CONSTRAINT listedattente_ibfk_1 FOREIGN KEY (codeclient) REFERENCES utilisateurs (numutil);



ALTER TABLE notifications
  ADD CONSTRAINT notifications_ibfk_1 FOREIGN KEY (numuser) REFERENCES utilisateurs (numutil);



ALTER TABLE placeoccupee
  ADD CONSTRAINT pparking_constraint FOREIGN KEY (numoccupee) REFERENCES placeparking (numplace);

