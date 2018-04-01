<?php

/* 
 *             2017-2018
 * Author : Silas riacourt <silasdu22@gmail.com>
 * 
 */
	$user_id = $_GET['id'];

	$token = $_GET['token'];
        require_once 'inc/db.php';
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	$req = $bdd->prepare('SELECT * FROM users WHERE id =?');
	$req->execute([$user_id]);
	$user = $req->fetch();
	session_start();
	if ($user && $user->confirmation_token == $token) {

		$bdd->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
		$_SESSION['flash']['success'] = 'Votre compte a bien été valider';
		$_SESSION['auth'] = $user;
		header('Location: account.php');
	}else {
		$_SESSION['flash']['danger'] ="Ce token n'est plus valide";
		header('Location: login.php');

	}
