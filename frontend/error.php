<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/vars.css" media="screen">
    <link rel="stylesheet" href="css/header-footer.css">
    <title>Chyba | Přístup zakázán - APEX Medical</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Стиль для главного контейнера ошибки */
        .error-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 70vh; 
            text-align: center;
            padding: 40px 20px;
            background-color: #f4f8fb; 
        }

        .error-title {
            font-size: 60px;
            font-weight: 700;
            color: #2c3e50; 
            margin-bottom: 5px;
        }

        .error-subtitle {
            font-size: 32px;
            font-weight: 700;
            color: #1e88e5;
            margin-bottom: 40px;
        }

        .error-message {
            font-size: 18px;
            line-height: 1.6;
            max-width: 600px;
            margin-bottom: 40px;
        }

        .home-link {
            display: inline-block;
            background-color: #1e88e5;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .home-link:hover {
            background-color: #1565c0;
        }

        .icon-bar {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-top: 30px;
        }

        .icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .icon-item p:first-child {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .icon-item p:last-child {
            color: #777;
            font-size: 14px;
        }

    </style>
</head>
<body>

    <?php
        $page_name = "lekari";
        require_once "header.php";
    ?>

    <div class="error-container">
        <h1 class="error-title">CHYBA 403</h1>
        <h2 class="error-subtitle">Přístup zakázán</h2>

        <p class="error-message">
            Litujeme, ale nemáte oprávnění pro přístup k požadovanému zdroji nebo administraci.
            Tato akce byla z bezpečnostních důvodů zaznamenána.
        </p>

        <a href="#" class="home-link">
            Zpět na hlavní stránku
        </a>

        <div class="icon-bar">
            <div class="icon-item">
                <p>🔒 Oprávnění</p>
                <p>Pouze pro administrátory</p>
            </div>
            <div class="icon-item">
                <p>⚠️ Důvod</p>
                <p>Nedostatečná uživatelská role</p>
            </div>
            <div class="icon-item">
                <p>🛡️ Bezpečnost</p>
                <p>Systém je chráněn</p>
            </div>
        </div>
    </div>

</body>
</html>