<?php

namespace Controller;

use W\Controller\Controller;
use W\Model\UsersModel;

class UserController extends Controller
{

    public function signin()
    {

        if (isset($_POST['signin'])) {

            $authModel = new AuthentificationModel();
            $userModel = new UsersModel();
            $errors = array();

            //vérification du pseudo/mail

            if (empty($_POST['emailorPseudo'])) {
                $errors['email'] = true;
            } else {
                $emailorPseudo = trim($_POST['emailorPseudo']);
            }

            //vérification du password

            if (empty($_POST['password'])) {
                $errors['password'] = true;
            } else {
                $password = trim($_POST['password']);
            }

            //vérification on vérifie qu'il existe en base de donné

            $userId = $authModel->isValidLoginInfo($emailorPseudo, $password);

            if($userId == 0){
                $errors['login']['wrong'] = true;
            }

            if ($userId > 0 && count($errors == 0)) {

                // Connexion
                $user = $userModel->find($userId);

                // Placer user en session : $_SESSION['user'] = $user
                $authModel->logUserIn($user);
                $this->redirectToRoute('default_home');
            } else {
                // Echec de la connexion
                $errors['echec'] = true;
                $this->show('user/login', ['errors' => $errors]);
            }
        } else {
            $this->show('user/signin');

        }
    }

    public function signup ()
    {
        if(isset($_POST['signup'])) {

            $userModel = new UsersModel();
            $authModel = new AuthentificationModel();
            $errors = array();

            //vérification du pseudo

            if (empty($_POST['pseudo'])) {
                $errors['pseudo']['empty'] = true;
            } else {
                $pseudo = trim($_POST['pseudo']);
                $pseudo = htmlspecialchars($pseudo, ENT_QUOTES);

                if ($userModel->usernameExists($_POST['pseudo'])) {
                    $errors['pseudo']['exist'] = true;
                }
            }

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

            if(count($errors > 0)){

                $password = $authModel -> hashPassword($password,PASSWORD_DEFAULT);
                $userModel ->insert([
                    'firstname'=> $firstname,
                    'lastname' => $lastname,
                    'email'    => $email,
                    'pseudo' => $pseudo,
                    'password' => $password,


                ]);

                // On redirige sur une page sucess afin d'afficher les informations du compte de l'utilisateur

                $this->redirect('user/sucess');
            }

        }else {
            $this->show('user/signup');
        }
    }
}