<?php
session_start();
// Connect to the database and check for errors in the connection
include 'db_connect.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $select = mysqli_query($conn, "SELECT * FROM `students` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        $href = "";
        switch ($_SESSION['role']) {
            case 'student':
                $href = 'profile.php'; // Adjust the link for students
                break;
            case 'departement':
                $href = '../admin/internat.php'; // Adjust the link for department validators
                break;
            case 'internat':
                $href = '../admin/internat.php'; // Adjust the link for boarding affairs validators
                break;
            case 'economique':
                $href = '../admin/internat.php'; // Adjust the link for economic service validators
                break;
            case 'administration':
                $href = '../admin/internat.php'; // Adjust the link for administration validators
                break;
            case 'super_admin':
                $href = '../admin/internat.php';
                break;
        }
        header("Location:" . $href); // redirect to admin page
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internat</title>
    <link rel="shortcut icon" href="../images/ESTC.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .btn-primary {
            background-color: #00cbcc;
            border-color: #00cbcc;
        }
    </style>

</head>

<body style="background-color:#686c6d">

    <div class="loginColumns animated fadeInDown">

        <div class="ibox-content" style="width:60%;margin:auto">

            <div class="text-center" style="margin-bottom:30px">
                <img style="width: 50%" src="../images/EST.png" alt="logo">
            </div>

            <form method="post" action="">
                <div style="margin-bottom: 15px;">
                    <input type="email" name="email" class="form-control  " placeholder="Email" required maxlength="30" id="id_username" />
                </div>
                <div class="password-cont" style="margin-bottom: 15px;">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required id="id_password" />
                    <i id="password_eye_toggle" class="fa fa-eye" onclick="toggle_password_visibility()"></i>
                </div>

                <button type="submit" class="btn btn-primary block" name="login">Connexion</button>
                <a style="color:#00cbcc; display: block; text-align: center;" href="#">Mot de passe oublié ?</a>
            </form>
        </div>
    </div>

    <script>
        function toggle_password_visibility() {
            let icon = document.getElementById('password_eye_toggle');
            let input = document.getElementById('id_password');
            if (icon.classList.contains('fa-eye')) {
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                input.setAttribute('type', 'text');
            } else {
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                input.setAttribute('type', 'password');
            }
        }
    </script>
</body>

</html>