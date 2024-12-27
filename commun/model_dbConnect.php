	<?php

	//************************************************************************************************************************************************************
	//****************************************************** Connexion à la base dedonnées ***********************************************************************
	//************************************************************************************************************************************************************


	function dbConnect(){
		try
		{
			if ($_SERVER['HTTP_HOST'] == 'localhost') {
				//----------------------------------
				//--> Base de données pour le test
				$bdd = new PDO('mysql:host=localhost;dbname=wimbledon2024;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				// $bdd = new PDO('mysql:host=localhost;dbname=marseille2020;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				//----------------------------------
			} else {
				//----------------------------------
				//--> Base de donnée de production
				$bdd = new PDO('mysql:host=tennisbefubddtbf.mysql.db;dbname=tennisbefubddtbf;charset=utf8', 'tennisbefubddtbf', 'nediamBDDTBF1975', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				//----------------------------------
			}
			//----------------------------------
			//--> Base de données pour AWS
			// $bdd = new PDO('mysql:host=localhost;dbname=tennisbetfriends;charset=utf8', 'tbf_username', 'nediamTBF1975', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			//----------------------------------

			return $bdd;
		}
			catch(Exception $e)
		{
			// En cas d'erreur, on affiche un message et on arrête tout
			die('Erreur : '.$e->getMessage());
		}
	}
