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
  <link rel="stylesheet" href="css/vars.css">

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
                      <h2>Osobní a kontaktní údaje</h2>
                      <form action="#" method="POST" class="data-form">
                          <div class="form-group">
                              <label for="prijmeni">Příjmení:</label>
                              <input type="text" id="prijmeni" name="prijmeni" value="Nováková" required>
                          </div>
                          <div class="form-group">
                              <label for="jmeno">Jméno:</label>
                              <input type="text" id="jmeno" name="jmeno" value="Klára" required>
                          </div>
                          <div class="form-group">
                              <label for="telefon">Telefon:</label>
                              <input type="tel" id="telefon" name="telefon" value="+420 123 456 789" required>
                          </div>
                          <div class="form-group">
                              <label for="email">E-mail:</label>
                              <input type="email" id="email" name="email" value="klara.novakova@email.cz" required>
                          </div>
                          
                          <button type="submit" class="save-button">Uložit změny údajů</button>
                      </form>
                      
                      <hr class="separator"> <div class="password-section">
                          <h2>Změna hesla</h2>
                          <form action="#" method="POST" class="password-form">
                              <div class="form-group">
                                  <label for="current-password">Aktuální heslo:</label>
                                  <input type="password" id="current-password" name="current-password" required>
                              </div>
                              <div class="form-group">
                                  <label for="new-password">Nové heslo:</label>
                                  <input type="password" id="new-password" name="new-password" required>
                              </div>
                              <div class="form-group">
                                  <label for="confirm-password">Potvrzení nového hesla:</label>
                                  <input type="password" id="confirm-password" name="confirm-password" required>
                              </div>
                              
                              <button type="submit" class="save-button password-button">Změnit heslo</button>
                          </form>
                          
                          <p class="save-confirmation password-success-msg" style="display: none;">Heslo bylo úspěšně změněno!</p>
                      </div>
                      
                      <p class="save-confirmation data-success-msg" style="display: none;">Údaje byly úspěšně uloženy!</p>
                  </div>

                  <div class="info-box notes-data-box">
                      <h2>Moje zdravotní poznámky</h2>
                      <form action="#" method="POST">
                          <div class="form-group">
                              <label for="health-notes">Poznámky (pro Vás a Vašeho lékaře):</label>
                              <textarea id="health-notes" name="health-notes" rows="10" placeholder="Zde můžete psát poznámky o svém zdraví, které chcete mít na jednom místě, např. reakce na léky, otázky pro lékaře, apod."></textarea>
                          </div>
                          <button type="submit" class="save-button">Uložit poznámky</button>
                      </form>
              </div>
          </div>
      </div>
  </div>

<!-- <script src="js/clientaccount.js"></script> -->

</body>
</html>