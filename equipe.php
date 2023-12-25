<?php

class Equipe
{
    private $db;

    public function __construct()
    {
        $this->db = new db(); // Assuming you have a database connection class named "db"
    }

    public function getAllEquipes()
    {
        try {
            $conn = $this->db->getConnection();
            $query = "SELECT * FROM equipe";
            $stmt = $conn->query($query);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function getEquipeById($equipeId)
    {
        try {
            $conn = $this->db->getConnection();
            $query = "SELECT * FROM equipe WHERE id_equipe = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$equipeId]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function createEquipe($nomEquipe, $dateCreation)
    {
        try {
            $conn = $this->db->getConnection();
            $query = "INSERT INTO equipe (nom_equipe, date_creation) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$nomEquipe, $dateCreation]);

            return true;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function updateEquipe($equipeId, $nomEquipe, $dateCreation)
    {
        try {
            $conn = $this->db->getConnection();
            $query = "UPDATE equipe SET nom_equipe = ?, date_creation = ? WHERE id_equipe = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$nomEquipe, $dateCreation, $equipeId]);

            return true;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
        public function assignProjectToEquipe($id_equipe, $id_pro) {
            try {
                $conn = $this->db->getConnection();
        
                // Update the equipe table to associate the project
                $query = "UPDATE equipe SET id_pro = ? WHERE id_equipe = ?";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(1, $id_pro, PDO::PARAM_INT);
                $stmt->bindParam(2, $id_equipe, PDO::PARAM_INT);
                $result = $stmt->execute();
        
                return $result;
            } catch (PDOException $e) {
                // Handle the exception, log it, or rethrow it as needed
                echo "Error: " . $e->getMessage();
                return false;
            }
        }

    public function deleteEquipe($equipeId)
    {
        try {
            $conn = $this->db->getConnection();
            $query = "DELETE FROM equipe WHERE id_equipe = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$equipeId]);

            return true;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function getEquipeByUserId($userId)
    {
        try {
            $conn = $this->db->getConnection();

            // Assuming there is a foreign key relationship between utilisateur and equipe tables
            $query = "SELECT equipe.id_equipe, equipe.nom_equipe, equipe.date_creation
                      FROM utilisateur
                      JOIN equipe ON utilisateur.equipe_id = equipe.id_equipe
                      WHERE utilisateur.id = ?";

            $stmt = $conn->prepare($query);
            $stmt->execute([$userId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function getEquipesWithProjects()
    {
        try {
            $conn = $this->db->getConnection();
            $query = "SELECT equipe.id_equipe, equipe.nom_equipe, projet.nom_pro
                      FROM equipe
                      INNER JOIN projet ON equipe.id_equipe = projet.id_pro
                      WHERE projet.nom_pro <> 'none'";
            $stmt = $conn->query($query);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getEquipeOptions()
    {
        try {
            $query = "SELECT id_equipe, nom_equipe FROM equipe WHERE nom_equipe <> 'none'";
            $stmt = $this->db->getConnection()->query($query);

            $options = "";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $options .= "<option value='" . htmlspecialchars($row['id_equipe'], ENT_QUOTES) . "'>" . htmlspecialchars($row['nom_equipe'], ENT_QUOTES) . "</option>";
            }

            return $options;
        } catch (PDOException $e) {
            // Handle the exception, log it, or rethrow it as needed
            die("Error: " . $e->getMessage());
        }
    }
}
?>
