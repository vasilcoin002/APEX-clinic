<?php session_start() ?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='images/favicon.png' rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="css/vars.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/header-footer.css">
    <link rel="stylesheet" href="css/responsive/header-footer.css">
    <link rel="stylesheet" href="css/frmRegister.css"> 
    <title>APEX Medical - Registrace</title>
</head>
<body>
    <div class="wrapper">
        <?php 
            $page_name = "registration";
            require_once "header.php";
        ?>
        <main class="main">
            <div class="container center-form-container">
                
                <div class="frmCommon">
                    <h2>Registrace</h2>
                    <form id="registrationForm" name="Registration" action="../users/userController.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Jméno*:</label>
                            <input type="text" id="name" name="name" placeholder="Jan">
                            <span id="name-error-message" class="errorMessage"></span>
                        </div>
                        <div class="form-group">
                            <label for="surname">Příjmení*:</label>
                            <input type="text" id="surname" name="surname" placeholder="Novák">
                            <span id="surname-error-message" class="errorMessage"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail*:</label>
                            <input type="email" id="email" name="email" placeholder="email@example.com">
                            <span id="email-error-message" class="errorMessage"></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefonní číslo*:</label>
                            <input type="tel" id="phone" name="phone" placeholder="+123456789">
                            <span id="phone-error-message" class="errorMessage"></span>
                        </div>    

                        <div class="form-group">
                            <label for="password">Heslo*:</label>
                            <input type="password" id="password" name="password" placeholder="Qwerty123">
                            <span id="password-error-message" class="errorMessage"></span>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Potvrďte heslo*:</label>
                            <input type="password" id="confirm-password" name="confirm-password" placeholder="Qwerty123">
                            <span id="confirm-password-error-message" class="errorMessage"></span>
                        </div>
                        
                        <div>
                            <button id="submitBtn" class="submitBtn" type="submit">Registrovat se</button>
                        </div>
                    </form>

                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="frmLogin.php">Máte účet? Přihlaste se</a>
                    </div>
                </div>
            </div> 
        </main>

        <div class="container">
            <?php require_once "footer.php" ?>
        </div>
        <div class="copyright sz12">&copy; 2024 APEX Medical Center. Všechna práva vyhrazena.</div>
    </div>
<script type="module" src="js/registr_validateinput.js" defer></script>
</body>
</html>