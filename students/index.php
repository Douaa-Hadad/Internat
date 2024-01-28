<?php
include '../includes/user_info.php';
$_SESSION['role'] == 'super_admin' || $_SESSION['role'] == 'student' ?  null :  header("Location:" . $_SESSION['defaultPage']);
$_SESSION['student_id'] = $user_id;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/select.css">
    <script src="../js/navbar.js"></script>
    <script src="../js/color.js"></script>
    <script src="../js/StudentShowPopup.js"></script>
    <script src="../js/demanderChambre.js"></script>
    <script src="../js/StudentShowStudentInfo.js"></script>
    <script src="../js/notifications.js"></script>
    <script src="../js/fetchUserData.js"></script>
    <script src="../js/setBuilding.js"></script>
</head>

<body id="body-pd">
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error-message" onclick="this.remove()"><?php echo $_SESSION['error'];
                                                            unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success-message" onclick="this.remove()"><?php echo $_SESSION['success'];
                                                                unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <header id="header" class="header fixed-top">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_txt">
            <h5>Choix de la chambre</h5>
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
                        <img src="../images/envelope.png" /><a href="../students/internat.php">Inbox</a>
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

        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> <a href="#" class="nav_logo"> <img src="../images/ESTC.png" style="height:30px"><span class="nav_logo-name">Salam</span> </a>
                <div class="nav_list">
                    <a href="../includes/profile.php" class="nav_link">
                        <i class="fas fa-home" style="width: 15px;"></i> <span class="nav_name">Home</span>
                    </a>
                    <a href="index.php" class="nav_link active">
                        <i class="fas fa-hotel" style="width: 15px;"></i> <span class="nav_name">Demander chambre</span>
                    </a>
                    <a href="decharge.php" class="nav_link">
                        <i class="fa fa-copy" style="width: 15px;"></i> <span class="nav_name">Demander décharge</span>
                    </a>
                    <a href="internat.php" class="nav_link">
                        <i class="fas fa-envelope" style="width: 15px;"></i> <span class="nav_name">Boîte de réception </span>
                    </a>
                </div>
            </div> <a href="../includes/user_info.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are your sure you want to logout?');"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>
    <!-- Floor selection dropdown -->

    <h1 style="font-weight:500; text-align:center;" class="w-100 my-3">
        Bienvenue dans votre Espace Étudiant <br />
        DUT-GI2 2023-2024
    </h1>


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

    <!-- Room map container -->
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
                <!-- Add other form fields as needed -->
                <button class="submit" type="submit">Chercher l'étudiant</button>
                <div id="studentList"></div>
                <button class="submit" style="background:red;" id="editCloseButton">Fermer</button>

            </form>
        </div>
    </div>
    <script>
        // Room data for each floor
        const boysBuilding = {
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
        const girlsBuilding = {
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

        const selectedBuilding = currentBuilding === 'boys' ? boysBuilding : girlsBuilding;

        // Function to update room layout based on the selected floor
        function updateRoomLayout() {
            const selectedBuilding = currentBuilding === 'boys' ? boysBuilding : girlsBuilding;

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

            // Draw rooms
            roomGroups.append("rect")
                .attr("class", 'room')
                .attr("width", roomWidth)
                .attr("height", roomHeight)
                .attr("x", 100)
                .style("fill", d => getRoomColor(d.id, boysBuilding, currentFloor)) // Assign color dynamically
                .on("click", showPopup);

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

</body>

</html>