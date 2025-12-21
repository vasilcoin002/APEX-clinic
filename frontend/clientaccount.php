<?php 
    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("Location: frmLogin.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='images/favicon.png' rel="shortcut icon" type="image/x-icon">
<link rel="stylesheet" href="css/header-footer.css">
<link rel="stylesheet" href="css/vars.css" media="screen">
<link rel="stylesheet" href="css/vars_print.css" media="print">
<link rel="stylesheet" href="css/clientaccount.css">

<title>APEX Medical</title>
</head>

<body>
<!-- ЗАГОЛОВОК САЙТА с МЕНЮ и КНОПКАМИ -->
    <div class="wrapper"> 
    <?php
        $page_name = "clientaccount";
        require_once "header.php";
    ?>
        <div class="PageContent">
            <div class="body_top">
                <div class="section_top">
                    <div class="account-container">
                        <h1 class="account-title">Osobní účet | APEX Medical</h1>
                        <div class="account-sections-wrapper">
                            <div class="info-box personal-data-box">
                                <div class="avatar-container">
                                    <label for="avatar-upload">
                                        <img src="" alt="Avatar zatím nenastáven" id="user-avatar-placeholder" class="user-avatar">
                                    </label>
                                    <span id="avatar-error-message" class="error-message"></span>
                                    <div class="avatar-controls">
                                        <form action="../users/userController.php" method="POST" enctype="multipart/form-data" id="avatar-form">
                                            <input type="file" name="avatar" id="avatar-upload" accept="image/*">
                                            <button type="button" class="action-button primary-button" id="update-avatar-button">
                                                Změnit avatar
                                            </button>
                                            <button type="button" class="action-button secondary-button" id="delete-avatar-button">
                                                Odstranit avatar
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <hr class="separator">
                                <div class="password-section">
                                    <h2>Přístupové údaje</h2>
                                    <form action="#" method="POST" id="email-form">
                                        <div class="form-group">
                                            <label for="email">E-mail*:</label>
                                            <input type="email" id="email" name="email">
                                            <span id="email-error-message"></span>
                                        </div>
                                        <button type="submit" class="save-button">Uložit změny</button>
                                    </form>
                                    <hr class="separator">
                                    <form action="#" method="POST" id="password-form">
                                        <div class="form-group">
                                            <label for="password">Nové heslo*:</label>
                                            <input type="password" id="password" name="password">
                                            <span id="password-error-message"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm-password">Potvrďte heslo*:</label>
                                            <input type="password" id="confirm-password" name="confirm-password">
                                            <span id="confirm-password-error-message"></span>
                                        </div>
                                        <button type="submit" class="save-button">Uložit změny</button>
                                    </form>
                                    <hr class="separator">
                                    <form action="#" method="POST" id="logout-form">
                                        <button type="submit" class="action-button secondary-button">
                                            Odhlásit se
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="info-box notes-data-box">
                                <form action="#" method="POST" id="personal-data-form">
                                    <h2>Osobní a kontaktní údaje</h2>
                                    <div class="form-group">
                                        <label for="name">Jméno*:</label>
                                        <input type="text" id="name" name="name">
                                        <span id="name-error-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="surname">Příjmení*:</label>
                                        <input type="text" id="surname" name="surname">
                                        <span id="surname-error-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Telefon*:</label>
                                        <input type="tel" id="phone" name="phone">
                                        <span id="phone-error-message"></span>
                                    </div>
                                    <h2>Moje zdravotní poznámky</h2>
                                    <div class="form-group">
                                        <label for="comment">Poznámky (pro Vás a Vašeho lékaře):</label>
                                        <textarea id="comment" name="comment" rows="10" placeholder="Zde můžete psát poznámky o svém zdraví, které chcete mít na jednom místě, např. reakce na léky, otázky pro lékaře, apod."></textarea>
                                        <span id="comment-error-message"></span>
                                    </div>
                                    <button type="submit" class="save-button">Uložit změny</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="js/clientaccount.js"></script>
</body>
</html>