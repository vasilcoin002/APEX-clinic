<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/vars.css" media="screen">
    <link rel="stylesheet" href="css/header-footer.css">
    <link rel="stylesheet" href="css/errorPage.css">
    <title>Chyba | Přístup zakázán - APEX Medical</title>
</head>
<body>

    <?php
        $page_name = "chyba";
        require_once "header.php";
    ?>

    <div class="error-container">
        <h1 class="error-title">CHYBA 403</h1>
        <h2 class="error-subtitle">Přístup zakázán</h2>

        <p class="error-message">
            Litujeme, ale nemáte oprávnění pro přístup k administrační paneli.
        </p>

        <a href="index.php" class="home-link">
            Zpět na hlavní stránku
        </a>
    </div>

</body>
</html>