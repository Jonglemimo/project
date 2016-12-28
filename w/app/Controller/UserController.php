<?php

namespace Controller;

use League\Url\Components\User;
use Services\PhpMailerService;
use W\Controller\Controller;
use \Model\UsersModel;
use W\Security\AuthentificationModel;


class UserController extends Controller {

    public function signin() {

        if(isset($_SESSION['user'])) {
            $this->redirectToRoute('default_home');
        }

        if (isset($_POST['signin'])) {

            $userModel = new UsersModel();
            $authModel = new AuthentificationModel();
            $errors = array();

            //CHECKING PSEUDO/MAIL
            if (empty($_POST['emailOrUsername'])) {
                $errors['emailOrUsername'] = true;
            } else {
                $emailOrUsername = trim($_POST['emailOrUsername']);
            }

            //CHECKING PASSWORD
            if (empty($_POST['password'])) {
                $errors['password'] = true;
            } else {
                $password = trim($_POST['password']);
            }

            //CHECKING IF IT EXIST IN DATABASE
            if(!empty($password) && !empty($emailOrUsername)) {
               $userId = $authModel->isValidLoginInfo($emailOrUsername, $password);
            }

            if(isset($userId)) {

                if($userId == 0) {
                   $errors['echec'] = true;
                   $this->show('user/signin', ['errors' => $errors]);
                }

                if ($userId != 0 && count($errors == 0)) {

                    //CONNEXION
                    $user = $userModel->find($userId);

                    //PUT USER IN SESSION: $_SESSION['user'] = $user
                    $authModel->logUserIn($user);

                    if(isset($_SESSION['user'])) {
                       $data = array('last_connection' => date('Y-m-d H:i:s'));
                       $userModel->update($data,$_SESSION['user']['id']);
                    }

                $this->redirectToRoute('default_home');

                }

            } else {
                $this->show('user/signin', ['errors' => $errors]);
            }

        } else {
            $this->show('user/signin');
        }
    }


    public function logout() {

        $authModel = new AuthentificationModel();
        $authModel->logUserOut();

        $this->redirectToRoute('default_home');
    }

    public function signup () {

        if(isset($_SESSION['user'])) {
            $this->redirectToRoute('default_home');
        }

        if(isset($_POST['signup'])) {

            $userModel = new UsersModel();
            $authModel = new AuthentificationModel();
            $errors = array();

            //CHECKING FIRSTNAME
            if (empty($_POST['firstname'])) {
                $errors['firstname']['empty'] = true;

            } elseif (strlen($_POST['firstname']) < 2) {
                $errors['firstname']['short'] = true;

            } else {
                $firstname = $_POST['firstname'];
            }

            //CHECKING LASTNAME
            if (empty($_POST['lastname'])) {
                $errors['lastname']['empty'] = true;

            } elseif (strlen($_POST['lastname']) < 2) {
                $errors['lastname']['short'] = true;

            } else {
                $lastname = $_POST['lastname'];
            }

            //CHECKING PSEUDO
            if (empty($_POST['username'])) {
                $errors['username']['empty'] = true;

            } else {
                $username = trim($_POST['username']);
                $username = htmlspecialchars($username, ENT_QUOTES);

                if ($userModel->usernameExists($_POST['username'])) {
                    $errors['username']['exist'] = true;
                }
            }

            //CHECKING PASSWORD
            if (empty($_POST['password'])) {
                $errors['password']['empty'] = true;

            } elseif (strlen($_POST['password']) < 5) {
                $errors['password']['short'] = true;

            } else {
                $password = $_POST['password'];
            }

            //CHECKING EMAIL
            if (empty($_POST['email'])) {
                $errors['email']['empty'] = true;

            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email']['wrong'] = true;

            } else {
                $email = $_POST['email'];

                if($userModel->emailExists($email)) {
                    $errors['email']['exist'] = true;
                }
            }

            //IF NO ERRORS, ADD IN DATABASE
            if(count($errors) === 0) {

                $userModel->setTable('users');
                $password = $authModel -> hashPassword($password,PASSWORD_DEFAULT);

                $user = $userModel ->insert([
                    'firstname'=> $firstname,
                    'lastname' => $lastname,
                    'email'    => $email,
                    'username' => $username,
                    'password' => $password,
                ]);

                //REDIRECT ON SUCCESS PAGE TO DISPLAY THE USER INFORMATIONS
                $this->show('user/success', ['user' => $user]);

            } else {
                $this->show('user/signup', ['errors' => $errors]);
            }
        } else {
            $this->show('user/signup');
        }
    }

