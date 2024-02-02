<?php
include '../includes/user_info.php';
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'administration' || $_SESSION['role'] == 'internat' || $_SESSION['role'] == 'economique' || $_SESSION['role'] == 'departement' ?  null :  header("Location:" . $_SESSION['defaultPage']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="shortcut icon" href="../images/ESTC.png" type="image/x-icon">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/select.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/color.js"></script>
    <script src="../js/search.js"></script>
    <script src="../js/showPopup.js"></script>
    <script src="../js/editRoom.js"></script>
    <script src="../js/showPopupStudent.js"></script>
    <script src="../js/showStudentInfo.js"></script>
    <script src="../js/deleteStudent.js"></script>
    <script src="../js/moveStudent.js"></script>
    <script src="../js/displayRooms.js"></script>
    <script src="../js/navbar.js"></script>
    <script src="../js/notifications.js"></script>
    <style>
        .row {
            margin-top: 7rem;
            display: flex;
        }

        .column {
            flex: 1;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .column:nth-child(even) {
            background-color: #f2f2f2;
        }

        .column h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }

        .column p {
            font-size: 20px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body id="body-pd">
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Tableau de bord</h5>
        </div>
        <div class="action">
            <div class="profile" onmouseover="menuToggle(true);" onmouseout="menuToggle(false);">
                <img src="<?php echo $image ?>" />
            </div>
            <div class="menu" onmouseover="menuToggle(true);" onmouseout="menuToggle(false);">
                <h3><?php echo $name ?></h3>
                <ul>
                    <li>
                        <img src="../images/user.png" /><a href="../includes/profile.php">Mon Profile</a>
                    </li>
                    <li>
                        <img src="../images/edit.png" /><a href="../includes/updateProfile.php">Modifier Profile</a>
                    </li>
                    <li>
                        <img src="../images/envelope.png" /><a href="#">Inbox</a>
                    </li>
                    <li>
                        <img src="../images/question.png" /><a href="#">Aide</a>
                    </li>
                    <li>
                        <img src="../images/log-out.png" />
                        <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');" class="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        <script>
            function menuToggle(isHovered) {
                const toggleMenu = document.querySelector(".menu");
                const toggleProfile = document.querySelector(".profile");

                if (isHovered) {
                    toggleMenu.classList.add("active");
                    toggleProfile.classList.add("active");
                } else {
                    toggleMenu.classList.remove("active");
                    toggleProfile.classList.remove("active");
                }
            }
        </script>
        <div class="left">
            <div class="search-container">
                <label for="search" class="fa fa-search"></label>
                <input type="search" placeholder="Search Students" id="search">
            </div>
            <div class="notification-icon" onclick="fetchNotifications()">
                <i class="fa fa-bell"></i>
                <div class="notification-count" id="count"><?php echo $count ?></div>
                <div class="notification-dropdown">
                </div>
            </div>
            <div id="search-results"></div>
        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> <a href="#" class="nav_logo"> <img src="../images/ESTC.png" style="height:30px"><span class="nav_logo-name">Salam</span> </a>
                <div class="nav_list">
                    <a href="internat.php" class="nav_link">
                        <i class="fas fa-hotel"></i> <span class="nav_name">Map</span>
                    </a>
                    <a href="roomList.php" class="nav_link active">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span>
                    </a>
                    <?php

                    // Check if the user is logged in
                    if (isset($_SESSION['role'])) {
                        // Determine the appropriate href based on the user's role
                        switch ($_SESSION['role']) {
                            case 'Student':
                                $href = 'decharge.php'; // Adjust the link for students
                                break;
                            case 'departement':
                                $href = 'departement_decharge.php';
                                break;
                            case 'internat':
                                $href = 'internat_decharge.php';
                                break;
                            case 'economique':
                                $href = 'economique_decharge.php';
                                break;
                            case 'administration':
                                $href = 'administration_decharge.php';
                                break;
                        }
                    } else {
                        $href = 'login.php';
                    }
                    echo '<a href="' . $href . '" class="nav_link">';
                    echo '<i class="fa fa-copy"></i> <span class="nav_name">Gestion décharge</span>';
                    echo '</a>';
                    if ($_SESSION['role'] === 'administration') {
                        echo '<a href="decharge_valide.php" class="nav_link">';
                        echo '<i class="fa fa-file"></i> <span class="nav_name">Gestion décharge</span>';
                        echo '</a>';
                    }
                    if ($_SESSION['role'] === 'internat') {
                        echo '<a href="internat_demandes.php" class="nav_link">';
                        echo '<i class="fa fa-bed"></i> <span class="nav_name">Gestion demandes logement</span>';
                        echo '</a>';
                        echo '<a href="internat_demandes_valide.php" class="nav_link">';
                        echo '<i class="fa-solid fa-file-circle-check"></i> <span class="nav_name">Gestion demandes logement</span>';
                        echo '</a>';
                        echo '<a href="internat_demandes_refuse.php" class="nav_link">';
                        echo '<i class="fa-solid fa-file-circle-xmark"></i> <span class="nav_name">Gestion demandes logement</span>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div> <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <?php
    $totalRooms = 110;

    $queryBoys = "SELECT room_number, COUNT(*) AS count FROM students WHERE genre = 'boy' GROUP BY room_number";
    $resultBoys = mysqli_query($conn, $queryBoys);

    $emptyRoomsBoys = $totalRooms;
    $roomsWithOneBoy = 0;
    $roomsWithTwoBoys = 0;
    $roomsWithThreeBoys = 0;
    $roomFullBoys = 0;

    while ($row = mysqli_fetch_assoc($resultBoys)) {
        $numberOfStudents = $row['count'];

        switch ($numberOfStudents) {
            case 0:
                $emptyRoomsBoys--;
                break;
            case 1:
                $roomsWithOneBoy++;
                $emptyRoomsBoys--;
                break;
            case 2:
                $roomsWithTwoBoys++;
                $emptyRoomsBoys--;
                break;
            case 3:
                $roomsWithThreeBoys++;
                $emptyRoomsBoys--;
                break;
            case 4:
                $roomFullBoys++;
                $emptyRoomsBoys--;
                break;
            default:
                break;
        }
    }

    $queryGirls = "SELECT room_number, COUNT(*) AS count FROM students WHERE genre = 'girl' GROUP BY room_number";
    $resultGirls = mysqli_query($conn, $queryGirls);

    $emptyRoomsGirls = $totalRooms;
    $roomsWithOneGirl = 0;
    $roomsWithTwoGirls = 0;
    $roomsWithThreeGirls = 0;
    $roomFullGirls = 0;

    while ($row = mysqli_fetch_assoc($resultGirls)) {
        $numberOfStudents = $row['count'];

        switch ($numberOfStudents) {
            case 0:
                $emptyRoomsGirls--;
                break;
            case 1:
                $roomsWithOneGirl++;
                $emptyRoomsGirls--;
                break;
            case 2:
                $roomsWithTwoGirls++;
                $emptyRoomsGirls--;
                break;
            case 3:
                $roomsWithThreeGirls++;
                $emptyRoomsGirls--;
                break;
            case 4:
                $roomFullGirls++;
                $emptyRoomsGirls--;
                break;
            default:
                break;
        }
    }
    echo '<div class="row">';
    // Garcons
    echo '<div class="column">';
    echo "<h1 style='text-align:center;margin-bottom:3rem;'>INTERNAT GARCONS</h1>";
    echo "<p style='color:green;'>Chambres vides pour garçons: " . $emptyRoomsBoys . "</p>";
    echo "<p style='color:#66ccff;'>Chambres avec 1 garçon: " . $roomsWithOneBoy . "</p>";
    echo "<p style='color:#d6cf09;'>Chambres avec 2 garçons: " . $roomsWithTwoBoys . "</p>";
    echo "<p style='color:orange;'>Chambres avec 3 garçons: " . $roomsWithThreeBoys . "</p>";
    echo "<p style='color:red;'>Chambres pleines pour garçons: " . $roomFullBoys . "</p>";
    echo "<p>Total de chambres pour garçons: " . $totalRooms . "</p>";
    echo '</div>';

    // Filles

    echo '<div class="column">';
    echo "<h1 style='text-align:center;margin-bottom:3rem;'>INTERNAT FILLES</h1>";
    echo "<p style='color:green;'>Chambres vides pour filles: " . $emptyRoomsGirls . "</p>";
    echo "<p style='color:#66ccff;'>Chambres avec 1 fille: " . $roomsWithOneGirl . "</p>";
    echo "<p style='color:#d6cf09;'>Chambres avec 2 filles: " . $roomsWithTwoGirls . "</p>";
    echo "<p style='color:orange;'>Chambres avec 3 filles: " . $roomsWithThreeGirls . "</p>";
    echo "<p style='color:red;'>Chambres pleines pour filles: " . $roomFullGirls . "</p>";
    echo "<p>Totale de chambres pour filles: " . $totalRooms . "</p>";
    echo '</div>';

    echo '</div>';



    ?>

    <div class="building">
        <button class="boys" onclick="changeBuilding('boys')">Internat Garçons</button>
        <button class="girls" onclick="changeBuilding('girls')">Internat Filles</button>
    </div>

    <script>
        let currentBuilding = 'boys';

        function changeBuilding(building) {
            currentBuilding = building;
            updateTable();
        }
    </script>

    <div class="RoomList">
        <div class="filters">
            <label for="filter">Filter by Room:</label>
            <select id="filter">
                <option value="all">All Rooms</option>
                <?php
                for ($i = 1; $i <= 110; $i++) {
                    echo "<option value=\"$i\">Room $i</option>";
                }
                ?>
            </select>
        </div>

        <table id="data-table">
            <thead>
                <tr>
                    <th>Chambre</th>
                    <th>Etudiant(e) 1</th>
                    <th>Etudiant(e) 2</th>
                    <th>Etudiant(e) 3</th>
                    <th>Etudiant(e) 4</th>
                    <th>Nombre d'Etudiant(e)s</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <div class='pagination-container'>
            <ul class="pagination">
            </ul>
        </div>
    </div>


</body>

</html>