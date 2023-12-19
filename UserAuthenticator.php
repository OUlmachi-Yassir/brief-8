<?php

class UserAuthenticator
{
    private $conn;

    public function __construct($servername, $username, $password, $database)
    {
        $this->conn = mysqli_connect($servername, $username, $password, $database);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function authenticate($email, $password)
    {
        $query = "SELECT * FROM `utilisateur` WHERE email='$email' AND pass='$password'";
        $result = mysqli_query($this->conn, $query);

        if ($result !== false) {
            $userData = mysqli_fetch_assoc($result);

            if ($userData) {
                session_start();
                $_SESSION['id'] = $userData['id'];
                $role = $userData['role'];

                switch ($role) {
                    case 'membre':
                        $_SESSION['email'] = $email;
                        header("Location: dashboardm.php");
                        exit();
                    case 'ProductOwner':
                        $_SESSION['email'] = $email;
                        header("Location: dashboardp.php");
                        exit();
                    case 'ScrumMaster':
                        $_SESSION['email'] = $email;
                        header("Location: dashboards.php");
                        exit();
                }
            } else {
                return "L'email ou le mot de passe est incorrect.";
            }
        } else {
            return "Erreur de requête SQL : " . mysqli_error($this->conn);
        }
    }

    public function closeConnection()
    {
        mysqli_close($this->conn);
    }
}
?>
