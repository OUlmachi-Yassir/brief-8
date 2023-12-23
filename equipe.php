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
}
?>
