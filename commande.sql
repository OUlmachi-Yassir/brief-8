CREATE DATABASE dataware2;

create TABLE equipe(
	id_equipe int(10) PRIMARY KEY auto_increment,
   	nom_equipe char(100),
   	date_creation date
);

create TABLE projet(
	id_pro int(10) PRIMARY KEY auto_increment,
   	nom_pro char(100),
	descrp_pro char(200)
);

create TABLE utilisateur(
    id int(10) PRIMARY KEY  auto_increment ,
    nom char(100),
    prenom char(100),
    email varchar(100),
    pass char(100),
    tel  int(10),
    statut  char(100),
    role  char(100),
    equipe int(10),
    FOREIGN KEY (equipe) REFERENCES equipe(id_equipe),
);

ALTER TABLE utilisateur
add projet int(10),
FOREIGN KEY (projet) REFERENCES projet(id_pro);


insert into projet VALUES (1,'DATAware','make your first web site using php and localhost'),(2,'super pizza','learning html css by practicing it by making a restaurant  site web '),(3,'WWP','making sit web using js and frameworke css');

insert into equipe VALUES (1,'skylanders','2023-5-10'),(2,'nightcrawlers','2023-7-9'),(3,'faceless','2023-10-7');

INSERT INTO utilisateur (id,nom,prenom,email,pass,tel,statut,role) VALUES


