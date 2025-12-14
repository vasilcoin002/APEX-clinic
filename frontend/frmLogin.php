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
    <link rel="stylesheet" href="css/frmlogin.css"> 
    <title>APEX Medical - Přihlášení</title>
</head>
<body>
    <div class="wrapper">
        <?php 
            $page_name = "login";
            require_once "header.php";
        ?>
        <main class="main">
            <div class="container center-form-container">
                
                <div class="frmCommon">
                    <h2>Přihlášení</h2>
                    
                    

                    <!-- ФОРМА LOGIN -->
                    <form action="../users/userController.php" method="post">
                        
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" id="email" name="email">
                            <span id="email-error-message" class="errorMessage"></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Heslo:</label>
                            <input type="password" id="password" name="password">
                            <span id="password-error-message" class="errorMessage"></span>
                        </div>
                        
                        <div>
                            <button class="submitBtn" name="action" value="login">Přihlásit se</button>
                        </div>
                    </form>

                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="frmRegister.php">Nemáte účet? Zaregistrujte se</a>
                    </div>
                </div>
            </div>
        </main>
        <div class="copyright sz12">&copy; 2024 APEX Medical Center. Všechna práva vyhrazena.</div>
    </div>

<script src="js/login_validateinput.js"></script>
</body>
</html>