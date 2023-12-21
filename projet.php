<?php

class Projects {
    private $db;
    private $nomp;
    private $descP;

    public function __construct() {
        $this->db = new db();

    }
 
    public function getAllProjects() {
        $conn = $this->db->getConnection();
        $stmt = $conn->query("SELECT * FROM projet");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProject($id, $nomp, $descP) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO projet (nom_pro , descrp_pro) VALUES (?,?)");
        $stmt->execute([$nomp , $descP]);
    }
    public function getProjectsWithScrumMaster() {
        $conn = $this->db->getConnection();
        $stmt = $conn->query("SELECT projet.id_pro, projet.nom_pro, projet.descrp_pro, utilisateur.nom
                             FROM projet
                             INNER JOIN utilisateur ON utilisateur.projet = projet.id_pro AND utilisateur.role = 'ScrumMaster'
                             WHERE projet.nom_pro <> 'none'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProjectOptions() {
        try {
            $conn = $this->db->getConnection();
            $query = "SELECT id_pro, nom_pro FROM projet WHERE nom_pro <> 'none'";
            $stmt = $conn->query($query);

            $options = "";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $options .= "<option value='" . htmlspecialchars($row['id_pro'], ENT_QUOTES) . "'>" . htmlspecialchars($row['nom_pro'], ENT_QUOTES) . "</option>";
            }

            return $options;
        } catch (PDOException $e) {
            // Handle the exception, log it, or rethrow it as needed
            die("Error: " . $e->getMessage());
        }
    }
    public function getMemberOptions() {
        try {
            $conn = $this->db->getConnection();
            $query = "SELECT id, email FROM utilisateur WHERE role='membre'";
            $stmt = $conn->query($query);

            $options = "";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row === false) {
                    // Handle fetch error
                    die("Error fetching row: " . implode(' ', $stmt->errorInfo()));
                }

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