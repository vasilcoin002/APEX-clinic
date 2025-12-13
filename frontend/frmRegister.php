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
        <!-- TODO write * where fields are required -->
        <main class="main">
            <div class="container center-form-container"> 
                
                <div class="frmCommon">
                    <h2>Registrace</h2>
                    <form name="Registration" action="register_handler.html" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="surname">Zadejte své příjmení:</label>
                            <input type="text" id="surname" name="surname" placeholder="Příjmení">
                            <span id="surname-error-message" class="errorMessage"></span>
                        </div>
                        <div class="form-group">
                            <label for="name">Zadejte své jméno:</label>
                            <input type="text" id="name" name="name" placeholder="Jméno">
                            <span id="name-error-message" class="errorMessage"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Zadejte svůj E-mail:</label>
                            <input type="email" id="email" name="email" placeholder="E-mail">
                            <span id="email-error-message" class="errorMessage"></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Zadejte telefonní číslo:</label>
                            <input type="tel" id="phone" name="phone" placeholder="+123456789">
                            <span id="phone-error-message" class="errorMessage"></span>
                        </div>    

                        <div class="form-group">
                            <label for="password">Zadejte heslo:</label>
                            <input type="password" id="password" name="password" placeholder="Qwerty123">
                            <span id="password-error-message" class="errorMessage"></span>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Potvrďte heslo:</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Qwerty123">
                            <span id="confirm_password-error-message" class="errorMessage"></span>
                        </div>
                        
                        <div>
                            <button class="submitBtn" type="submit">Registrovat se</button>
                        </div>
                    </form>

                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="frmLogin.html">Máte účet? Přihlaste se</a>
                    </div>
                </div>
            </div> 
        </main>

        <div class="container">
            <?php require_once "footer.php" ?>
        </div>
        <div class="copyright sz12">&copy; 2024 APEX Medical Center. Všechna práva vyhrazena.</div>
    </div>
<script src="js/registr_validateinput.js"></script>
</body>
</html>