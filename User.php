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
    $query = "SELECT id, email, pass, role FROM `utilisateur` WHERE email=?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $email);
    $stmt->execute();

    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        if (password_verify($password, $userData['pass'])) {
            session_start();
            $_SESSION['id'] = $userData['id'];
            $_SESSION['email'] = $email;
            session_write_close();
            switch ($userData['role']) {
                case 'membre':
                    header("Location: dashboardm.php");
                    exit();
                case 'ProductOwner':
                    header("Location: dashboardp.php");
                    exit();
                case 'ScrumMaster':
                    header("Location: dashboards.php");
                    exit();
                default:
                    // Handle unexpected role
                    return "Erreur: Rôle non reconnu.";
            }
        } else {
            return "Mot de passe incorrect.";
        }
    } else {
        return "L'email n'existe pas.";
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

?>
