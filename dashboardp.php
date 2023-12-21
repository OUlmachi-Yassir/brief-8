<?php
require("connection.php");
require ("projet.php");
session_start();

$projectsHandler = new Projects();
$options = $projectsHandler->getProjectOptions();
$memberOptions = $projectsHandler->getMemberOptions();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}


if (isset($_POST["submit"])) {
    $nomp = $_POST["nom_pro"];
    $descP = $_POST["descrp_pro"];

    $result =$projectsHandler->addProject(null, $nomp, $descP);
    
    if ($result === true) {
        // Projet ajouté avec succès
        echo "succe";
    } else {
        // Une erreur s'est produite lors de l'ajout du projet
        echo "Erreur lors de l'ajout du projet : " . $result;
    }
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

<body>

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
    <!-- CRUD projets  -->
    <section class="equipe">
        <div class="bg-black py-10">

            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <h1 class="mb-4 text-3xl font-bold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white"> Welcome,<span class="text-orange-500"> !</span></h1>   
                    <h1 class="mb-12 text-3xl font-bold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white">Affichage des projets</h1>
                        <!-- <a href="add.php"> -->
                        <button id = "openBtn" type="button" class=" relative flex rounded-lg h-[50px] w-40 items-center justify-center overflow-hidden bg-gray-800 text-white shadow-2xl transition-all before:absolute before:h-0 before:w-0 before:rounded-full before:bg-orange-600 before:duration-500 before:ease-out hover:shadow-orange-600 hover:before:h-56 hover:before:w-56"> <span class="relative z-10">Ajouter un Projet</span></button>
                        <div id="overlay4" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-40 opacity-0 transition-opacity duration-300 ease-in-out "></div>
                        <div id="popup-form4" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-4 bg-white border border-gray-300 shadow-md z-50 opacity-1 scale-110 transition-opacity transition-transform duration-300 ease-in-out ">
                            <div class="">


                                <form action="" method="post">
                                    <div>
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Nom projet</label>
                                        <div class="relative mt-2 rounded-md">
                                            <input type="text" name="nom_pro" id="" class="block rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                        <div class="relative mt-2 rounded-md">
                                            <textarea name="descrp_pro" id="" class="block rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                        </div>
                                    </div>
                                    <!-- <div>
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Scrum master</label>
                                        <div class="relative mt-2 rounded-md shadow-sm">
                                            <input type="text" name="" id="" class="block rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div> -->
                                    <button type="submit" name="submit" class=" mt-4 ml-14 text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Ajouter</button>
                                    <button type="button" onclick="closeFormPopup4()">Fermer</button>

                                </form>
                            </div>

                            <div class="">
                                <button type="submit" name="submit" class="block py-2 px-3 text-pink-500 font-bold rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"><a href="dashboardp.php" class="">Retour</a>
                                </button>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>







                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Id projet</th>
                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Nom projet</th>
                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Description</th>
                                            <!-- <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Scrum Master</th> -->

                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                                                <span>Modifier</span>
                                            </th>
                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                                                <span>Supprimer</span>
                                            </th>
                                        </tr>
                                    </thead>


                                    <tbody class="divide-y divide-gray-200 bg-white">

                                        <tr>
                                            <?php
                                            $projects = $projectsHandler->getAllProjects();

                                            if ($projects) {
                                                foreach ($projects as $row) {
                                            // $sql = "SELECT * FROM projet  where nom_pro <> 'none'";
                                            // $result = mysqli_query($conn, $sql);

                                            // if ($result) {
                                            //     while ($row = mysqli_fetch_assoc($result)) {
                                            ?>

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
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 lg:pr-8">
                                                        <a href="editproject.php?id_pro=<?php echo $row['id_pro']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white px-5 py-3">Modifier<span class="sr-only"></span></a>
                                                    </td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 lg:pr-8">
                                                        <a href="deleteproject.php?id_pro=<?php echo $row['id_pro']; ?>" class="bg-red-500 hover:bg-red-700 text-white px-5 py-3">Supprimer<span class="sr-only"></span></a>
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



    <section class="membre">
        <div class="bg-black py-10">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <h1 class="mb-4 text-3xl font-bold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white">Affecter le rôle de Scrum Master à un projet</h1>
                        <button id = "openBtn2" type="button"  class="relative flex rounded-lg h-[50px] w-44 items-center justify-center overflow-hidden bg-gray-800 text-white shadow-2xl transition-all before:absolute before:h-0 before:w-0 before:rounded-full before:bg-orange-600 before:duration-500 before:ease-out hover:shadow-orange-600 hover:before:h-56 hover:before:w-56"> <span class="relative z-10">Assigner scrum master</span></button>
                        <div id="overlay5" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-40 opacity-0 transition-opacity duration-300 ease-in-out "></div>
                        <div id="popup-form5" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-4 bg-white border border-gray-300 shadow-md z-50 opacity-1 scale-110 transition-opacity transition-transform duration-300 ease-in-out ">
                            <div class="">

                                <form action="" method="post">
                                    <div>
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Projet</label>
                                        <div class="relative mt-2 rounded-md">
                                            <select name="projet" id="" class="block rounded-md border-0 py-1.5 pl-2 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                                         
                                               
                                               
                                                
                                               <?php echo $options; ?>                                    
                                               

                                            </select>
                                        </div>
                                    </div>



                                    <div>
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Membre</label>
                                        <div class="relative mt-2 rounded-md">
                                            <select name="id" id="" class="block rounded-md border-0 py-1.5 pl-2 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                                           
                                                <?php echo $memberOptions; ?>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" name="submits" class=" mt-4 ml-14 text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Ajouter</button>
                                    <button type="button" onclick="closeFormPopup5()">Fermer</button>
                                </form>
                            </div>

                            <div class="">
                                <button type="submit" name="submit" class="block py-2 px-3 text-pink-500 font-bold rounded hover:bg-blue-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"><a href="dashboardp.php" class="">Retour</a>
                                </button>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">id Projet</th>

                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Nom Projet</th>
                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Scrum master</th>

                                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                                                <span>Supprimer</span>
                                            </th>
                                        </tr>
                                    </thead>


                                    <tbody class="divide-y divide-gray-200 bg-white">

                                        <tr>
                                            <?php
                                            $projectsWithSM = $projectsHandler->getProjectsWithScrumMaster();

                                            if ($projectsWithSM) {
                                                foreach ($projectsWithSM as $row) {
                                                    print_r($row);
                                            ?>

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
                                                        echo $row["nom"];
                                                        ?>
                                                    </td>


                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 lg:pr-8">
                                                        <a href="deletesm.php?id=<?php echo $row['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white px-5 py-3">Supprimer<span class="sr-only"></span></a>
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


    <script>
         // Fonction pour ouvrir la popup
         
    function openFormPopup4() {
      const overlay = document.getElementById("overlay4");
      const formPopup = document.getElementById("popup-form4");

      overlay.style.display = "block";
      formPopup.style.display = "block";
      formPopup.classList.add("open");
    }
    const openBtn = document.getElementById("openBtn");
    openBtn.addEventListener("click", openFormPopup4);

    const openBtn2 = document.getElementById("openBtn2");
    openBtn2.addEventListener("click", openFormPopup5)
   

    function closeFormPopup4() {
      const overlay = document.getElementById("overlay4");
      const formPopup = document.getElementById("popup-form4");

      overlay.style.display = "none";
      formPopup.style.display = "none";
      formPopup.classList.remove("open");
    }
      // Fonction pour ouvrir la popup
      function openFormPopup5() {
      const overlay = document.getElementById("overlay5");
      const formPopup = document.getElementById("popup-form5");

      overlay.style.display = "block";
      formPopup.style.display = "block";
      formPopup.classList.add("open");
    }

    function closeFormPopup5() {
      const overlay = document.getElementById("overlay5");
      const formPopup = document.getElementById("popup-form5");

      overlay.style.display = "none";
      formPopup.style.display = "none";
      formPopup.classList.remove("open");
    }
    </script>
</body>

</html>