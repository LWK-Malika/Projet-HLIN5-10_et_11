/*use e20160000668;*/

use BDEVENEMENT;


/* TRIGGER SUR L'INTEGRITE DE EVENEMENT */

/*trigger attendu: contrainte d'integriter nom respecté */
/*
insert into evenement (nom) values ('test trigger');
*/
/* insertion quand cela se passe bien */

INSERT INTO EVENEMENT (NOM, DATES, ADRESSE, COORD_LONG, COORD_LAT, EFF_MAX, DESCRIPTION) VALUES ('noel-party-2', '2019-12-25','en ville', '3.885843', '43.621580','15', 'on ouvre les cadeaux');



/* TRIGGER ET PROCEDURE AFFECTANT LES NOTES PERSONNELLE DES PERSONNE AINSI 
QUE LES NOTES DES EVENEMENT*/



/* trigger attendu:  Note personnelle existante anterieur a la date de levenement */
/*
UPDATE participe SET NOTE_PERSO = '4' WHERE ID_PERS = 1 AND ID_EVENEMENT = 1;
*/

/*trigger attendu: Note de l evenement existante anterieur a la date de levenement */
/*
UPDATE evenement SET NOTE = '2' WHERE ID_EVENEMENT = 1
*/

/* moyenne automatiquement calculé en fonction des note personnelle renseigner pour chaque evenenent */

/* note avant evenement*/
select id_evenement, nom,  note from evenement;

/* modification note personnelle d'une personne */
UPDATE participe SET NOTE_PERSO = '18' WHERE ID_PERS = 4 AND ID_EVENEMENT = 3;

/* note modifiée */
select id_evenement, nom, note from evenement;

/* idem quand la note est supprimer (ou modifier ) */
UPDATE participe SET NOTE_PERSO = NULL WHERE ID_PERS = 4 AND ID_EVENEMENT = 3;

/* la note est bien modifiée */ 
select id_evenement, nom, note from evenement;



/* TRIGGER ET PROCEDURE AFFECTANT L'EFFECTIF MAXIMUM DES EVENEMENT */

SELECT id_evenement, nom, eff_max FROM evenement;

/* trigger attendu : effectif max depassé */
update evenement set eff_max = 0 where id_evenement = 3;


/* trigger attendu : effectif max depassé */
update evenement set eff_max = 4 where id_evenement = 3;
INSERT INTO PARTICIPE (ID_PERS, ID_EVENEMENT) VALUES (1,3);






