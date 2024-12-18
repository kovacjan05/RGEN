<?php
session_start();

// Simulace přihlášení - toto nahradíte logikou podle vaší aplikace
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGEN</title>
    <link rel="stylesheet" href="css/css.css">

</head>
<?php
$errors = [];
$submitData =[];
if ($_SERVER['REQUEST_METHOD']==="POST") {
    $submitData=[
        "firstname"=>trim($_POST['firstname']??''),
        "lastname"=>trim($_POST['lastname']??''),
        "username"=>trim($_POST['username']??''),
        "password"=>trim($_POST['password']??''),
    ];
    if($submitData['firstname'] === "") $errors[] = "Chybí jméno";
    if($submitData['lastname'] === "") $errors[] = "Chybí příjmení";
    if($submitData['username'] === "") $errors[] = "Chybí uživatelské jméno";
    if($submitData['password'] === "" || strlen($submitData['password']<8)) $errors[] = "Heslo musí obsahovat alespň 8 znaků";
}

?>




<body>
    <!-- Navbar -->
    <header class="header">
        <div class="navbar">
            <h1 class="logo">RGEN</h1>
            <div class="button-group">
                <?php if ($isLoggedIn): ?>
                    <!-- Tlačítko s iniciálou uživatelského jména -->
                    <button class="user-button" onclick="openUserMenu()">
                        <?php echo strtoupper($username[0]); // První písmeno uživatelského jména 
                        ?>
                    </button>



                <?php else: ?>
                    <!-- Tlačítka pro nepřihlášené uživatele -->
                    <button id="login-button">Login</button>
                    <button id="signup-button">Registrace</button>
                <?php endif; ?>
            </div>
        </div>
    </header>


    <!-- Sidebar -->
    <aside class="leva-strana">
        <div class="vyber">
            <form action="" method="post">
                <label for="vyber">Vyber si jazyk</label>
                <select id="vyber" name="vyber">
                    <option value="čeština">Čeština</option>
                    <option value="pravnická čeština">Právnická čeština</option>
                    <option value="latina">Latina</option>
                    <option value="němčina">Němčina</option>
                    <option value="angličtina">Angličtina</option>
                </select>
                <br><br>
                <div class="posunuti">
                    <label for="odstavce">Počet odstavců:</label>
                    <input type="text" name="odstavce" id="odstavce">
                    <br><br>
                    <label for="slovaOdstavec">Počet slov v jednom odstavci:</label>
                    <input type="text" name="slovaOdstavec" id="slovaOdstavec">
                </div>
            </form>
        </div>
    </aside>
    <!-- Prava strana -->
    <div class="logoutBox">
        <div class="logoutBoxText">
            <div class="nadpis">
                <?php echo "$username"; ?>
            </div>
            <br>
            <br>
            <li>Naposledy uložený text</li>
        </div>

        <button onclick="window.location.href='logout/logout.php'">Odhlásit se</button>
    </div>



    <main class="main-content">
        <!-- Panel s tlačítky pro úpravy textu -->
        <div class="button-panel">
            <button id="increase-font" title="Zvětšit písmo">B</button>
            <button id="number-list" title="Číslovaný obsah">1.2.</button>
            <button id="add-dash" title="Přidat pomlčku">-</button>
        </div>

        <!-- Scrollable block -->
        <div class="scrollable-block" contenteditable="true">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque perspiciatis est amet vel maxime sint
                odio eos rem velit? Officiis atque vero voluptatem officia blanditiis pariatur laboriosam explicabo
                minus repellendus.
            </p>
        </div>


    </main>


    <!-- login -->
    <div class="modal-overlay" id="login-modal">
        <div class="modal-container">
            <button class="close-button" id="close-login-modal">&times;</button>
            <h2>Login</h2>
            <form method="POST" action="login/login.php">
                <br>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <br>
                <label class="error" for="error">* Zadali jste špatné přihlašovací údaje</label>
                <br><br><br>
                <button type="submit">Přihlásit se</button>
            </form>
        </div>
    </div>

    <!-- registr -->
    <div class="modal-overlay" id="signup-modal">
        <div class="modal-container">
            <button class="close-button" id="close-signup-modal">&times;</button>
            <h2>Registrace</h2>
            <form method="POST" action="register/register.php">
                <br>
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname"value="<?=htmlspecialchars($submitData['firstname']??'')?>">
                <br>
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname"value="<?=htmlspecialchars($submitData['lastname']??'')?>">
                <br>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"value="<?=htmlspecialchars($submitData['username']??'')?>">
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"value="<?=htmlspecialchars($submitData['password']??'')?>">
                <br>
                <label class="error" for="error">* Zadali jste špatné přihlašovací údaje</label>
                <br><br><br>
                <button type="submit">registrovat se</button>
            </form>
        </div>
    </div>

    <script src="js.js"></script>

</body>

</html>