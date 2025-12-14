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
   <link rel="stylesheet" href="css/lekari.css" media="screen">
   <link rel="stylesheet" href="css/lekari_print.css" media="print">
   <title>Lékaři|APEX Medical</title>
</head>

<body>
<!-- NÁZEV STRÁNKY s MENU a TLAČÍTKY -->
   <div class="wrapper"> 
      <?php
         $page_name = "lekari";
         require_once "header.php";
      ?>
      <div class="container">

         <div class="section_top"> 
            <div class="header_title">
               <h1>Naši lékaři</h1>
               <div class="section_top_title-text">Seznamte se s našim týmem zkušených a certifikovaných odborníků</div>
            </div>
         </div>  <!--section_top-->


         <!-- ГАЛЕРЕЯ ВРАЧЕЙ - 1-й РЯД ВИДЕН, А 2-ОЙ СКРЫТ-->
         <div class="grid_3x3">
            <!-- 1-й ряд * бокс #1 -->
            <div class="bx1">
               <img src="images/Lekari/Lekar1.jpg" class="doctor-photo" alt="Doctor photo">
               <div class="sz20">Dr. Anna Veselá</div>
               <div class="sz16">Neurolog</div>
               <div class="txt_rem sz15">
                  11 let praxe
                  <p> Neurolog se zaměřením na diagnostiku a léčbu nervových onemocnění.</p>
               </div>
               <div class="blok_contact sz14">
                  <img src="images/icon_email.png" width=20 alt="email:"> 
                  <span>anna.vesela@apex.cz</span>
               </div>
               <div>
                  <img src="images/icon_phone.png" width=20 alt="phone:">
                  <span>+420 123 456 794</span>
               </div>
            </div>

            <!-- 1-й ряд * бокс #2 -->
            <div class="bx1">
               <img src="images/Lekari/lekar5.jpg" class="doctor-photo" alt="Doctor photo">
               <div class="sz20">Dr. Eva Svobodová</div>
               <div class="sz16">Kardiolog</div>
               <div class="txt_rem sz15">
                  12 let praxe
                  <p>Kardiolog se zaměřením na preventivní kardiologii a diagnostiku srdečních onemocnění.</p>
               </div>
               <div class="blok_contact sz14">
                  <img src="images/icon_email.png" width=20 alt="email:"> 
                  <span>eva.svobodova@apex.cz</span>
               </div>
               <div>
                  <img src="images/icon_phone.png" width=20 alt="phone:">
                  <span>+420 123 456 790</span>
               </div>

            </div>

            <!-- 1-й ряд * бокс #3 -->
            <div class="bx1">
               <img src="images/Lekari/Lekar3.jpg" class="doctor-photo" alt="Doctor photo">
               <div class="sz20">Dr. Jan Novák</div>
               <div class="sz16">Praktický lékař</div>
               <div class="txt_rem sz15">
                  15 let praxe
                  <p>Zkušený praktický lékař s více než 15 lety praxe. Specializace na prevenci a komplexní péči.</p>
               </div>
               <div class="blok_contact sz14">
                  <img src="images/icon_email.png" width=20 alt="email:"> 
                  <span>jan.novak@apex.cz</span>
               </div>
               <div>
                  <img src="images/icon_phone.png" width=20 alt="phone:">
                  <span>+420 123 456 015</span>
               </div>
            </div>


            <!-- 2-й ряд - ZPOČÁTKU BUDE SKRYTÉ  -->
            <!-- * бокс #1 -->
            <div id="hidden-doctors" class="doctors-hidden-row">
               <div class="bx1">
                  <img src="images/Lekari/lekar9.jpg" class="doctor-photo" alt="Doctor photo">
                  <div class="sz20">Dr. Marie Černá</div>
                  <div class="sz16">Dermatolog</div>
                  <div class="txt_rem sz15">
                     8 let praxe
                     <p> Dermatolog specializující se na léčbu kožních onemocnění a estetickou dermatologii.</p>
                  </div>
                  <div class="blok_contact sz14">
                     <img src="images/icon_email.png" width=20 alt="email:"> 
                     <span>marie.cerna@apex.cz</span>
                  </div>
                  <div>
                     <img src="images/icon_phone.png" width=20 alt="phone:">
                     <span>+420 123 456 792</span>
                  </div>
               </div>

            
               <!-- 2-й ряд * бокс #2 -->
               <div class="bx1">
                  <img src="images/Lekari/lekar8.jpg" class="doctor-photo" alt="Doctor photo">
                  <div class="sz20">Dr. Petr Dvořák</div>
                  <div class="sz16">Pediatr</div>
                  <div class="txt_rem sz15">
                     10 let praxe
                     <p>Dětský lékař s láskou k dětem. Zaměření na prevenci a léčbu běžných dětských onemocnění.</p>
                  </div>
                  <div class="blok_contact sz14">
                     <img src="images/icon_email.png" width=20 alt="email:"> 
                     <span>petr.dvorak@apex.cz</span>
                  </div>
                  <div>
                     <img src="images/icon_phone.png" width=20 alt="phone:">
                     <span>+420 123 456 791</span>
                  </div>
               </div>
               

               <!-- 2-й ряд * бокс #3 -->
               <div class="bx1">
                  <img src="images/Lekari/Lekar4.jpg" class="doctor-photo" alt="Doctor photo">
                  <div class="sz20">Dr. Tomáš Procházka</div>
                  <div class="sz16">Ortoped</div>
                  <div class="txt_rem sz15">
                     14 let praxe
                     <p>Ortoped s expertízou v léčbě pohybového aparátu a sportovních úrazů.</p>
                  </div>
                  <div class="blok_contact sz14">
                     <img src="images/icon_email.png" width=20 alt="email:"> 
                     <span>tomas.prochazka@apex.cz</span>
                  </div>
                  <div>
                     <img src="images/icon_phone.png" width=20 alt="phone:">
                     <span>+420 123 456 777</span>
                  </div>
               </div>
            </div> <!-- 2-ой ряд ГАЛЕРЕИ ВРАЧЕЙ -->

         </div> <!-- ГАЛЕРЕЯ ВРАЧЕЙ - grid_3x3  -->
         
         <!-- КНОПКА "показать больше врачей" -->
         <div class="show-more-button-container">
            <button id="show-more-btn" class="btn_common-blue">
               Zobrazit více lékařů <span class="arrow-icon">▼</span>
            </button>
         </div>
         <!-- КНОПКА "показать больше врачей" -->


      <!-- FOOTER -->
      <div class="container">
         <?php require_once "footer.php" ?>
         <!-- FOOTER -->

      </div> <!--container-->

      </div> <!--container-->
   </div> <!-- wrapper -->  

   <div class="copyright sz12">&copy; 2024 APEX Medical Center. Všechna práva vyhrazena.</div>


   <script src="js/script_Lekari.js"></script>
</body> 
</html>