    function success() {

        if(!isset($user)) {
            $this->redirectToRoute("user_signup");
        }
    }

    function userAdministration() {

        $userModel = new UsersModel();
        $authModel = new AuthentificationModel();

        if($authModel->getLoggedUser() == null) {
            $this->redirectToRoute('user_login');
        }

        $userModel->setTable('video');
        $videos = $userModel->findVideoById($_SESSION['user']['id'], 3);
        $comments = $userModel->findVideoByComment($_SESSION['user']['id']);

        if(isset($videos[0]['id'])) {
            $this->show('user/administration', ['videos' => $videos, 'comments' => $comments]);
        } else {
            $this->show('user/administration', ['videos' => 'Vous n\'avez pas de vidéo']);
        }
    }

    function userFullVideos() {

        $userModel = new UsersModel();
        $authModel = new AuthentificationModel();

        if($authModel->getLoggedUser() == null) {
            $this->redirectToRoute('user_login');
        }

        $userModel->setTable('video');

        $videos = $userModel->findVideoById($_SESSION['user']['id']);

        if(isset($videos[0]['id'])) {
            $this->show('user/fullVideo', ['videos' => $videos]);
        } else {
            $this->show('user/fullVideo', ['videos' => 'Vous n\'avez pas de vidéo']);
        }
    }

    function userFullComments() {

        $userModel = new UsersModel();
        $authModel = new AuthentificationModel();

        if($authModel->getLoggedUser() == null) {
            $this->redirectToRoute('user_login');
        }

        $userModel->setTable('video');

        $comments = $userModel->findVideoByComment($_SESSION['user']['id']);

        if(isset($comments[0]['content'])) {
            $this->show('user/fullComment', ['comments' => $comments]);
        } else {
            $this->show('user/fullComment', ['comments' => 'Vous n\'avez pas de vidéo']);
        }
    }

    function userInfo(){

        $userModel = new UsersModel();
        $authModel = new AuthentificationModel();
        $errors = array();

        if($authModel->getLoggedUser() == null){
            $this->redirectToRoute('user_login');
        }else {
            $user = $authModel->getLoggedUser();
            $this->show('user/userInfo', ['user' => $user]);
        }

        if (empty($_POST['username'])) {
            $errors['username']['empty'] = true;
        } else {
            $username = trim($_POST['username']);
            $username = htmlspecialchars($username, ENT_QUOTES);

            if ($userModel->usernameExists($_POST['username'])) {
                $errors['username']['exist'] = true;
            }
        }

        if(isset($_POST['signup'])) {
            $errors = array();

        //CHECKING EMAIL
        if (empty($_POST['email'])) {
            $errors['email']['empty'] = true;

        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email']['wrong'] = true;

        } else {
            $email = $_POST['email'];

            if($userModel->emailExists($email)) {
                $errors['email']['exist'] = true;
            }
        }

        //IF NO ERRORS, ADD IN DATABASE
        if(count($errors) === 0) {

            $userModel->setTable('users');

            $userModel ->insert([
                'email'    => $email,
                'username' => $username,
            ]);
        } else {
            $this->show('user/userInfo', ['errors' => $errors]);
        }
    } else {
            $this->show('user/signup');
        }
    }
}