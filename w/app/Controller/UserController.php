<?php

namespace Controller;

use \Model\UsersModel;
use Services\PhpMailerService;
use W\Security\AuthentificationModel;
use Services\ImageManagerService;

class UserController extends \Controller\DefaultController {

    private $usersFolder = false;
    private $uploadTmp   = false;
    private $userModel   = false;
    private $authModel   = false;


    public function __construct()
    {

        $ds = DIRECTORY_SEPARATOR;
        $this->uploadTmp = dirname(dirname(dirname(__FILE__))).$ds.'tmp';
        $this->userModel = new UsersModel();
        $this->authModel = new AuthentificationModel();

        if(isset($_SESSION['user'])){
            $this->usersFolder = dirname(dirname(dirname(__FILE__))).$ds.'public'.$ds.'assets'.$ds.'users'.$ds.$_SESSION['user']['id'];
            if(!file_exists($this->usersFolder)){
                mkdir($this->usersFolder,0755);
            }
        }
    }

    public function signin() {
        if(isset($_SESSION['user'])) {
            $this->redirectToRoute('default_home');
        }

        if (isset($_POST['signin'])) {

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
               $userId = $this->authModel->isValidLoginInfo($emailOrUsername, $password);
            }

            if(isset($userId)) {

                if($userId == 0) {
                   $errors['echec'] = true;
                   $this->show('user/signin', ['errors' => $errors]);
                }

                if ($userId != 0 && count($errors == 0)) {

                    //CONNEXION
                    $this->userModel->setTable('users');
                    $user = $this->userModel->find($userId);

                    //PUT USER IN SESSION: $_SESSION['user'] = $user
                    $this->authModel->logUserIn($user);

                    if(isset($_SESSION['user'])) {

                        $this->userModel->update([
                            'last_connection' => date('Y-m-d H:i:s')
                        ],$_SESSION['user']['id']);
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

        $this->authModel->logUserOut();

        $this->redirectToRoute('default_home');
    }

    public function signup () {

        if(isset($_SESSION['user'])) {
            $this->redirectToRoute('default_home');
        }

        if(isset($_POST['signup'])) {

            $errors = array();

            //CHECKING FIRSTNAME
            if (empty($_POST['firstname'])) {
                $errors['firstname']['empty'] = true;

            } elseif (strlen($_POST['firstname']) < 2) {
                $errors['firstname']['short'] = true;

            } else {

                $firstname = trim($_POST['firstname']);
                $firstname = $this->filterString($firstname);
                $firstname = htmlspecialchars($firstname, ENT_QUOTES);
            }

            //CHECKING LASTNAME
            if (empty($_POST['lastname'])) {
                $errors['lastname']['empty'] = true;

            } elseif (strlen($_POST['lastname']) < 2) {
                $errors['lastname']['short'] = true;

            } else {

                $lastname = trim($_POST['lastname']);
                $lastname = $this->filterString($lastname);
                $lastname = htmlspecialchars($lastname, ENT_QUOTES);
            }

            //CHECKING PSEUDO
            if (empty($_POST['username'])) {
                $errors['username']['empty'] = true;

            } else {
                $username = trim($_POST['username']);
                if ($this->userModel->usernameExists(trim($username))) {
                    $errors['username']['exist'] = true;
                }else{
                    $username = $this->filterString($username);
                    $username = htmlspecialchars($username, ENT_QUOTES);
                }
            }


            //CHECKING EMAIL
            if (empty($_POST['email'])) {
                $errors['email']['empty'] = true;

            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email']['wrong'] = true;

            } else {
                $email = $_POST['email'];

                if($this->userModel->emailExists($email)) {
                    $errors['email']['exist'] = true;
                }
            }

            //CHECKING PASSWORD

            if (!empty($_POST['pass1'])) {

                if (strlen($_POST['pass1']) < 5 || strlen($_POST['pass1']) > 30) {
                    $errors['lenght']['pass1'] = 'Votre mot de passe doit être compris entre 5 et 30 caractères';
                }
            }else{
                $errors['empty']['pass1'] = 'Vous devez remplir le champ mot de passe';
            }

            if (!empty($_POST['pass2'])) {

                if (!empty($_POST['pass1']) && ($_POST['pass1'] !== $_POST['pass2'])) {

                    //IF PASSWORD IS FILLED, IT CONFIRMS
                    //BUT THE TWO ARE DIFFERENTS
                    $errors['pass']['different'] = 'Les mots de passes ne sont pas identiques';
                }
            }

            if(!empty($_POST['pass1']) && empty($_POST['pass2'])) {
                $errors['empty']['pass'] = 'Vous devez remplir le champ confirmation du mot de passe';

            }

            if(empty($_POST['pass1']) && !empty($_POST['pass2'])) {
                $errors['empty']['pass'] = 'Vous devez remplir le champ nouveau mot de passe';

            }
            //

            //IF NO ERRORS, ADD IN DATABASE
            if(count($errors) === 0) {

                $this->userModel->setTable('users');
                if(isset($_POST['pass2'])) {
                    $pass = $_POST['pass2'];
                }
                $password = $this->authModel->hashPassword($pass,PASSWORD_DEFAULT);


                $user = $this->userModel->insert([

                    'firstname'=> $firstname,
                    'lastname' => $lastname,
                    'email'    => $email,
                    'username' => $username,
                    'password' => $password,
                ]);


                //REDIRECT ON SUCCESS PAGE TO DISPLAY THE USER INFORMATIONS
                $data =  array(
                    'id'       => $user['id'],
                    'firstname'=> $firstname,
                    'lastname' => $lastname,
                    'email'    => $email,
                    'username' => $username,
                    'date_created' => $user['date_created'],
                    'last_connection' => $user['last_connection']
                );
                $this->authModel->logUserIn($data);

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

        if($this->authModel->getLoggedUser() == null) {
            $this->redirectToRoute('user_login');
        }

        $this->userModel->setTable('video');
        $totalVideos = (int)$this->userModel->getTotalVideos($_SESSION['user']['id'])['total'];
        $videos = $this->userModel->findVideoById($_SESSION['user']['id'],$totalVideos - 4,4);
        $comments = $this->userModel->findVideoByComment($_SESSION['user']['id']);

        $this->userModel->setTable('users');
        $user = $this->userModel->find($_SESSION['user']['id']);

        if(isset($videos[0]['id'])) {
            if(isset($comments[0]['content'])){
                $this->show('user/administration', ['comments' => $comments,'videos' => $videos, 'user' => $user]);
            } else {
                $this->show('user/administration', ['comments' => 'Vous n\'avez pas de commentaire','videos' => $videos,'user' => $user]);
            }
        } else {
            if(isset($comments[0]['content'])){
                $this->show('user/administration', ['comments' => $comments,'videos' => 'Vous n\'avez pas de vidéo', 'user' => $user]);
            } else {
                $this->show('user/administration', ['comments' => 'Vous n\'avez pas de commentaire','videos' => 'Vous n\'avez pas de vidéo', 'user' => $user]);
            }
        }



    }

    function userFullVideos($page = false) {

        if($this->authModel->getLoggedUser() == null) {
            $this->redirectToRoute('user_login');
        }

        $this->userModel->setTable('video');

        $totalVideos = (int)$this->userModel->getTotalVideos($_SESSION['user']['id'])['total'];
        $totalPages = ceil($totalVideos/$this->nbElements);

        if($page !== false){
            $page = (int)$page;
        }

        if($page === 0){
            $this->showNotFound();
        }else if($page === 1){

            $this->redirectToRoute('user_video');
        }else if($page > $totalPages){
            $this->showNotFound();
        }

        if($page === false){
            $page = 1;
        }

        $offset  = $page * $this->nbElements - $this->nbElements;


        $videos = $this->userModel->findVideoById($_SESSION['user']['id'], $offset,$this->nbElements);

        if(count($videos) > 0 ) {
            $this->show('user/fullVideo', ['videos' => $videos, 'pagination' => array('total' => $totalPages, 'current' => $page)]);
        } else {
            $this->show('user/fullVideo', ['videos' => 'Vous n\'avez pas de vidéo']);
        }
    }

    function userFullComments() {

        if($this->authModel->getLoggedUser() == null) {
            $this->redirectToRoute('user_login');
        }

        $this->userModel->setTable('video');

        $comments = $this->userModel->findVideoByComment($_SESSION['user']['id']);

        if(count($comments) > 0) {
            $this->show('user/fullComment', ['comments' => $comments]);

        }else{
            $this->show('user/fullComment', ['comments' => 'Vous n\'avez pas de commentaire']);

        }
    }

    function userInfo(){

        $imageResize = new ImageManagerService();

        if($this->authModel->getLoggedUser() == null){
            $this->redirectToRoute('user_login');
        }else{
            $this->userModel->setTable('users');
            $user = $this->userModel->find($_SESSION['user']['id']);
        }

        if(isset($_POST['modifyInfo'])){
           $returnValidate = $this->validateUserInfo($_POST['modifyInfo']);
        }else{
            $this->show('user/userInfo', ['user' => $user]);
        }
        //IF NO ERRORS, ADD IN DATABASE
        if(count($returnValidate['errors']) == 0) {

            if(isset($_POST['pass2']) && !empty($_POST['pass2'])){
                $pass = $_POST['pass2'];
            }


            if(!empty($returnValidate['temporaryImg'])){
                $this->userModel->setTable('users');
                $avatar = $this->userModel->find($_SESSION['user']['id']);
                if(!empty($avatar['avatar'])){
                    unlink($this->usersFolder.DIRECTORY_SEPARATOR.$avatar['avatar']);
                }
                if(file_exists($returnValidate['temporaryImg'])){
                    $imageInfo = pathinfo(basename($returnValidate['temporaryImg']));
                    $output = $this->usersFolder.DIRECTORY_SEPARATOR;
                    $outputAvatar = $output.$imageInfo['filename'].'.'.$imageInfo['extension'];
                    $imageResize->resize($returnValidate['temporaryImg'] ,null, 120, 120,false, $outputAvatar, false);
                    unlink($returnValidate['temporaryImg']);
                    $insertAvatar = $this->userModel->update([
                        'avatar'   => $imageInfo['filename'].'.'.$imageInfo['extension']
                    ],$user['id']);

                }
            }


            if($returnValidate['username'] == $user['username'] && $returnValidate['email'] == $user['email'] && empty($pass) && empty($insertAvatar)){
                $this->show('user/userInfo' ,['user' => $user, 'errors' => $returnValidate['errors'], 'status' => 'Vos informations sont identiques']);
            }

            if(isset($pass)){
                $password = $this->authModel -> hashPassword($pass,PASSWORD_DEFAULT);
                $this->userModel->update([
                    'email'    => $returnValidate['email'],
                    'username' => $returnValidate['username'],
                    'password' => $password,

                ],$user['id']);

                $_SESSION['user']['username'] = $returnValidate['username'];
                $_SESSION['user']['email'] = $returnValidate['email'];


            }else if ($returnValidate['username'] == $user['username'] && $returnValidate['email'] == $user['email'] && isset($pass)) {
                $password = $this->authModel -> hashPassword($pass,PASSWORD_DEFAULT);
                $this->userModel->update([
                    'password' => $password
                ],$user['id']);
            }else{

                $this->userModel->update([
                    'email'    => $returnValidate['email'],
                    'username' => $returnValidate['username'],


                ],$user['id']);

                $_SESSION['user']['username'] = $returnValidate['username'];
                $_SESSION['user']['email'] = $returnValidate['email'];
            }

            $user = $this->userModel->find($_SESSION['user']['id']);

            $this->show('user/userInfo', ['success' => 'Vos informations ont bien été modifiées', 'user' => $user]);

        } else {
            if(!isset($_POST['pass1']) && !isset($_POST['pass2'])){
                $this->show('user/userInfo', ['errors' => $returnValidate['errors'],'user' => $user]);
            }else if(isset($_POST['pass1']) || isset($_POST['pass2'])){
                $pass = array(
                    'pass1' => $_POST['pass1'],
                    'pass2' => $_POST['pass2']
                );
                $this->show('user/userInfo', ['errors' => $returnValidate['errors'],'user' => $returnValidate, 'pass' => $pass]);
            }else{
                $this->show('user/userInfo', ['errors' => $returnValidate['errors'],'user' => $user]);

            }
        }
    }

    private function validateUserInfo()
    {

        $errors = array();
        $videoController = new \Controller\VideoController();


        if (empty($_POST['username'])) {
            $errors['username']['empty'] = 'Votre pseudonyme ne peut pas être vide';
        } else {
            $filterString = $this->filterString($_POST['username']);
            $username = htmlspecialchars(trim($filterString));

            if ($this->userModel->usernameExists($username) && $_SESSION['user']['username'] != $_POST['username']) {
                $errors['username']['exist'] = 'Ce pseudonyme existe déjà';
            }
        }

        //CHECKING EMAIL
        if (empty($_POST['email'])) {
            $errors['email']['empty'] = 'L\'email ne peut pas être vide';

        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email']['wrong'] = 'L\'email n\'est pas valide';

        } else {
            $email = htmlspecialchars($_POST['email']);
        }
        // checking password

        if (!empty($_POST['pass1'])) {

            if (strlen($_POST['pass1']) < 8 || strlen($_POST['pass1']) > 30) {
                $errors['lenght']['pass1'] = 'Votre mot de passe doit être compris entre 8 et 30 caractères';

            }
        }
        if (!empty($_POST['pass2'])) {

            if (!empty($_POST['pass1']) && ($_POST['pass1'] !== $_POST['pass2'])) {

                //IF PASSWORD IS FILLED, IT CONFIRMS
                //BUT THE TWO ARE DIFFERENTS
                $errors['pass']['different'] = 'Les mots de passes ne sont pas identiques';
            }
        }

        if (!empty($_POST['pass1']) && empty($_POST['pass2'])) {
            $errors['empty']['pass'] = 'Vous devez remplir le champ confirmation du mot de passe';

        }

        if (empty($_POST['pass1']) && !empty($_POST['pass2'])) {
            $errors['empty']['pass'] = 'Vous devez remplir le champ nouveau mot de passe';

        }

        //checking imageUser

        if (!empty($_FILES['picture']['tmp_name'])) {
            if ($videoController->getType($_FILES['picture']['tmp_name']) != 'image') {
                $errors['picture'] = 'Le fichier n\'est pas une image';
                unlink($_FILES['picture']['tmp_name']);
            }else{
                $temporaryImg = $videoController->handleDuplicate($this->uploadTmp . DIRECTORY_SEPARATOR . $_FILES['picture']['name']);
                move_uploaded_file($_FILES['picture']['tmp_name'], $temporaryImg);
            }
        }

        return array('errors' => $errors, 'email' => isset($email) ? $email : null, 'username' => isset($username) ? $username : null,'temporaryImg' => isset($temporaryImg) ? $temporaryImg : null);

    }

    private function filterString ($string){
        $caracteres = array('a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
        'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
        'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
        'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
        'Œ' => 'oe', 'œ' => 'oe',
        '$' => 's');

        $string = strtr($string, $caracteres);
        $string = preg_replace('#[^A-Za-z0-9]+#', '-', $string);
        $string = trim($string, '-');
        $string = strtolower($string);

        return $string;
    }

    public function contact(){

        if($user = $this->authModel->getLoggedUser());

        if(isset($_POST['contact'])){
         $returnFormContact = $this->validateContact($_POST['contact']);

         if(count($returnFormContact['errors']) == 0){

            $this->send($returnFormContact,$user);

         }else{
             $this->show('user/contact', ['form' => $returnFormContact,'user' => isset($user)?$user:null]);
         }
       }else{
           $this->show('user/contact',['user' => isset($user)?$user:null]);
       }

    }

    private function validateContact(){

        $errors = array();

        if(!empty($_POST['subject'])){
            $subject = trim($_POST['subject']);
            $subject = htmlspecialchars($subject);
        }else{
            $errors['subject']['empty'] = 'Votre sujet ne peut pas être vide';
        }

        if(!empty($_POST['content'])){
            $content = trim($_POST['content']);
            $content = htmlspecialchars($content);

        }else{
            $errors['content']['empty'] = 'Votre message ne peut pas être vide';
        }


        if(!empty($_POST['email'])){
            $email = trim($_POST['email']);
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errors['email']['wrong'] = 'Cette adresse email n\'est pas valide';
            }
        }else{
            $errors['email']['empty'] = 'Votre message ne peut pas être vide';
        }

        return array('errors' => $errors, 'subject' => isset($subject)? $subject : null, 'content' => isset($content)? $content : null,'email' => isset($email)?$email:null);
    }

    private function send($returnFormContact, $user){
        $mail = new PhpMailerService();
        $this->userModel->setTable('users');
        $subject = 'Tutomotion : '.$returnFormContact['subject'];

        if($this->authModel->getLoggedUser()){

            $bodyHtml = 'Bonjour, <br>'.$user['firstname'].' '.$user['lastname'].' (' .ucfirst($user['username']). ') vous a envoyé un email, voici son contenu : <br><br> '.ucfirst($returnFormContact['content']). '<br><br>Voici l\'adresse mail de '.$user['firstname']. ' '.$user['lastname'] .' : '.$returnFormContact['email'] ;
            $bodyPlain = 'Bonjour, '.$user['firstname'].' '.$user['lastname'].' (' .ucfirst($user['username']). ') vous a envoyé un email, vpoci spn contenu :  '.ucfirst($returnFormContact['content']). ' Voici l\'adresse mail de '.$user['firstname']. ' '.$user['lastname'] .' : '.$returnFormContact['email'] ;
        }else{

            $bodyHtml = 'Bonjour, <br> L\'utilisateur ayant l\'adresse email : '.$returnFormContact['email']. ' vous a envoyé le message suivant : <br><br>'.$returnFormContact['content'].'<br><br> Cordialement, Tutomotion';
            $bodyPlain = 'Bonjour, <br> L\'utilisateur ayant l\'adresse email : '.$returnFormContact['email']. ' vous a envoyé le message suivant :  '.$returnFormContact['content'].' Cordialement, Tutomotion';
        }

        if($mail->sendMail('victor.tarrieu@yahoo.fr', $subject, $bodyHtml, $bodyPlain)){
            $this->show('user/contact', ['success' => 'Votre message a bien été envoyé']);
        }else{
            $this->show('user/contact', ['fail' => 'il y a eu un problème lors de l\'envoi de votre message']);

        }
    }
}