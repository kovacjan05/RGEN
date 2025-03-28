

/////////////////////////////       posunuti     ///////////////

const selectElement = document.getElementById("vyber");
const posunutiDiv = document.querySelector(".posunuti");

// Funkce pro přidání třídy při zaměření na select
selectElement.addEventListener("focus", () => {
    posunutiDiv.classList.add("posunuto-dolu");
});

// Funkce pro odstranění třídy při změně výběru
selectElement.addEventListener("change", () => {
    posunutiDiv.classList.remove("posunuto-dolu");
    selectElement.blur(); // Programově odstraníme focus
});

// Funkce pro detekci kliknutí mimo select
document.addEventListener("click", (event) => {
    // Zkontrolujeme, jestli kliknutí bylo mimo select
    if (!selectElement.contains(event.target)) {
        posunutiDiv.classList.remove("posunuto-dolu");
    }
});

// Zamezení přidávání/odstraňování třídy na základě samotného selectu
selectElement.addEventListener("blur", (event) => {
    // Zde nic neděláme, protože chceme zachovat třídu, dokud uživatel neklikne mimo
    event.stopPropagation();
});


//////////        modal login       ////////////
document.addEventListener('DOMContentLoaded', function () {
    // Najdeme všechny potřebné elementy s ošetřením null hodnot
    alert("vitej");
    const loginButton = document.getElementById('login-button');
    const signupButton = document.getElementById('signup-button');
    const loginModal = document.getElementById('login-modal');
    const signupModal = document.getElementById('signup-modal');
    const closeLoginModalButton = document.getElementById('close-login-modal');
    const closeSignupModalButton = document.getElementById('close-signup-modal');

    // Ošetření pro contentToBlur - každý element ověříme zvlášť
    const contentToBlur = [
        document.querySelector('main'),
        document.querySelector('.header'),
        document.querySelector('.leva-strana')
    ].filter(element => element !== null); // Filtrujeme pouze existující elementy

    // Funkce pro ověření existence elementů před přístupem
    function safeAddListener(element, event, callback) {
        if (element) {
            element.addEventListener(event, callback);
        } else {
            console.error(`Element ${element} nebyl nalezen!`);
        }
    }

    // Open login modal
    safeAddListener(loginButton, 'click', () => {
        if (loginModal) {
            loginModal.style.display = 'flex';
            contentToBlur.forEach(element => {
                if (element) element.classList.add('blurred');
            });
        }
    });

    // Close login modal
    safeAddListener(closeLoginModalButton, 'click', () => {
        if (loginModal) {
            loginModal.style.display = 'none';
            contentToBlur.forEach(element => {
                if (element) element.classList.remove('blurred');
            });
        }
    });

    // Open signup modal
    safeAddListener(signupButton, 'click', () => {
        if (signupModal) {
            signupModal.style.display = 'flex';
            contentToBlur.forEach(element => {
                if (element) element.classList.add('blurred');
            });
        }
    });

    // Close signup modal
    safeAddListener(closeSignupModalButton, 'click', () => {
        if (signupModal) {
            signupModal.style.display = 'none';
            contentToBlur.forEach(element => {
                if (element) element.classList.remove('blurred');
            });
        }
    });

    // Ošetření registračního formuláře
    const registrForm = document.getElementById('registr-form');
    if (registrForm) {
        registrForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Zde by byla validace a odeslání dat
            // Pro ukázku jen zavřeme modal po 1 vteřině
            setTimeout(() => {
                if (signupModal) {
                    signupModal.style.display = 'none';
                    contentToBlur.forEach(element => {
                        if (element) element.classList.remove('blurred');
                    });
                }
            }, 1000);
        });
    }
});


function openUserMenu() {

    const logoutBox = document.querySelector('.logoutBox');

    //Přepínání viditelnosti boxu
    if (logoutBox.style.display === 'none' || logoutBox.style.display === '') {
        logoutBox.style.display = 'block';

    } else {
        logoutBox.style.display = 'none';
    }
}


document.getElementById('logoutButton').addEventListener('click', function () {
    fetch('logout.php')
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                console.error('Chyba při odhlašování.');
            }
        });
});

//////////////// alert registr/////////////////
function showAlert(message) {
    const alert = document.createElement('div');
    alert.classList.add('alert');
    alert.textContent = message;

    const alertContainer = document.getElementById('alert-container');
    alertContainer.appendChild(alert);
    serTimeout(() => {
        alert.remove();
    }, 6000);
}
function validateForm(event) {
    const firstname = document.getElementById('firstname').ariaValueMax.trim();
    const lastname = document.getElementById('lastname').ariaValueMax.trim();
    const username = document.getElementById('username').ariaValueMax.trim();
    const password = document.getElementById('password').ariaValueMax.trim();
    let errors = [];
    if (firstname === "") errors.push("Chybí jméno");
    if (lastname === "") errors.push("Chybí příjmení");
    if (username === "") errors.push("Chybí uživatelské jméno");
    if (password === "" || password.length < 8) errors.push("Heslo musí obsahovat alespň 8 znaků");

    if (errors.length > 0) {
        event.preventDefault();
        errors.forEach(error => showAlert(error));
        return false;
    }
    showAlert("Úspěšné přihlášení");
    return true;
}
document.getElementById('signup-modal').addEventListener('submit', validateForm);




