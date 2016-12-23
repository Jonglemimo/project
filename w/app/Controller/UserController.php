<?php

namespace Controller;



use Services\PhpMailerService;
use W\Controller\Controller;
use \Model\UsersModel;
use W\Security\AuthentificationModel;


class UserController extends Controller
{

    public function signin()
    {

        if (isset($_POST['signin'])) {

            $userModel = new UsersModel();
            $authModel = new AuthentificationModel();
            $errors = array();

            //vérification du pseudo/mail

            if (empty($_POST['emailOrUsername'])) {
                $errors['emailOrUsername'] = true;
            } else {
                $emailOrUsername = trim($_POST['emailOrUsername']);
            }

            //vérification du password

            if (empty($_POST['password'])) {
                $errors['password'] = true;
            } else {
                $password = trim($_POST['password']);
            }

            //vérification on vérifie qu'il existe en base de donné

           if(!empty($password) && !empty($emailOrUsername)){
               $userId = $authModel->isValidLoginInfo($emailOrUsername, $password);
           }

           if(isset($userId)){

               if($userId == 0){
                   $errors['echec'] = true;
                   $this->show('user/signin', ['errors' => $errors]);
               }

               if ($userId != 0 && count($errors == 0)) {

                   // Connexion
                   $user = $userModel->find($userId);

                   // Placer user en session : $_SESSION['user'] = $user
                   $authModel->logUserIn($user);

                   if(isset($_SESSION['user'])){
                       $data = array('last_connection' => date('Y-m-d H:i:s'));
                       $userModel->update($data,$_SESSION['user']['id']);
                   }
                   $this->redirectToRoute('default_home');
               }
           }else{
               $this->show('user/signin', ['errors' => $errors]);
           }
        }else {
            $this->show('user/signin');
        }
    }

    public function logout(){
        $authModel = new AuthentificationModel();
        $authModel->logUserOut();
        $this->redirectToRoute('default_home');

    }

    public function signup ()
    {
        if(isset($_POST['signup'])) {


            $userModel = new UsersModel();
            $authModel = new AuthentificationModel();
            $errors = array();


            //vérification firstname

            if (empty($_POST['firstname'])) {
                $errors['firstname']['empty'] = true;

            } elseif (strlen($_POST['firstname']) < 5) {
                $errors['firstname']['short'] = true;
            } else {
                $firstname = $_POST['firstname'];
            }

            //vérification lastname

            if (empty($_POST['lastname'])) {
                $errors['lastname']['empty'] = true;

            } elseif (strlen($_POST['lastname']) < 5) {
                $errors['lastname']['short'] = true;
            } else {
                $lastname = $_POST['lastname'];
            }

            //vérification du pseudo

            if (empty($_POST['username'])) {
                $errors['username']['empty'] = true;
            } else {
                $username = trim($_POST['username']);
                $username = htmlspecialchars($username, ENT_QUOTES);

                if ($userModel->usernameExists($_POST['username'])) {
                    $errors['username']['exist'] = true;
                }
            }


            //vérification password

            if (empty($_POST['password'])) {
                $errors['password']['empty'] = true;

            } elseif (strlen($_POST['password']) < 5) {
                $errors['password']['short'] = true;
            } else {
                $password = $_POST['password'];
            }

            //vérification email

            if (empty($_POST['email'])) {
                $errors['email']['empty'] = true;

            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email']['wrong'] = true;

            } else {
                $email = $_POST['email'];

                if($userModel->emailExists($email)){
                    $errors['email']['exist'] = true;
                }
            }

            //si aucune erreur, on ajoute en BDD

            if(count($errors) === 0){

                $userModel->setTable('users');

                $password = $authModel -> hashPassword($password,PASSWORD_DEFAULT);

                $userModel ->insert([
                    'firstname'=> $firstname,
                    'lastname' => $lastname,
                    'email'    => $email,
                    'username' => $username,
                    'password' => $password
                ]);

                // On redirige sur une page success afin d'afficher les informations du compte de l'utilisateur
                $this->redirectToRoute('user_success');

            }else{
                $this->show('user/signup', ['errors' => $errors]);
            }

        }else {
            $this->show('user/signup');
        }
    }

