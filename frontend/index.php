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
  <link rel="stylesheet" href="css/style.css" media="screen">
  <link rel="stylesheet" href="css/print.css" media="print">
  <title>APEX Medical</title>
</head>

<body>
  <!-- NÁZEV STRÁNKY s MENU a TLAČÍTKY -->
  <div class="wrapper"> 

  <!-- header -->
    <?php 
      $page_name = "index";
      require_once "header.php";
    ?>

    <div class="section_top"> 
      <div class="body_top">
        <div class="left_side">
          <h1 class="section_top_title">
            <span class="txt_style1_uppercase sz48 clblack">Vaše zdraví</span>
            <span class="txt_style2 clblue">je naší prioritou</span>
          </h1>

          <div class="txt_style2 sz18 clblack">
          Moderní zdravotní péče s individuálním přístupem.</div>
          <div class="txt_style2 sz18 clblack">Rezervujte si schůzku online s našimi zkušenými odborníky již dnes.</div>
        
          <section class="features">
            <div class="feature-box">
            <img src="./images/doctor.png" alt="Zkušení lékaři" class="feature-icon">
            <h3>Zkušení lékaři</h3>
            <span>Certifikovaní odborníci</span>
            </div>

            <div class="feature-box">
            <img src="./images/calendar.png" alt="Online rezervace" class="feature-icon">
            <h3>Online rezervace</h3>
            <span>24/7 dostupnost</span>
            </div>

            <div class="feature-box">
            <img src="./images/shield.png" alt="Kvalitní péče" class="feature-icon">
            <h3>Kvalitní péče</h3>
            <span>Moderní vybavení</span>
            </div>
          </section> <!--features-->
        </div> <!--left_side-->
      
        <div class="right_side">
          <img src="images/banner1.jpg" alt="APEX office" class="banner" title="APEX Medical Center">
        </div> <!--right_side-->
      </div>  <!--body_top-->
    </div> <!--section_top-->

              <p class="txt_style2 sz18">Poskytujeme širokou škálu lékařských služeb s týmem odborníků</p>
            <br>

    <main class="main"> 
      <div class="about">
        <div class="container">
          <div class="about_inner">
            <div class="content_list-grid"> 
              <div class="about_content-item">
                <img class="icon" src="./images/stethoscope.png" alt="Praktický lékař ikona" >
                <h3 class="about_content-item-title">Praktický lékař</h3>
                <p class="about_content-item-text">Komplexní základní péče pro celou rodinu</p>
              </div>

              <div class="about_content-item">
                <img class="icon" src="./images/heart.png" alt="Kardiologie ikona" >
                  <h3 class="about_content-item-title">Kardiologie</h3>
                  <p class="about_content-item-text">Diagnostika a léčba srdečních onemocnění</p>
              </div>
              
              <div class="about_content-item">
                <img class="icon" src="./images/baby.png" alt="Pediatrie ikona" >
                <h3 class="about_content-item-title">Pediatrie</h3>
                <p class="about_content-item-text">Specializovaná péče pro děti</p>
              </div>
              
              <div class="about_content-item">
                <img class="icon" src="./images/brain.png" alt="Neurologie ikona" >
                <h3 class="about_content-item-title">Neurologie</h3>
                <p class="about_content-item-text">Péče o nervový systém</p>
              </div>
              
              <div class="about_content-item">
                <img class="icon" src="./images/visible.png" alt="Oftalmologie ikona" >
                <h3 class="about_content-item-title">Oftalmologie</h3>
                <p class="about_content-item-text">Péče o zrak a oční zdraví</p>
              </div> 
              
              <div class="about_content-item">
                <img class="icon" src="./images/tooth.png" alt="Stomatologie ikona" >
                <h3 class="about_content-item-title">Stomatologie</h3>
                <p class="about_content-item-text">Komplexní zubní péče pro zdravý úsměv</p>
              </div>
            </div> <!--content_list-grid-->

            <div class="block_show_all_services">
              <a href="sluzby.html" class="btn_common-blue sz18">
              Zobrazit všechny služby
              </a>
            </div> <!--block_show_all_services-->
            </div> <!--about-->

            <!-- HERO-SECTION -->
            <div class="hero-section">
              <div class="hero-title">
                Připraveni se o vás postarat
              </div>
              <div class="sz16">
                  Rezervujte si schůzku s naším týmem odborníků ještě dnes a začněte svou cestu ke zdravějšímu životu
              </div>

              <div class="hero-buttons">
                <a href="lekari.php" class="btn_common-blue">Prohlédnout lékaře</a>
                <a href="contacts.php" class="btn_common-blue">Kontaktovat nás</a>
              </div>
            </div> 

          </div> 

          <div class="header_row">
            <div class="about_content">
              <img class="doctors-photos" src="./images/nemocnice.jpg" alt="Nemocnice" >
              <img class="doctors-photos"  src="./images/doctors(1).jpg" alt="doctors1" >
              <img class="doctors-photos" src="./images/health.jpg" alt="health" >
            </div>
          </div>   
            
        </div> <!--container-->
        
    </main>  


      <div class="container">
        <?php require_once "footer.php" ?>
      </div>
    <div class="copyright sz12">&copy; 2024 APEX Medical Center. Všechna práva vyhrazena.</div>

  </div> <!-- wrapper -->

</body> 
</html>