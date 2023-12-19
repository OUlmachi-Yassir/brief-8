<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function registerUser($username, $surname, $email, $password, $tel)
    {
        if ($this->isEmailTaken($email)) {
            return "Cet email est déjà utilisé. Veuillez utiliser un autre email.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `utilisateur` (nom, prenom, email, pass, tel, statut, role)
                  VALUES (?, ?, ?, ?, ?, 'active', 'membre')";

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $username, $surname, $email, $hashedPassword, $tel);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            return true;
        } else {
            return "Erreur lors de l'inscription : " . mysqli_error($this->conn);
        }
    }

    public function authenticateUser($email, $password)
    {
        $query = "SELECT * FROM `utilisateur` WHERE email=? and pass=?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result !== false) {
            $userData = mysqli_fetch_assoc($result);

            if ($userData && password_verify($password, $userData['pass'])) {
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

    public function isEmailTaken($email)
    {
        $query = "SELECT * FROM `utilisateur` WHERE email=?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_num_rows($result) > 0;
    }

    public function closeConnection()
    {
        mysqli_close($this->conn);
    }
}

// Usage Example:
// $conn = mysqli_connect("your_host", "your_username", "your_password", "your_database");
// $userHandler = new UserHandler($conn);

// ... (Use $userHandler in your application)

?>
