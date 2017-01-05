<?php
namespace Services;

class PhpMailerService {
    
    function sendMail($address, $subject, $bodyHtml, $bodyPlain) {

        $phpMailer = new \PHPMailer();

        $phpMailer->isSMTP();                                      	// On va se servir de SMTP
        $phpMailer->Host = 'smtp.gmail.com';  						// Serveur SMTP
        $phpMailer->SMTPAuth = true;                               	// Active l'autentification SMTP
        $phpMailer->Username = 'tutomotionwf3@gmail.com';             	// SMTP username
        $phpMailer->Password = 'webforce3';                   		// SMTP password
        $phpMailer->SMTPSecure = 'tls';                            	// TLS Mode
        $phpMailer->Port = 587;
        $phpMailer->CharSet = 'UTF-8';

/*        $phpMailer->SMTPDebug = 2;*/

        $phpMailer->setFrom('tutomotionwf3@gmail.com', 'Service client Tutomotion', false);
        $phpMailer->addAddress($address);     		                // Ajouter un destinataire
        $phpMailer->addReplyTo('tutomotionwf3@gmail.com', 'Service client Tutomotion');

        $phpMailer->isHTML(true);                                  	 // Set email format to HTML

        $phpMailer->Subject = $subject;
        $phpMailer->Body    = $bodyHtml;
        $phpMailer->AltBody = $bodyPlain;

            return $phpMailer->send();

    }
}