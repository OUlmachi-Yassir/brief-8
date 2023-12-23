<?php
include("connection.php");
include("projet.php");
include("equipe.php");


// Initialiser la session
session_start();
$projects = new Projects();
$equipeObj = new Equipe();

$id = $_SESSION['id'];
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>DataWare</title>
</head>

<body class="bg-black">

    <!-- navbar  -->


    <nav class="bg-black">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a class="text-3xl font-bold font-heading bg-gradient-to-r from-orange-500 via-white to-orange-500 text-transparent bg-clip-text" href="#">
          <!-- <img class="h-9" src="logo.png" alt="logo"> -->
          Data-Ware
        </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0">
                
                    <li>
                        <a href="logout.php" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-orange-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                            Deconnexion
                            </span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1 class=" ml-24 mb-4 text-4xl font-bold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white">Bienvenue</h1>

    <!-- Affichage mes projets  -->
    <section class="equipe">
        <div class="bg-black py-10">

            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <h2 class="mb-4 text-3xl font-bold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white">Mes projets</h2>
                    </div>
                </div>
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Id Projet</th>
                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Nom Porjet</th>
                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">

                                        

                                            <?php
                                            // $sql = "SELECT * FROM projet inner join  utilisateur  on utilisateur.projet = projet.id_pro and utilisateur.role = 'ScrumMaster' " ;

                                            // $sql = "SELECT * FROM utilisateur where id=$id";
                                            $projectsList = $projects->getProjectsWithScrumMaster();

                                            if ($projectsList) {
                                                foreach ($projectsList as $row) {
                                            ?>
                                            <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-center font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                                        <?php
                                                        echo $row["id_pro"];
                                                        ?>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">
                                                        <?php
                                                        echo $row["nom_pro"];
                                                        ?>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">
                                                        <?php
                                                        echo $row["descrp_pro"];
                                                        ?>
                                                    </td>
                                        </tr>
                                <?php
                                                
                                            } 
                                                
                                            }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Affichage mes equipes  -->
    <section class="equipe">
        <div class="bg-black py-10">

            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <h2 class="mb-4 text-3xl font-bold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white">Mes equipes</h2>
                    </div>
                </div>
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Id Equipe</th>
                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Nom Equipe</th>
                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Date de Creation</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">

                                        <tr>

                                            <?php
                                            

                                            try {
                                                // Get equipe data based on utilisateur id
                                                $equipeData = $equipeObj->getEquipeByUserId($id);
                                            
                                                // Check if equipe data exists
                                                if ($equipeData) {
                                                    foreach ($equipeData as $row) {
                                                        ?>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-center font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                                        <?php
                                                        echo $row["id_equipe"];
                                                        ?>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">
                                                        <?php
                                                        echo $row["nom_equipe"];
                                                        ?>
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">
                                                        <?php
                                                        echo $row["date_creation"];
                                                        ?>
                                                    </td>
                                        </tr>
                                <?php
                                                    }
                                               } else {
                                                echo "No equipe data found for utilisateur id: $id";
                                            }
                                        } catch (PDOException $e) {
                                            // Handle the exception, log it, or display an error message
                                            echo "Error: " . $e->getMessage();
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>