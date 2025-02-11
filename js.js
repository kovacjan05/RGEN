

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


const loginButton = document.getElementById('login-button');
const signupButton = document.getElementById('signup-button');
const loginModal = document.getElementById('login-modal');
const signupModal = document.getElementById('signup-modal');
const closeLoginModalButton = document.getElementById('close-login-modal');
const closeSignupModalButton = document.getElementById('close-signup-modal');
const contentToBlur = [document.querySelector('main'), document.querySelector('.header'), document.querySelector('.leva-strana')];

//Open login modal
loginButton.addEventListener('click', () => {
    loginModal.style.display = 'flex';
    contentToBlur.forEach(element => element.classList.add('blurred'));
    console.log("past");
});

//Close login modal
closeLoginModalButton.addEventListener('click', () => {
    loginModal.style.display = 'none';
    contentToBlur.forEach(element => element.classList.remove('blurred'));
});

//Open signup modal
signupButton.addEventListener('click', () => {
    signupModal.style.display = 'flex';
    contentToBlur.forEach(element => element.classList.add('blurred'));
});

//Close signup modal
closeSignupModalButton.addEventListener('click', () => {
    signupModal.style.display = 'none';
    contentToBlur.forEach(element => element.classList.remove('blurred'));
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


document.getElementById('logout-button').addEventListener('click', function () {
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




///////////////////////////    save text    ////////////////

