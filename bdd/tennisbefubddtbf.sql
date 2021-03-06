CREATE TABLE settings_tournament (
    SET_TOURNAMENT VARCHAR(255) NOT NULL,
    SET_TYP_TOURNAMENT CHAR(6) NOT NULL,
    SET_LIB_TOURNAMENT VARCHAR(255) NOT NULL,
    SET_LIB_TYP VARCHAR(255) NOT NULL,
    SET_DAT_START DATETIME NOT NULL,
    SET_DAT_END DATETIME NOT NULL,
    PRIMARY KEY (SET_TOURNAMENT)
)
ENGINE=INNODB;

CREATE TABLE settings_level (
    SET_LVL_ORD INT(2) NOT NULL,
    SET_LVL_LIBELLE VARCHAR(255) NOT NULL,
    PRIMARY KEY (SET_LVL_ORD)
)
ENGINE=INNODB;


CREATE TABLE players (
    PLA_NOM VARCHAR(255) NOT NULL,
    PLA_PAY CHAR(3) NOT NULL,
    PRIMARY KEY (PLA_NOM)
)
ENGINE=INNODB;

CREATE TABLE joueur (
    JOU_ID INT(4) NOT NULL AUTO_INCREMENT,
    JOU_NOM VARCHAR(255) NOT NULL,
    JOU_PRE VARCHAR(255) NOT NULL,
    JOU_PSE VARCHAR(255) NOT NULL,
    JOU_ADR_MAIL VARCHAR(255) NOT NULL,
    JOU_MDP VARCHAR(255) NOT NULL,
    JOU_COUNT INT(1) NOT NULL,
    JOU_TOKEN VARCHAR(60) NOT NULL,
    JOU_DAT_INS DATETIME NOT NULL,
    JOU_PTS_PRONO INT(4) DEFAULT 0,
    JOU_NB_RES_OK INT(4) DEFAULT 0,
    JOU_BONUS_DF INT(4) DEFAULT 0,
    JOU_BONUS_FINAL INT(4) DEFAULT 0,
    JOU_BONUS_VQR INT(4) DEFAULT 0,
    JOU_BONUS_FR_NOM INT(4) DEFAULT 0,
    JOU_BONUS_FR_NIV INT(4) DEFAULT 0,
    JOU_TOT_PTS INT(4) DEFAULT 0,
    PRIMARY KEY (JOU_ID)
)
ENGINE=INNODB;

CREATE TABLE pronostique (
    PRO_JOU_ID INT(4) NOT NULL,
   	PRO_MATCH_ID INT(4) NOT NULL,
    PRO_RES_MATCH CHAR(1) NOT NULL DEFAULT "",
    PRO_SCORE_JOU1 INT(1) NOT NULL DEFAULT 0,
    PRO_SCORE_JOU2 INT(1) NOT NULL DEFAULT 0,
    PRO_TYP_MATCH CHAR(2) NOT NULL DEFAULT "",
    PRO_PTS_JOU INT(4) DEFAULT 0
)
ENGINE=INNODB;


CREATE TABLE pronostique_bonus (
    PROB_JOU_ID INT(4) NOT NULL DEFAULT 0,
   	PROB_VQR VARCHAR(255) NOT NULL DEFAULT "",
    PROB_FINAL1 VARCHAR(255) NOT NULL DEFAULT "",
	PROB_FINAL2 VARCHAR(255) NOT NULL DEFAULT "",
   	PROB_DEMI1 VARCHAR(255) NOT NULL DEFAULT "",
   	PROB_DEMI2 VARCHAR(255) NOT NULL DEFAULT "",
   	PROB_DEMI3 VARCHAR(255) NOT NULL DEFAULT "",
   	PROB_DEMI4 VARCHAR(255) NOT NULL DEFAULT "",
  	PROB_FR_NOM VARCHAR(255) NOT NULL DEFAULT "",
  	PROB_FR_NIV	VARCHAR(255) NOT NULL DEFAULT "",
    PRIMARY KEY (PROB_JOU_ID)
)
ENGINE=INNODB;


CREATE TABLE resultats (
    RES_MATCH_ID INT(4) NOT NULL AUTO_INCREMENT,
    RES_TOURNOI VARCHAR(255) NOT NULL,
    RES_TYP_TOURNOI CHAR(6) NOT NULL,
    RES_MATCH_DAT DATETIME NOT NULL,
    RES_MATCH_TOUR VARCHAR(255) NOT NULL,
    RES_MATCH_POIDS_TOUR INT(1) NOT NULL,
    RES_MATCH_JOU1 VARCHAR(255) NOT NULL,
    RES_MATCH CHAR(1) NOT NULL,
    RES_MATCH_TYP CHAR(2) NOT NULL,
    RES_MATCH_SCR_JOU1 INT(1) NOT NULL,
    RES_MATCH_SCR_JOU2 INT(1) NOT NULL,
 	RES_MATCH_JOU2 VARCHAR(255) NOT NULL,
    PRIMARY KEY (RES_MATCH_ID)
)
ENGINE=INNODB;

INSERT INTO settings_tournament VALUES ('Londres', 'GC', 'Wimbledon', 'GRAND CHELEM', '2019-07-01 10:00:00', '2019-07-14 14:00:00');

INSERT INTO settings_level VALUES (1, '1ER TOUR'), (2,'2EME TOUR'), (3,'3EME TOUR'), (4,'HUITIEME DE FINALE'), (5,'QUART DE FINALE'), (6,'DEMI-FINALE'), (7,'FINALE');