<?php
session_start();

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
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
</head>



<body>
    <header class="header">
        <div class="navbar">
            <h1 class="logo">RGEN</h1>
            <div class="button-group">
                <?php if ($isLoggedIn): ?>
                    <button class="user-button" onclick="openUserMenu()">
                        <?php echo strtoupper($username[0]); ?>
                    </button>
                <?php else: ?>
                    <button id="login-button">Login</button>
                    <button id="signup-button">Registrace</button>
                <?php endif; ?>
            </div>
        </div>
    </header>

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

    <div class="logoutBox">
        <div class="logoutBoxText">
            <div class="nadpis">
                <?php echo htmlspecialchars($username ?? ''); ?>
            </div>
            <br>
            <br>
            <div class="safe-text">
                <li>Naposledy uložený text</li>
                <button onclick="JESTENEVIM"><svg fill="#000000" width="64px" height="64px" viewBox="0 0 64.00 64.00" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" stroke="#000000" stroke-width="0.00064">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <rect id="Icons" x="-896" y="-128" width="1280" height="800" style="fill:none;"></rect>
                            <g id="Icons1" serif:id="Icons">
                                <g id="Strike"> </g>
                                <g id="H1"> </g>
                                <g id="H2"> </g>
                                <g id="H3"> </g>
                                <g id="list-ul"> </g>
                                <g id="hamburger-1"> </g>
                                <g id="hamburger-2"> </g>
                                <g id="list-ol"> </g>
                                <g id="list-task"> </g>
                                <g id="trash"> </g>
                                <g id="vertical-menu"> </g>
                                <g id="horizontal-menu"> </g>
                                <g id="sidebar-2"> </g>
                                <g id="Pen"> </g>
                                <g id="Pen1" serif:id="Pen"> </g>
                                <g id="clock"> </g>
                                <g id="external-link"> </g>
                                <g id="hr"> </g>
                                <g id="info"> </g>
                                <g id="warning"> </g>
                                <g id="plus-circle"> </g>
                                <g id="minus-circle"> </g>
                                <g>
                                    <path id="caret-down" d="M45.274,29.772c-1.094,-8.15 -8.075,-14.435 -16.525,-14.435c-9.203,0 -16.674,7.471 -16.674,16.674c0,9.203 7.471,16.675 16.674,16.675c4.423,0 8.664,-1.757 11.791,-4.884l2.862,2.863c-3.886,3.886 -9.157,6.069 -14.653,6.069c-11.437,0 -20.723,-9.285 -20.723,-20.723c0,-11.437 9.286,-20.723 20.723,-20.723c10.623,0 19.379,7.994 20.582,18.294l3.551,-3.551l3.118,3.117l-8.792,8.792l-8.796,-8.796l3.118,-3.117l3.744,3.745Z" style="fill-rule:nonzero;"></path>
                                </g>
                                <g id="vue"> </g>
                                <g id="cog"> </g>
                                <g id="logo"> </g>
                                <g id="radio-check"> </g>
                                <g id="eye-slash"> </g>
                                <g id="eye"> </g>
                                <g id="toggle-off"> </g>
                                <g id="shredder"> </g>
                                <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                <g id="react"> </g>
                                <g id="check-selected"> </g>
                                <g id="turn-off"> </g>
                                <g id="code-block"> </g>
                                <g id="user"> </g>
                                <g id="coffee-bean"> </g>
                                <g id="coffee-beans">
                                    <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                </g>
                                <g id="coffee-bean-filled"> </g>
                                <g id="coffee-beans-filled">
                                    <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                </g>
                                <g id="clipboard"> </g>
                                <g id="clipboard-paste"> </g>
                                <g id="clipboard-copy"> </g>
                                <g id="Layer1"> </g>
                            </g>
                        </g>
                    </svg></button>
                <button onclick="JESTENEVIM"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z" fill="#0F0F0F"></path>
                        </g>
                    </svg></button>
            </div>
        </div>
        <button id="logoutButton">Odhlásit se</button>
    </div>

    <main class="main-content">
        <div class="button-panel">
            <button id="increase-font" title="Zvětšit písmo">B</button>
            <button id="number-list" title="Číslovaný obsah">1.2.</button>
            <button id="add-dash" title="Přidat pomlčku">-</button>
        </div>

        <div id="editor">
            <div>
                <div>
                    <?php
                    if (isset($_SESSION['generated_text']) && is_array($_SESSION['generated_text'])) {
                        foreach ($_SESSION['generated_text'] as $paragraph) {
                    ?>
                            <p><?php echo  ucfirst(htmlspecialchars($paragraph) . "."); ?></p>

                        <?php
                        }
                        unset($_SESSION['generated_text']);
                    } else {
                        ?>
                        <p>Zde se zobrazí vygenerovaný text.</p>
                    <?php
                    }
                    ?>
                </div>

            </div>

            <div><br /></div>
        </div>
    </main>

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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });
    </script>
</body>

</html>