<?php

namespace Controller;

use Services\PhpMailerService;
use W\Controller\Controller;
use \Model\RecoveryTokenModel;
use W\Security\AuthentificationModel;




class RecoveryTokenController extends Controller {

    function lostPassword () {

        $mail = new PhpMailerService();
        $userModel = new RecoveryTokenModel();

        if (isset($_POST['reset-password'])) {
            $errors = array();

            //CHECKING FIELDS
            if (!empty($_POST['mail'])) {

                $userMail = $_POST['mail'];

                //TESTING EMAIL VALIDITY
                $isMailValid = filter_var($userMail, FILTER_VALIDATE_EMAIL);
                if (!$isMailValid) {
                    $errors['mail'] = 'L\'adresse email renseigné n\'est pas valide';
                }

                if (count($errors) == 0) {

                    if ($userModel->emailExists($userMail)) {

                        $user = $userModel->getUserByUsernameOrEmail($userMail);
                        $id_user = $user['id'];
                        $token = bin2hex(openssl_random_pseudo_bytes(40));
                        $userModel->createToken($id_user, $token);
                        $subject = 'Réinitialisation du mot de passe';
                        $bodyHtml = 'Voici le lien de réinitialisation http://localhost/Formation/Cours/group-project/project/w/public/signin/reset_pass/' . $token;
                        $bodyPlain = 'Voici le lien de réinitialisation http://localhost/Formation/Cours/group-project/project/w/public/signin/reset_pass/' . $token;
                        $mail->sendMail($userMail, $subject, $bodyHtml, $bodyPlain);
                        $this->show('user/lostPassword',['success' => 'Votre email de réinitialisation a été envoyé']);

                    } else {

                        //ECHO 'cette adresse Email n\'existe pas';
                        $errors['wrongEmail'] = 'Cette adresse mail n\'est pas enregistrée dans notre base de donnée';
                        $this->show('user/lostPassword',['errors' => $errors]);
                    }

                } else {
                    $this->show('user/lostPassword',['errors' => $errors]);
                }

            } else {
                $errors['empty'] = 'Vous n\'avez renseigné aucun adresse email';
                $this->show('user/lostPassword',['errors' => $errors]);
            }

        }

        $this->show('user/lostPassword');
    }

    function resetPassword($token) {

        $userModel = new RecoveryTokenModel();
        $authModel = new AuthentificationModel();

        if(isset($token)) {

            $errors = [];
            $id = $userModel->getIdFromToken($token);

            if(!$id) {
                $this->redirectToRoute('user_login');
                exit;
            }

            if(isset($_POST['changePassword'])) {

                if (!empty($_POST['pass1'])) {

                    if (strlen($_POST['pass1']) < 8 || strlen($_POST['pass1']) > 30) {
                        $errors['pass1'] = true;
                    }
                }

                if (!empty($_POST['pass2'])) {

                    if (!empty($_POST['pass1']) && ($_POST['pass1'] !== $_POST['pass2'])) {

                        //IF PASSWORD IS FILLED, IT CONFIRMS
                        //BUT THE TWO ARE DIFFERENTS
                        $errors['different'] = true;
                    }

                    $pass = $_POST['pass2'];
                }

                if(empty($_POST['pass1'])) {
                    $errors['empty']['pass1'] = true;
                }

                if(empty($_POST['pass2'])) {
                    $errors['empty']['pass2'] = true;
                }

                if (count($errors) == 0) {

                    //HASHING PASSWORD
                    $password = $authModel -> hashPassword($pass,PASSWORD_DEFAULT);
                    $data = array('password' => $password);
                    $userModel->update($data,$id);

                    if($userModel->update($data,$id)) {
                        $userModel->setTable('recoveryTokens');
                        $userModel->setPrimaryKey('id_user');
                        $userModel->deleteToken($id);
                        $this->redirectToRoute('user_login');
                    }

                } else {
                    $this->show('user/resetPassword', ['errors' => $errors]);
                }
            }

        } else {
            $this->redirectToRoute('default_home');
        }
        
        $this->show('user/resetPassword');
    }
}


