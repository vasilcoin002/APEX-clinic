<?php session_start() ?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='images/favicon.png' rel="shortcut icon" type="image/x-icon">
  <link rel="stylesheet" href="css/vars.css" media="screen">
  <link rel="stylesheet" href="css/vars_print.css" media="print">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/header-footer.css">
  <link rel="stylesheet" href="css/responsive/header-footer.css">
  <link rel="stylesheet" href="css/contacts.css" media="screen">
  <link rel="stylesheet" href="css/print.css" media="print">
  <link rel="stylesheet" href="css/contacts_print.css" media="print">
  <title>Kontakty|APEX Medical</title>
</head>

<body>
  <!-- ЗАГОЛОВОК САЙТА с МЕНЮ и КНОПКАМИ -->
  <div class="wrapper">

    <?php 
        $page_name = "contacts";
        require_once "header.php";
    ?>

    <div class="PageContent">
      
      <section class="section_top"> 
        <h1>Kontaktujte nás</h1>
        <div class="header_title">
          <div class="section_top_title-text">Ať už máte dotazy, zpětnou vazbu 
            nebo potřebujete pomoc, náš tým je tu, aby vám pomohl.
          </div>
                    </div>  <!--header_title-->
        </section>


      <div class="grid">
        <div class="contact_info">
            <h2>Naše kontakty:</h2>
            <div><img src="images/icon_email.png" width=27 alt="email:"> <span class="email sz22"> info@apex-medical.cz</span></div>
            <div><img src="images/icon_phone.png" width=27 alt="phone:"> <span class="phone">+420 123 456 000</span></div>
            <div><img src="images/icon_address.png" width=27 alt="address:"> <span class="address">Hlavní třída 123, Praha-1, 110 00</span></div>
            
            <section class="section_hours">
                <h2>Otevírací doba a pohotovost</h2>
                <div class="hours-grid">
                    <div class="sz16">Běžná ordinační doba:</div>
                    <ul>
                        <li>Po-Pá: 7:00 – 20:00</li>
                        <li>So: 8:00 – 16:00</li>
                        <li>Ne: 9:00 – 14:00</li>
                    </ul>
                </div>
                
            </section>
        </div> <section class="contact_form">
          <div class="emergency">
                    <p class="red_bold sz20">Pohotovostní služba (Emergency):
                    <span class="emergency-phone">+420 123 456 001</span></p>
                    <p class="sz18">V případě akutních stavů nás kontaktujte na speciální lince. <br></p>
                    <p class="green_bold sz20">24 hodin denně, 7 dní v týdnu</p>
                </div>

            <!-- <h2>Napište nám zprávu:</h2>
            <form class="contact-form">
                <label for="name">Jméno a příjmení:</label>
                <input type="text" id="name" name="name" required>
                <label for="email_form">Váš E-mail:</label>
                <input type="email" id="email_form" name="email" required>
                <label for="phone_form">Telefon (nepovinné):</label>
                <input type="tel" id="phone_form" name="phone">
                <label for="message">Vaše zpráva:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
                <button type="submit" class="btn_common-blue">Odeslat zprávu</button>
            </form> -->
        </section> 
      </div>





      <!-- FOOTER -->
        <?php require_once "footer.php" ?>
      <!-- FOOTER -->     

    </div> <!--PageContent-->
  </div> <!-- wrapper -->  

  <div class="copyright sz12">&copy; 2024 APEX Medical Center. Všechna práva vyhrazena.</div>

</body> 
</html>