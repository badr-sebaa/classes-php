<?php

class UserPDO
{

    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    private $bdd;
      //Constructeur sans paramètre
    public function __construct()
    {
    }
    // Créée l’utilisateur en BDD et retourne un tableau contenant l’ensembles des informations de ce même utilisateur
    public function register($login, $password, $email, $firstname, $lastname)
    {
        
            $db_user = 'root';
            $db_pass = '';
            $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
            
        $stmt = $dbh->prepare("INSERT INTO `utilisateurs` (`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login', '$password', '$email', '$firstname', '$lastname'");
        $stmt->execute();
        echo 'Inscrit';
    }
    // Connecte l’utilisateur, donne aux attributs de la classe les valeurs correspondantes à celles de l’utilisateur connecté
    public function connect($login, $password)
    {

        $db_user = 'root';
        $db_pass = '';
        $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
        $stmt = $dbh->prepare("SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'");
        $stmt->execute();

        if($stmt->rowCount() == 1 ){
            $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($req as $value){
            $id = $value['id'];
            $login = $value['login'];
            $email = $value['email'];
            $firstname = $value['firstname'];
            $lastname = $value['lastname'];
            
            $this->id = $id;
            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['id'] = $id;
            echo 'Connecter';
            }
        }
        else{
            echo 'Introuvable';
        }   
        
    }
    
    // Déconnecte l’utilisateur
    public function disconnect()
    {
        session_start();
        session_destroy();
        echo 'Déconnecter';
    }

    // Supprime ET déconnecte un user
    public function delete($login)
    {
        $db_user = 'root';
        $db_pass = '';
        $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
        $stmt = $dbh->prepare("DELETE FROM `utilisateurs` WHERE `login`='$login'");
        $stmt->execute();
        
        echo 'Supprimer';
    } 
    // MAJ attributs de l’objet, modifie informations en BDD
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $user = $_SESSION['id'];
        $db_user = 'root';
        $db_pass = '';
        $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
        $stmt = $dbh->prepare("UPDATE utilisateurs SET login='$login', password ='$password',  email ='$email', firstname ='$firstname', lastname ='$lastname' WHERE id = '$user'");
        $stmt->execute();
        echo 'Modifier';
    }
    // Savoir si un utilisateur est connecté ou non
    public function isConnected()
    {
        $result = null;
        if(isset($_SESSION['login']))
        {
            $result = true;
        }
        else
        {
            $result = false;
        }

        return $result;
    }
    // Tableau contenant l’ensemble des informations de l’utilisateur
    public function getAllInfos()
    {
        $user = $_SESSION['id'];
        $db_user = 'root';
        $db_pass = '';
        $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
        $stmt = $dbh->prepare("SELECT * FROM utilisateurs WHERE id = '$user'");
        $stmt->execute();
        $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($req as $value){
            $login = $value['login'];
            $password = $value['password'];
            $email = $value['email'];
            $firstname = $value['firstname'];
            $lastname = $value['lastname'];
        }
        

        return array($login, $password, $email, $firstname, $lastname);
    }
// Autre façon

    // Retourne Login de l’utilisateur
    public function getLogin()
    {
        $user = $_SESSION['id'];
        $db_user = 'root';
        $db_pass = '';
        $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
        $stmt = $dbh->prepare("SELECT login FROM utilisateurs WHERE id = '$user'");
        $stmt->execute();
        $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($req as $value){
            $login = $value['login'];
        }
        return $login;
    }

    // Retourne Email de l'utilisateur
    public function getEmail()
    {
        $user = $_SESSION['id'];
        $db_user = 'root';
        $db_pass = '';
        $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
        $stmt = $dbh->prepare("SELECT email FROM utilisateurs WHERE id = '$user'");
        $stmt->execute();
        $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($req as $value){
            $email = $value['email'];
        }
        return $email;
    }

    // Retourne prenom de l'utilsateur
    public function getFirstname()
    {
        $user = $_SESSION['id'];
        $db_user = 'root';
        $db_pass = '';
        $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
        $stmt = $dbh->prepare("SELECT firstname FROM utilisateurs WHERE id = '$user'");
        $stmt->execute();
        $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($req as $value){
            $firstname = $value['firstname'];
        }
        return $firstname;
    }

     //Retourne Nom de l'utilisateur
    public function getLastname()
    {
        $user = $_SESSION['id'];
        $db_user = 'root';
        $db_pass = '';
        $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
        $stmt = $dbh->prepare("SELECT lastname FROM utilisateurs WHERE id = '$user'");
        $stmt->execute();
        $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($req as $value){
            $lastname = $value['lastname'];
        }
        
        return $lastname;
    }

}

?>
