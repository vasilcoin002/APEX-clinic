<header class="header">
    <div class="header_top">
        <div class="container">
            <div class="header_top-inner">
                <a class="header-logo" href="index.php">
                    <div>
                        <img class="company_logo" src="images/logo.png" alt="logo">
                    </div> 
                    <div class="header_logo-text">
                        <div class="sz20">APEX</div>
                        <div class="sz16">Medical</div>
                    </div>
                </a>

                <!--  МЕНЮ! -->
                <nav class="menu">
                    <a <?php if ($page_name === "index") echo 'class="active"'; ?> href="index.php" >Domů</a> 
                    <a <?php if ($page_name === "lekari") echo 'class="active"'; ?> href="lekari.php">Lékaři</a> 
                    <a <?php if ($page_name === "sluzby") echo 'class="active"'; ?> href="sluzby.php">Naše služby</a> 
                    <a <?php if ($page_name === "about") echo 'class="active"'; ?> href="about.php" >О nás</a> 
                    <a <?php if ($page_name === "contacts") echo 'class="active"'; ?> href="contacts.php">Kontakty</a> 
                    <a <?php if ($page_name === "clientaccount") echo 'class="active"'; ?> href="clientaccount.php" id="clientaccount">Osobní účet</a>
                </nav>
                
                <!-- AVATAR LOGIN -->
                <div id="user_avatar" class="header_btn-box"> 
                    <div class="header_user"> 
                        <a href="frmLogin.php">
                            <img class="header_user-avatar" src="./images/avatar.png" height="21" alt="avatar">
                        </a>
                    </div>
                </div>
            <!-- -->

            </div> <!-- header_top-inner -->
        </div> <!-- container -->
    </div> <!-- header_top -->
</header>