    function success()
    {
        $this->show('user/success');
    }

    function userAdministration(){
        $userModel = new UsersModel();
        $authModel = new AuthentificationModel();

        if($authModel->getLoggedUser() == null){
            $this->redirectToRoute('user_login');
        }
        $userModel->setTable('video');

        $videos = $userModel->findVideoById($_SESSION['user']['id'], 3);
        $comments = $userModel->findVideoByComment($_SESSION['user']['id']);

        if(isset($videos[0]['id'])){
            $this->show('user/administration', ['videos' => $videos, 'comments' => $comments]);
        }else{
            $this->show('user/administration', ['videos' => 'Vous n\'avez pas de vidéo']);
        }
    }

    function lostPassword ()
    {
        $mail = new PhpMailerService();
        $userModel = new UsersModel();

        if (isset($_POST['reset-password'])) {
            $errors = array();

            // Vérifications sur les champs
            if (!empty($_POST['mail'])) {

                $userMail = $_POST['mail'];

                // On teste la validité du mail
                $isMailValid = filter_var($userMail, FILTER_VALIDATE_EMAIL);
                if (!$isMailValid) {
                    $errors['mail'] = true;
                }
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

                } else
                    //echo 'cette adresse Email n\'existe pas';
                $errors['wrongEmail'] = true;
            }$this->show('user/lostPassword',['errors' => $errors]);
        }
        $this->show('user/lostPassword');
    }

    function resetPassword($token){
        $userModel = new UsersModel();
        $authModel = new AuthentificationModel();
        if(isset($token)){
            $errors = [];
            $id = $userModel->getIdFromToken($token);
            if(!$id){
                $this->redirectToRoute('user_login');
                exit;
            }
            if(isset($_POST['changePassword'])){
                if (!empty($_POST['pass1'])) {
                    if (strlen($_POST['pass1']) < 8 || strlen($_POST['pass1']) > 30) {
                        $errors['pass1'] = true;
                    }
                }

                if (!empty($_POST['pass2'])) {
                    if (!empty($_POST['pass1']) && ($_POST['pass1'] !== $_POST['pass2'])) {

                        // Si le mot de passe a été rempli, la confirmation aussi,
                        // mais les deux sont différents
                        $errors['pass2'] = 'true';
                    }
                        $pass = $_POST['pass2'];
                }
                if (count($errors) == 0) {
                        // Hash du mot de passe
                        $password = $authModel -> hashPassword($pass,PASSWORD_DEFAULT);
                        $data = array('password' => $password);
                        $userModel->update($data,$id);
                        if($userModel->update($data,$id)){
                            $userModel->setTable('recoveryTokens');
                            $userModel->setPrimaryKey('id_user');
                            $userModel->deleteToken($id);
                            $this->redirectToRoute('user_login');
                        }

                }else{
                    $this->show('user/resetPassword', ['errors' => $errors]);
                }
            }
        }else{
            $this->redirectToRoute('default_home');
        }
        $this->show('user/resetPassword');
    }

    function userFullVideos(){
        $userModel = new UsersModel();
        $authModel = new AuthentificationModel();

        if($authModel->getLoggedUser() == null){
            $this->redirectToRoute('user_login');
        }

        $userModel->setTable('video');

        $videos = $userModel->findVideoById($_SESSION['user']['id']);

        if(isset($videos[0]['id'])){
            $this->show('user/fullVideo', ['videos' => $videos]);
        }else{
            $this->show('user/fullVideo', ['videos' => 'Vous n\'avez pas de vidéo']);
        }
    }

    function userFullComments(){
        $userModel = new UsersModel();
        $authModel = new AuthentificationModel();

        if($authModel->getLoggedUser() == null){
            $this->redirectToRoute('user_login');
        }

        $userModel->setTable('video');

        $comments = $userModel->findVideoByComment($_SESSION['user']['id']);

        if(isset($comments[0]['content'])){
            $this->show('user/fullComment', ['comments' => $comments]);
        }else{
            $this->show('user/fullComment', ['comments' => 'Vous n\'avez pas de vidéo']);
        }
    }
}