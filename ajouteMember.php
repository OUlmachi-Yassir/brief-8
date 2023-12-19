<?php

require('connection.php');

class TeamAssigner {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function assignTeam($userId, $teamId) {
        $userId = mysqli_real_escape_string($this->conn, $userId);
        $teamId = mysqli_real_escape_string($this->conn, $teamId);

        $updateQuery = "UPDATE utilisateur
                        SET equipe = '$teamId'
                        WHERE id = '$userId'";

        $updateResult = mysqli_query($this->conn, $updateQuery);

        return $updateResult;
    }
}

// Usage example
if (isset($_POST['send'])) {
    $id_equipe = $_POST['equipe'];
    $id_utilisateur = $_POST['id']; 

    $teamAssigner = new TeamAssigner($conn);
    $updateResult = $teamAssigner->assignTeam($id_utilisateur, $id_equipe);

    if ($updateResult) {
        header('Location: dashboards.php');
    }
}

?>



  

