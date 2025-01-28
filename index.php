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


    <!-- leva -->
    <aside class="leva-strana">
        <div class="vyber">
            <form id="textForm" action="gen_text/generate_text.php" method="post">
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
                <br><br><br>
                <div class="posunuti">
                    <label for="odstavce">Počet odstavců:</label>
                    <input type="text" name="odstavce" id="odstavce">
                    <br><br><br>
                    <label for="slovaOdstavec">Počet slov v jednom odstavci:</label>
                    <input type="text" name="slovaOdstavec" id="slovaOdstavec">
                    <br><br><br>
                    <label id="error-message-gen" style="display: none; color:red; text-align: center;">* Vyplňte prosím všechny povinné údaje</label>
                    <br>
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

        <button id="logoutButton">Odhlásit se</button>
    </div>

    <main class="main-content">
        <div class="button-panel">
            <button id="increase-font" title="Zvětšit písmo">B</button>
            <button id="number-list" title="Číslovaný obsah">1.2.</button>
            <button id="add-dash" title="Přidat pomlčku">-</button>
            <button id="block" title="udělat blok"><svg viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M6.5 11.75C6.08579 11.75 5.75 12.0858 5.75 12.5C5.75 12.9142 6.08579 13.25 6.5 13.25V11.75ZM18.5 13.25C18.9142 13.25 19.25 12.9142 19.25 12.5C19.25 12.0858 18.9142 11.75 18.5 11.75V13.25ZM6.5 15.75C6.08579 15.75 5.75 16.0858 5.75 16.5C5.75 16.9142 6.08579 17.25 6.5 17.25V15.75ZM18.5 17.25C18.9142 17.25 19.25 16.9142 19.25 16.5C19.25 16.0858 18.9142 15.75 18.5 15.75V17.25ZM6.5 7.75C6.08579 7.75 5.75 8.08579 5.75 8.5C5.75 8.91421 6.08579 9.25 6.5 9.25V7.75ZM18.5 9.25C18.9142 9.25 19.25 8.91421 19.25 8.5C19.25 8.08579 18.9142 7.75 18.5 7.75V9.25ZM6.5 13.25H18.5V11.75H6.5V13.25ZM6.5 17.25H18.5V15.75H6.5V17.25ZM6.5 9.25H18.5V7.75H6.5V9.25Z" fill="#000000">
                        </path>
                    </g>
                </svg></button>
        </div>

        <div class="scrollable-block" contenteditable="true">
            <p id="generated-text">
                <?php
                if (isset($_SESSION['generated_text'])) {
                    echo htmlspecialchars($_SESSION['generated_text']);
                    unset($_SESSION['generated_text']);
                } else {
                    echo "Zde se zobrazí vygenerovaný text.";
                }
                ?>
            </p>
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
            <form id="registr-form" method="post">
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