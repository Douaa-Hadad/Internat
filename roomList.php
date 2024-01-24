<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internat</title>
    <link rel="shortcut icon" href="images/ESTC.png" type="image/x-icon">
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" href="css/sass.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/color.js"></script>
    <script src="js/search.js"></script>
    <script src="js/showPopup.js"></script>
    <script src="js/editRoom.js"></script>
    <script src="js/showPopupStudent.js"></script>
    <script src="js/showStudentInfo.js"></script>
    <script src="js/deleteStudent.js"></script>
    <script src="js/moveStudent.js"></script>
    <script src="js/displayRooms.js"></script>

</head>

<body>
    <!-- Room map container -->
    <header id="header" class="fixed-top" style="background: none;">
        <div class="fa fa-bars"></div>
        <div class="left">
            <div class="search-container">
                <label for="search" class="fa fa-search"></label>
                <input type="search" placeholder="Search Students" id="search">
            </div>
            <div id="search-results"></div>
        </div>
        <!-- navbar  -->
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="categories.php">Product</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
        </nav>
    </header>
    <!-- Buttons to change buildings -->
    <div class="building">
        <button class="boys" id="boysButton" onclick="changeBuilding('boys')">Internat Garçons</button>
        <button class="girls" id="girlsButton" onclick="changeBuilding('girls')">Internat Filles</button>
    </div>
    <script>
        let currentBuilding = 'boys'; // Default to Boys' Building
        // Function to handle building change
        function changeBuilding(building) {
            currentBuilding = building;
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
                    <th>Room</th>
                    <th>Student1</th>
                    <th>Student2</th>
                    <th>Student3</th>
                    <th>Student4</th>
                    <th>Student Count</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded here -->
            </tbody>
        </table>

        <div class='pagination-container'>
            <ul class="pagination">
                <!--	Here the JS Function Will Add the Rows -->
            </ul>
        </div>
    </div>


</body>

</html>