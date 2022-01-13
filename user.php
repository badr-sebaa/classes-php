<?php

class User
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    protected $bdd;

    //Constructeur sans paramètre
    public function __construct()
    {
        $this->bdd = mysqli_connect('localhost', 'root', '', 'classes');
        mysqli_set_charset($this->bdd, 'UTF8');

        return $this->bdd;
    }

    // Créée l’utilisateur en BDD et retourne un tableau contenant l’ensembles des informations de ce même utilisateur
    public function register($login, $password, $email, $firstname, $lastname)
    {
        $sqlVerif = "SELECT * FROM users WHERE login = '$login'";
        $select = mysqli_query($this->bdd, $sqlVerif);

        if (mysqli_num_rows($select))
        {
            return "Ce login existe déjà, choisissez en un autre";
        } 
        else 
        {
            $sql = "INSERT INTO `users`(`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login','$password','$email','$firstname','$lastname')";
            $requete = mysqli_query($this->bdd, $sql);
            return $array = [
                "login" => $login,
                "password" => $password,
                "email" => $email,
                "firstname" => $firstname,
                "lastname" => $lastname,
            ];
        }
    }

    // Connecte l’utilisateur, donne aux attributs de la classe les valeurs correspondantes à celles de l’utilisateur connecté.
    public function connect($login, $password)
    {

        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        $stmt = mysqli_query($bdd, "SELECT * FROM users WHERE login = '$login' AND password = '$password'");
        $count = mysqli_num_rows($stmt);
        $req = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        

        if($count==1){
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
                $_SESSION['user_id'] = $id;
                echo 'Connecter';
            }
        }
        else
        {
            echo 'Introuvable';
        }   
    }

    // Déconnecte l’utilisateur
    public function disconnect()
    {
        session_destroy();
        echo 'Déconnecter';
    }

    // Supprime ET déconnecte un user
    public function delete($login)
    {
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        mysqli_query($bdd, "DELETE FROM `users` WHERE `login`='$login'");
        echo 'Supprimer';
    } 
    
    // MAJ attributs de l’objet, modifie informations en BDD
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $user = $_SESSION['user_id'];
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        mysqli_query($bdd, "UPDATE users SET login='$login', password ='$password',  email ='$email', firstname ='$firstname', lastname ='$lastname' WHERE id = '$user'");
        echo 'Modifier';
    }

    // Savoir si un utilisateur est connecté ou non
    public function isConnected()
    {
        if (!empty($_SESSION['user_id'])) {
            return true;
        } 
        else {
            return false;
        }
    }

    // Tableau contenant l’ensemble des informations de l’utilisateur
    public function getAllInfo()
    {
        $user = $_SESSION['user_id'];
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        $stmt = mysqli_query($bdd, "SELECT * FROM users WHERE id = '$user'");
        $req = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        foreach($req as $value){
            $login = $value['login'];
            $password = $value['password'];
            $email = $value['email'];
            $firstname = $value['firstname'];
            $lastname = $value['lastname'];

            return array($login, $password, $email, $firstname, $lastname);
        }
    }

    // Retourne Login de l’utilisateur
    public function getLogin()
    {
    return $this->login;
    }

    // Retourne Email de l'utilisateur
    public function getEmail()
    {
     return $this->email;
    }
    
    // Retourne prenom de l'utilsateur
    public function getFirstname()
    {
     return $this->firstname;
    }

    //Retourne Nom de l'utilisateur
    public function getLastname()
    {
     return $this->lastname;
    }
}