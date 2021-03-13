<?php

require_once("../../../wp-load.php");
require 'variables.php';

function displayFormResult($website_contact_page, $resultat) {

  header("Location: " . $website_contact_page . "?resultat=" . $resultat . "#envoyermessage");
  die("ok");

}

function assembleMessage($nom, $prenom, $email, $message, $newsletter) {

  $newsletter === "newsletter_yes" ? $nl = "OUI" : $nl = "NON";

  $message_pret = "De la part de " . $prenom . " " . $nom . " (" . $email . ") :\n\n" . $message . "\n\nInscription à la newsletter : " . $nl;

  return $message_pret;

}

function assembleHeaders($prenom, $nom, $sender_email, $receiver_email) {

  $headers[] = 'To: <'.$receiver_email.'>';
  $headers[] = 'From: '.$prenom.' '.$nom.' <'.$sender_email.'>';

  return implode("\r\n", $headers);
}

if (empty($_POST['nom']) 
    || empty($_POST['prenom']) 
    || empty($_POST['email']) 
    || empty($_POST['message'])) {

  // Message erreur : Tous les champs doivent être remplis
  displayFormResult('erreur_champ_vide');

} else {

    // Email & objet
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']); 
    $newsletter = htmlspecialchars($_POST['newsletter']); 

    $erreur = "";

    // Règles champs formulaire
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    $string_exp = "/^[a-z ,.'-]+$/i";
    $nolink_check = '/https?:\/\//'; // Vérification de bot envoyant des liens
    $captcha_answer = '/4|quatre/i'; // Captcha

    if (!preg_match($email_exp, $email)) {
      displayFormResult('erreur_email_invalide');
    }

    if (!preg_match($string_exp, $prenom) || strlen($prenom) < 2) {
      displayFormResult('erreur_prenom');
    }

    if (!preg_match($string_exp, $nom) || strlen($nom) < 2) {
      displayFormResult('erreur_nom');
    }

    if(preg_match($nolink_check, $message)) {
      displayFormResult('erreur_lien');
    }

    $message_pret = assembleMessage($nom, $prenom, $email, $message, $newsletter);
    $headers = assembleHeaders($prenom, $nom, $email, $email_to_test);

    wp_mail($email_to, $objet, $message_pret, $headers);
    wp_mail($email_to_test, $objet, $message_pret, $headers);

    displayFormResult($website_contact_page, "ok");
}
?>