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
  <link rel="stylesheet" href="css/about.css" media="screen">
  <link rel="stylesheet" href="css/about_print.css" media="print">
  <title>About|APEX Medical</title>
</head>

<body>
  <!-- ЗАГОЛОВОК САЙТА с МЕНЮ и КНОПКАМИ -->
  <div class="wrapper"> 
    
    <?php 
        $page_name = "about";
        require_once "header.php";
    ?>
    <div class="container">

      <div class="section_top"> 
            <h1>О nás</h1>
        <div class="header_title">
            <div class="section_top_title-text">Poskytujeme špičkovou zdravotní 
              péči již více než 25 let</div>
            </div>
        </div>
    </div>


      
      <div class="about_text">
        <p>APEX Medical je moderní multifunkční zdravotnické centrum, kde je vaše 
          zdraví a pohoda naší nejvyšší prioritou.
        </p>
        
        <p>Spojujeme pokročilé lékařské technologie, mezinárodní standardy léčby a tým vysoce 
          kvalifikovaných specialistů, abychom vám poskytli komplexní a individuální přístup k péči o zdraví.
        </p> 
        
        <div class="about_image-box">
        <img src="images/clinic_interior_1.jpg" alt="Moderní interiér kliniky APEX Medical">
        <img src="images/clinic_interior_2.jpg" alt="Moderní interiér kliniky APEX Medical">
        <img src="images/clinic_interior_3.jpg" alt="Moderní interiér kliniky APEX Medical">
        </div>

        <h2>Naše klíčové výhody:</h2>
          <div>
            <ul>
              <li>Komplexní přístup: Široké spektrum služeb od všeobecného lékařství a pediatrie 
                po úzce specializované obory, jako je kardiologie, ortopedie a endokrinologie.</li> 
              <li>Zkušení specialisté: Náš tým se skládá z lékařů s mezinárodními zkušenostmi a vysokou 
                kvalifikací, kteří neustále zdokonalují své znalosti.</li>
              <li>Moderní vybavení: Používáme inovativní diagnostické a léčebné přístroje pro přesnou 
                diagnostiku a efektivní léčbu.</li>
              <li>Služby zaměřené na pacienta: Vážíme si vašeho času a pohodlí, a proto nabízíme pohodlné 
                objednávání, online konzultace (v případě potřeby) a individuální péči.</li>
            </ul>
          </div>


        <div class="grid">  
          <div>
            <h2>Oblasti působnosti:</h2>
              <ul>
                <li>Rodinné lékařství a pediatrie</li>
                <li>Diagnostika (ultrazvuk, laboratorní vyšetření)</li>
                <li>Ženské a mužské zdraví</li>
                <li>Kardiologie a neurologie</li>
                <li>Fyzická rehabilitace</li>
              </ul>
            </div>
            <img src="images/logo.png" class="logo-box alt="APEX Medical">
        </div>  <!-- grid -->

    </div> <!--container-->
  
  


        <!-- FOOTER -->
         <?php require_once "footer.php" ?>   
        <!-- FOOTER -->


  <div class="copyright sz12">&copy; 2024 APEX Medical Center. Všechna práva vyhrazena.</div>

  </div> <!-- wrapper -->

</body>   
</html>