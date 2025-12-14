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
  <link rel="stylesheet" href="css/sluzby.css" media="screen">
  <link rel="stylesheet" href="css/sluzby_print.css" media="print">

  <title>Naše služby|APEX Medical</title>
</head>



<body>
  <!-- ЗАГОЛОВОК САЙТА с МЕНЮ и КНОПКАМИ -->
  <div class="wrapper"> 
    
    <?php 
        $page_name = "sluzby";
        require_once "header.php";
    ?>

    <div class="container">

      <section class="section_top"> 
        <div class="header_title">
            <h1>Naše služby</h1>
            <div class="section_top_title-text">Poskytujeme komplexní zdravotní péči s moderním vybavením a zkušeným týmem</div>
        </div>
      </section>


      <!-- ГАЛЕРЕЯ УСЛУГ - 6 БОКСОВ В 2 РЯДАХ ПО 3 БОКСА
      #####################################################################################  -->      
      <div class="grid_3x3">
        <!-- 1-й ряд * 3 бокса -->
        <!-- box 1/1 -->
        <div class="bx2">
            <div class="di-flex">
              <div><h3>EKG vyšetření</h3></div>
            </div>
            <div class="txt_rem sz16">Elektrokardiografické vyšetření srdce</div>
            <div class="txt_rem sz14">Karel Novotný</div>
            <div class="inline">
              <div class="img_style"><img src="images/icon_clock.png" width=23 alt="time duration:"> 
                <span class="email-contacts">20 minut</span>
              </div>
              <div class="blue_bold sz24">900 Kč</div>
          </div> 
        </div>

        <!-- box 1/2 -->
        <div class="bx2">
          <div class="di-flex">
              <div><h3>Konzultace specialisty</h3></div>
          </div>
            <div class="txt_rem sz16">Odborná konzultace s lékařem specialistou</div>
            <div class="txt_rem sz14">Lucie Malá</div>
          <div class="inline">
            <div class="img_style"><img src="images/icon_clock.png" width=23 alt="time duration:"> 
              <span class="email-contacts">40 minut</span>
            </div>
            <div class="blue_bold sz24">1000 Kč</div>
          </div> 
        </div>
        
        <!-- box 1/3 -->
        <div class="bx2">
          <div class="di-flex">
            <div><h3>Krevní testy</h3></div>
          </div>
          <div class="txt_rem sz16">Odběr a vyhodnocení základních krevních testů</div>
          <div class="txt_rem sz14">Pavel Horák</div>
          <div class="inline">
            <div class="img_style"><img src="images/icon_clock.png" width=23 alt="time duration:"> 
              <span class="email-contacts">30 minut</span>
            </div>
            <div class="blue_bold sz24">1200 Kč
            </div>
          </div> 
        </div>

         <!-- 2-ой ряд * 3 бокса -->
        <!-- box 2/1 -->
        <div class="bx2">
          <div class="di-flex">
            <div><h3>Očkování</h3></div>
          </div>
              <div class="txt_rem sz16">Aplikace vakcíny podle typu</div>
              <div class="txt_rem sz14">Tereza Novakova</div>
          <div class="inline">
            <div class="img_style"><img src="images/icon_clock.png" width=23 alt="time duration:"> 
              <span class="email-contacts">15 minut</span>
            </div>
            <div class="blue_bold sz24">400 Kč</div>
            </div> 
        </div>

        <!-- box 2/2 -->
          <div class="bx2">
            <div class="di-flex">
              <div><h3>Preventivní prohlídka</h3></div>
            </div>
              <div class="txt_rem sz16">Komplexní preventivní prohlídka včetně základních vyšetření</div>
              <div class="txt_rem sz14">Eva Svobodová</div>
            <div class="inline">
              <div class="img_style"><img src="images/icon_clock.png" width=23 alt="time duration:"> 
                <span class="email-contacts">30 minut</span>
              </div>
              <div class="blue_bold sz24">800 Kč
              </div>
            </div> 
          </div>

          <!-- box 2/3 -->
          <div class="bx2">
            <div class="di-flex">
              <div><h3>Ultrazvukové vyšetření</h3></div>
            </div>
              <div class="txt_rem sz16">UZ vyšetření podle potřeby</div>
              <br>
              <div class="txt_rem sz14">Jan Dvořák</div>
            <div class="inline">
              <div class="img_style"><img src="images/icon_clock.png" width=23 alt="time duration:"> 
                <span class="email-contacts">30 minut</span>
              </div>
              <div class="blue_bold sz24">1500 Kč
              </div>
            </div> 
          </div>
      </div>
      <!-- #####################################################################################  -->



        <!-- FOOTER -->
         <?php require_once "footer.php" ?>   
        <!-- FOOTER -->


    </div> <!--container-->
  
  </div> <!-- wrapper -->

  <div class="copyright sz12">&copy; 2024 APEX Medical Center. Všechna práva vyhrazena.</div>


  <!-- Подключение внешнего файла script.js -->
  <!-- <script src="js/script.js"></script> -->
</body> 
</html>