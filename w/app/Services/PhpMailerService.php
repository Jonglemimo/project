<?php
namespace Services;

class PhpMailerService {
    
    function sendMail($address, $subject, $bodyHtml, $bodyPlain) {

        $phpMailer = new \PHPMailer();

        $phpMailer->isSMTP();                                      	// On va se servir de SMTP
        $phpMailer->Host = 'smtp.gmail.com';  						// Serveur SMTP
        $phpMailer->SMTPAuth = true;                               	// Active l'autentification SMTP
        $phpMailer->Username = 'wf3.mailer@gmail.com';             	// SMTP username
        $phpMailer->Password = '$NJ27^^4q7';                   		// SMTP password
        $phpMailer->SMTPSecure = 'tls';                            	// TLS Mode
        $phpMailer->Port = 587;
        $phpMailer->CharSet = 'UTF-8';

        //$phpMailer->SMTPDebug = 2;

        $phpMailer->setFrom('wf3.mail@gmail.com', 'Réinitialisation du mot de passe', false);
        $phpMailer->addAddress($address);     		                // Ajouter un destinataire
        $phpMailer->addReplyTo('wf3.mailer@gmail.com', 'Réinitialisation du mot de passe');

        $phpMailer->isHTML(true);                                  	 // Set email format to HTML

        $phpMailer->Subject = $subject;
        $phpMailer->Body    = $bodyHtml;
        $phpMailer->AltBody = $bodyPlain;

            return $phpMailer->send();

    }
}