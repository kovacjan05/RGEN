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
$submitData = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $submitData = [
        "firstname" => trim($_POST['firstname'] ?? ''),
        "lastname" => trim($_POST['lastname'] ?? ''),
        "username" => trim($_POST['username'] ?? ''),
        "password" => trim($_POST['password'] ?? ''),
    ];
    if ($submitData['firstname'] === "") $errors[] = "Chybí jméno";
    if ($submitData['lastname'] === "") $errors[] = "Chybí příjmení";
    if ($submitData['username'] === "") $errors[] = "Chybí uživatelské jméno";
    if ($submitData['password'] === "" || strlen($submitData['password'] < 8)) $errors[] = "Heslo musí obsahovat alespň 8 znaků";
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
            <form action="gen_text/generate_text.php" method="post">
                <label for="vyber">Vyber si jazyk</label>
                <select id="vyber" name="vyber">
                    <option value="čeština">Čeština</option>
                    <option value="pravnická čeština">Právnická čeština</option>
                    <option value="latina">Latina</option>
                    <option value="němčina">Němčina</option>
                    <option value="angličtina">Angličtina</option>
                    <option value="slovenština">Slovenština</option>
                    <option value="čapkova čeština">Čapkova čeština</option>
                </select>
                <br><br>
                <div class="posunuti">
                    <label for="odstavce">Počet odstavců:</label>
                    <input type="text" name="odstavce" id="odstavce">
                    <br><br>
                    <label for="slovaOdstavec">Počet slov v jednom odstavci:</label>
                    <input type="text" name="slovaOdstavec" id="slovaOdstavec">
                    <br><br><br><br>
                </div>
                <button class="generate-button" type="submit">Generovat text</button>
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
                Zde se zobrazí vygenerovaný text.
            </p>
        </div>
        </div>


    </main>


    <!-- login -->
    <div class="modal-overlay" id="login-modal">
        <div class="modal-container">
            <button class="close-button" id="close-login-modal">&times;</button>
            <h2>Login</h2>
            <form id="login-form" method="POST" action="login/login.php">
                <br>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <br>
                <label class="error" id="error-message" style="display: none;">* Zadali jste špatné přihlašovací údaje</label>
                <br><br><br>
                <button type="submit">Přihlásit se</button>
            </form>
        </div>
    </div>


    <!-- Registrace -->
    <div class="modal-overlay" id="signup-modal">
        <div class="modal-container">
            <button class="close-button" id="close-signup-modal">&times;</button>
            <h2>Registrace</h2>
            <form id="registr-form">
                <label for="firstname-registr">Firstname:</label>
                <input type="text" id="firstname-registr" name="firstname">
                <br>
                <label for="lastname-registr">Lastname:</label>
                <input type="text" id="lastname-registr" name="lastname">
                <br>
                <label for="username-registr">Username:</label>
                <input type="text" id="username-registr" name="username">
                <br>
                <label for="password-registr">Password:</label>
                <input type="password" id="password-registr" name="password">
                <br>
                <span class="error" id="error-message-registr-empty">* Všechna pole musí být vyplněna.</span>
                <span class="error" id="error-message-registr-password">* Heslo musí mít alespoň 8 znaků.</span>
                <br>
                <button type="submit">Registrovat se</button>
            </form>
        </div>
    </div>

    <script src="js.js"></script>
    <script src="script_errors.js"></script>
    <script src="pokusy.js"></script>
    <!--<script>
        const loginButton = document.getElementById('login-button');
        const loginModal = document.getElementById('login-modal');
        const closeLoginModalButton = document.getElementById('close-login-modal');
        const errorMessageLabel = document.querySelector('.error');

        // Open login modal
        loginButton.addEventListener('click', () => {
            loginModal.style.display = 'flex';
            contentToBlur.forEach(element => element.classList.add('blurred'));
        });

        // Close login modal
        closeLoginModalButton.addEventListener('click', () => {
            loginModal.style.display = 'none';
            contentToBlur.forEach(element => element.classList.remove('blurred'));
        });

        // Show error message if login fails
        <?php if (!empty($errorMessage)): ?>
            errorMessageLabel.textContent = "* <?php echo $errorMessage; ?>";
            loginModal.style.display = 'flex';
            contentToBlur.forEach(element => element.classList.add('blurred'));
        <?php endif; ?>
    </script>-->
</body>

</html>