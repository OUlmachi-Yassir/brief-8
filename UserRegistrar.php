<?php
require('User.php');

class UserRegistrar
{
    private $user;
    private $conn; 

    public function __construct($conn)
    {
        $this->user = new User($conn);
        $this->conn = $conn;
    }

    public function isEmailTaken($email)
    {
        $email = mysqli_real_escape_string($this->conn, $email);
        $query = "SELECT * FROM `utilisateur` WHERE email = '$email'";
        $result = mysqli_query($this->conn, $query);

        return mysqli_num_rows($result) > 0;
    }
    
    public function registerUser($username, $surname, $email, $password, $tel)
    {
        if ($this->user->isEmailTaken($email)) {
            return "Cet email est déjà utilisé. Veuillez utiliser un autre email.";
        }

        $hashedPassword = hash('sha256', $password);
        $result = $this->user->register($username, $surname, $email, $hashedPassword, $tel);

        if ($result) {
            return true;
        } else {
            return "Erreur lors de l'inscription : " . mysqli_error($this->conn);
        }
    }
}

?>
