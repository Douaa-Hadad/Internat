<?php
include '../includes/user_info.php';
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'administration' || $_SESSION['role'] == 'internat' || $_SESSION['role'] == 'economique' || $_SESSION['role'] == 'departement' ?  null :  header("Location:" . $_SESSION['defaultPage']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internat</title>
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
    <script src="../js/navbar.js"></script>
    <script src="../js/notifications.js"></script>
</head>

<body id="body-pd">
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Gestion de l'internat</h5>
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
            <div> <a href="#" class="nav_logo"> <img src="../images/ESTC.png" style="height:30px"><span class="nav_logo-name">EST Casablanca</span> </a>
                <div class="nav_list">
                    <a href="internat.php" class="nav_link active">
                        <i class="fas fa-hotel"></i> <span class="nav_name">Map</span>
                    </a>
                    <a href="dashboard.php" class="nav_link">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Tableau de bord</span>
                    </a>
                    <a href="roomList.php" class="nav_link">
                        <i class="fa-solid fa-list"></i> <span class="nav_name">Liste des chambres</span>
                    </a>
                    <?php

                    if (isset($_SESSION['role'])) {
                        switch ($_SESSION['role']) {
                            case 'Student':
                                $href = 'decharge.php';
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
                    if ($_SESSION['role'] === 'departement') {
                        echo '<a href="departement_degats.php" class="nav_link">';
                        echo '<i class="fa-solid fa-flask-vial"></i> <span class="nav_name">Gestion Incidents </span>';
                        echo '</a>';
                    }
                    if ($_SESSION['role'] === 'economique') {
                        echo '<a href="serviceEconomique.php" class="nav_link">';
                        echo '<i class="fa-solid fa-sack-dollar"></i> <span class="nav_name">Payement internat</span>';
                        echo '</a>';
                    }
                    if ($_SESSION['role'] === 'internat') {
                        echo '<a href="internat_demandes_casa.php" class="nav_link">';
                        echo '<i class="fa fa-bed"></i> <span class="nav_name">Demandes Casablanca</span>';
                        echo '</a>';
                        echo '<a href="internat_demandes_valide.php" class="nav_link">';
                        echo '<i class="fa-regular fa-circle-pause"></i> <span class="nav_name">Demande Validées</span>';
                        echo '</a>';
                        echo '<a href="internat_demandes_refuse.php" class="nav_link">';
                        echo '<i class="fa-solid fa-file-circle-xmark"></i> <span class="nav_name">Demande Refusées</span>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div> <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <div class="building">
        <button class="boy" onclick="changeBuilding('boy')">Internat Garçons</button>
        <button class="girl" onclick="changeBuilding('girl')">Internat Filles</button>
    </div>
    <form id="app-cover">
        <div id="select-box">
            <input type="checkbox" id="options-view-button">
            <div id="select-button" class="brd">
                <div id="selected-value">
                    <span>Naviguer étage</span>
                </div>
                <div id="chevrons">
                    <i class="fas fa-chevron-up"></i>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div id="options">
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="1">
                    <input class="s-c bottom" type="radio" name="platform" value="1">
                    <i class="fas fa-solid fa-door-open"></i>
                    <span class="label">Rez de chaussée</span>
                    <span class="opt-val">Rez de chaussée</span>
                </div>
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="2">
                    <input class="s-c bottom" type="radio" name="platform" value="2">
                    <i class="fa">1</i>
                    <span class="label">1<sup>er</sup> étage</span>
                    <span class="opt-val">1<sup>er</sup> étage</span>
                </div>
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="3">
                    <input class="s-c bottom" type="radio" name="platform" value="3">
                    <i class="fa">2</i>
                    <span class="label">2<sup>ème</sup> étage</span>
                    <span class="opt-val">2<sup>ème</sup> étage</span>
                </div>
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="4">
                    <input class="s-c bottom" type="radio" name="platform" value="4">
                    <i class="fa">3</i>
                    <span class="label">3<sup>ème</sup> étage</span>
                    <span class="opt-val">3<sup>ème</sup> étage</span>
                </div>
                <div class="option">
                    <input class="s-c top" type="radio" name="platform" value="5">
                    <input class="s-c bottom" type="radio" name="platform" value="5">
                    <i class="fa">4</i>
                    <span class="label">4<sup>ème</sup> étage</span>
                    <span class="opt-val">4<sup>ème</sup> étage</span>
                </div>
                <div id="option-bg"></div>
            </div>
        </div>
    </form>

    <div id="roomMap">

        <div class="popup" id="popup">
            <p style="margin-top: 0.5rem; font-size: 17px">Informations Chambre</p>
            <p id="popupRoomNumber"></p>
            <div id="popupImages"></div>
        </div>

        <div class="info-popup" id="infoPopup"></div>

        <div class="popup" id="editPopup">
            <p>Ajouter étudiant</p>
            <form id="editForm">
                <label for="studentName">Nom de l'étudiant:</label>
                <input type="text" id="studentName" required>
                <button class="submit" type="submit">Chercher l'étudiant</button>
                <div id="studentList"></div>
                <button class="submit" style="background:red;" id="editCloseButton">Fermer</button>

            </form>
        </div>
    </div>
    <script>
        // Room data for each floor
        const boyBuilding = {
            1: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 1,
                type: 'room'
            })),
            2: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 23,
                type: 'room'
            })),
            3: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 45,
                type: 'room'
            })),
            4: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 67,
                type: 'room'
            })),
            5: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 89,
                type: 'room'
            })),
        };
        const girlBuilding = {
            1: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 1,
                type: 'room'
            })),
            2: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 23,
                type: 'room'
            })),
            3: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 45,
                type: 'room'
            })),
            4: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 67,
                type: 'room'
            })),
            5: Array.from({
                length: 22
            }, (_, i) => ({
                id: i + 89,
                type: 'room'
            })),
        };

        let currentBuilding = 'boy'; // Default to boy' Building
        let currentFloor = 1; // Default to Ground Floor

        // Room dimensions and layout
        const roomWidth = 70;
        const roomHeight = 70;
        const spacing = 10;
        const numRows = 2;
        const numCols = 11;

        // Calculate total width and height
        const totalWidth = (numCols * roomWidth) + ((numCols - 1) * spacing) + 160;
        const totalHeight = (numRows * roomHeight) + ((numRows - 1) * spacing);

        // Create SVG container
        const svg = d3.select("#roomMap")
            .append("svg")
            .attr("width", totalWidth)
            .attr("height", totalHeight);

        // Draw building border
        svg.append("rect")
            .attr("class", "building")
            .attr("width", totalWidth)
            .attr("height", totalHeight);

        const selectedBuilding = currentBuilding === 'boy' ? boyBuilding : girlBuilding;

        // Function to update room layout based on the selected floor
        function updateRoomLayout() {
            const selectedBuilding = currentBuilding === 'boy' ? boyBuilding : girlBuilding;

            // Clear existing room groups
            svg.selectAll("g").remove();

            // Create rooms for the selected floor
            const roomGroups = svg.selectAll("g")
                .data(selectedBuilding[currentFloor])
                .enter()
                .append("g")
                .attr("transform", (d, i) => {
                    const col = i % numCols;
                    const row = Math.floor(i / numCols);
                    const x = row % 2 === 0 ? col * (roomWidth + spacing) : (numCols - 1 - col) * (roomWidth + spacing);
                    const y = row * (roomHeight + spacing);
                    return `translate(${x}, ${y})`;
                });

            roomGroups.append("rect")
                .attr("class", 'room')
                .attr("width", roomWidth)
                .attr("height", roomHeight)
                .attr("x", 100)
                .style("fill", d => getRoomColor(d.id, boyBuilding, currentFloor)) // Initial color assignment
                .on("click", showPopup);

            // Set up a timer to update the color every 2 seconds
            setInterval(function() {
                roomGroups.select('.room')
                    .style("fill", d => getRoomColor(d.id, boyBuilding, currentFloor));
            }, 3000);


            // Draw room numbers
            roomGroups.append("text")
                .attr("class", "roomNumber")
                .text(d => d.id)
                .attr("x", roomWidth / 2 + 100)
                .attr("y", roomHeight / 2)
                .attr("text-anchor", "middle")
                .attr("dominant-baseline", "middle");

            // Draw bathroom
            svg.append("rect")
                .attr("class", "bathroom")
                .attr("width", 80)
                .attr("height", totalHeight)
                .attr("x", 0); // Adjust the position based on room layout

            // Draw stairs
            svg.append("rect")
                .attr("class", "stairs")
                .attr("width", 50)
                .attr("height", totalHeight)
                .attr("x", totalWidth - 50); // Adjust the position based on room layout

            // Draw divider line
            svg.append("line")
                .attr("class", "divider")
                .attr("x1", roomWidth + 20)
                .attr("y1", 0)
                .attr("x2", roomWidth + 20)
                .attr("y2", totalHeight);
        }

        // Initial room layout for the default floor
        updateRoomLayout();
        document.querySelectorAll('#options input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('change', changeFloor);
        });

        // Function to handle building change
        function changeBuilding(building) {
            currentBuilding = building;
            currentFloor = 1; // Reset floor to Ground Floor when changing building
            updateRoomLayout();
        }

        // Function to handle floor change
        function changeFloor() {
            // Assuming you have a reference to the selected option element
            currentFloor = parseInt(document.querySelector('#options input[type="radio"]:checked').value);
            updateRoomLayout();
        }
        // Event listener for document click to close the dropdown
        document.addEventListener("click", function(event) {
            var dropdown = document.getElementById("options-view-button");
            var dropdownContainer = document.getElementById("options");

            // Check if the clicked element is not inside the dropdown or its container
            if (!dropdownContainer.contains(event.target) && event.target !== dropdown) {
                // Close the dropdown by unchecking the checkbox
                dropdown.checked = false;
            }
        });

        // Event listener for radio inputs to close the dropdown when a value is selected
        var radioInputs = document.querySelectorAll('#options input[type="radio"]');
        radioInputs.forEach(function(radioInput) {
            radioInput.addEventListener("change", function() {
                // Close the dropdown by unchecking the checkbox
                document.getElementById("options-view-button").checked = false;
            });
        });
    </script>
    <div id="legend">
        <div class="legend-item">
            <div class="legend-color" style="background-color: green;"></div>
            <div class="legend-label">Chambres vides</div>
        </div>

        <div class="legend-item">
            <div class="legend-color" style="background-color: #66ccff;"></div>
            <div class="legend-label">Chambres avec 1 étudiant(e)</div>
        </div>

        <div class="legend-item">
            <div class="legend-color" style="background-color: #d4ce24;"></div>
            <div class="legend-label">Chambres avec 2 étudiant(e)s</div>
        </div>

        <div class="legend-item">
            <div class="legend-color" style="background-color: orange;"></div>
            <div class="legend-label">Chambres avec 3 étudiant(e)s</div>
        </div>

        <div class="legend-item">
            <div class="legend-color" style="background-color: red;"></div>
            <div class="legend-label">Chambres pleines</div>
        </div>

        <div class="legend-item">
            <div class="legend-color" style="background-color: blue;"></div>
            <div class="legend-label">Toillettes</div>
        </div>
    </div>
</body>



</html>