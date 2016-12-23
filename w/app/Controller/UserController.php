<?php

namespace Controller;

use W\Controller\Controller;
use W\Model\UsersModel;
use \W\Security\AuthentificationModel;

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

                // On redirige sur une page sucess afin d'afficher les informations du compte de l'utilisateur
                $this->redirectToRoute('user_success');

            }else{
                $this->show('user/signup', ['errors' => $errors]);
            }

        }else {
            $this->show('user/signup');
        }
    }

    function sucess(){
        $authModel = new AuthentificationModel();
        if($authModel->getLoggedUser()) {
            $this->show('user/sucess');
        }else{
            $this->redirectToRoute('default_home');
        }
    }
}