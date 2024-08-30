<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="asset/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <title>Admin Login Success</title>
    <style>
    body {
        background-image: url('../admin/asset/background/BG.jpg');
        background-size: cover;
        background-position: center;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-container {
        text-align: center;
        padding: 20px;
        max-width: 400px;
        width: 100%;
    }

    .logo {
        margin-bottom: 20px;
        opacity: 0;
        animation: fadeInLogo 2s ease forwards;
    }

    h1 {
        color: white;
        font-family: Monaco;
        font-weight: bold;
        animation: slideFromBottom 2s ease;
    }

    h3 {
        color: white;
        font-family: Monaco;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    #adminLabel {
        color: white;
        font-family: Monaco;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.5s ease, transform 1s ease;
        position: relative;
        top: -50px;
    }

    .form-floating {
        margin-bottom: 1rem;
    }

    .is-invalid {
        border-color: red;
    }

    @keyframes slideFromBottom {
        from {
            transform: translateY(100%);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fadeInLogo {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeInFromTop {
        from {
            opacity: 0;
            top: -50px;
        }

        to {
            opacity: 1;
            top: 0;
        }
    }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="logo.png" alt="Logo" width="150">
        </div>
        <h1 class="Succes"> LOGIN SUCCESS </h1>
        <h3 id="usernameMessage">
            <?php echo "Selamat Datang, <br>",isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : ''; ?>
        </h3>
        <p id="adminLabel">[ Administrator ]</p>
    </div>

    <script>
    // Wait for the page to load
    document.addEventListener("DOMContentLoaded", function() {
        // Get the h1 element
        var h1Element = document.querySelector('h1.Succes');
        var adminLabel = document.getElementById('adminLabel');

        // Add event listener for animation end
        h1Element.addEventListener('animationend', function() {
            // Fade in the username message
            var usernameMessage = document.getElementById('usernameMessage');
            usernameMessage.style.opacity = 1;

            // Fade in the admin label from above
            adminLabel.style.opacity = 1;
            adminLabel.style.animation = "fadeInFromTop 1s ease forwards";

            // Redirect to main.php after 3 seconds (adjust the delay as needed)
            setTimeout(function() {
                window.location.href = 'main.php';
            }, 1080);
        });
    });
    </script>
</body>

</html>