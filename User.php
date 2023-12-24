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

    try {
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $surname);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $hashedPassword);
        $stmt->bindParam(5, $tel);

        $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        return "Erreur lors de l'inscription : " . implode(", ", $stmt->errorInfo());
    }
} catch (PDOException $e) {
    return "Erreur lors de l'inscription : " . $e->getMessage();
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
public function getFilteredMembers($selectedTeamId = null)
{
    if ($selectedTeamId !== null) {
        $query = "SELECT * FROM utilisateur 
                  INNER JOIN equipe ON utilisateur.equipe = equipe.id_equipe 
                  WHERE utilisateur.role = 'membre' AND equipe.id_equipe = ?";
    } else {
        $query = "SELECT * FROM utilisateur 
                  INNER JOIN equipe ON utilisateur.equipe = equipe.id_equipe 
                  WHERE utilisateur.role = 'membre' AND nom_equipe <> 'none'";
    }

    $stmt = $this->conn->prepare($query);

    if ($selectedTeamId !== null) {
        $stmt->bindParam(1, $selectedTeamId);
    }

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
    

public function isEmailTaken($email)
{
    $query = "SELECT * FROM `utilisateur` WHERE email=?";
    try {
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

    public function closeConnection()
    {
        mysqli_close($this->conn);
    }


    public function getMemberOptions()
{
    try {
        $query = "SELECT id, email FROM utilisateur WHERE role='membre'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $options = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options .= "<option value='" . htmlspecialchars($row['id'], ENT_QUOTES) . "'>" . htmlspecialchars($row['email'], ENT_QUOTES) . "</option>";
        }

        return $options;
    } catch (PDOException $e) {
        // Handle the exception, log it, or rethrow it as needed
        die("Error: " . $e->getMessage());
    }
}
}

?>
