const selectElement = document.getElementById("vyber");
const posunutiDiv = document.querySelector(".posunuti");

// Přidáme třídu při zaměření na select
selectElement.addEventListener("focus", () => {
    posunutiDiv.classList.add("posunuto-dolu");
});

// Odstraníme třídu při opuštění selectu
selectElement.addEventListener("blur", () => {
    posunutiDiv.classList.remove("posunuto-dolu");
});

// Odstraníme třídu při změně výběru a zároveň odstraníme focus
selectElement.addEventListener("change", () => {
    posunutiDiv.classList.remove("posunuto-dolu");
    selectElement.blur(); // Programově odstraníme focus, aby už nešlo znovu rozkliknout
});

// Získání tlačítka pro změnu stylu textu
const increaseFontButton = document.getElementById('increase-font');

// Funkce pro ztučnění nebo odtučnění označeného textu
increaseFontButton.addEventListener('click', () => {
    const selection = window.getSelection();

    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);
        const selectedText = selection.toString();

        if (selectedText.length > 0) {
            // Vytvoření obalujícího prvku
            const span = document.createElement('span');
            span.innerHTML = selectedText;

            // Pokud je výběr uvnitř <strong>, odtučnit ho
            if (range.startContainer.parentNode.nodeName === 'STRONG' || range.endContainer.parentNode.nodeName === 'STRONG') {
                const parentStrong = range.startContainer.parentNode.closest('strong');

                if (parentStrong) {
                    // Nahradíme <strong> prvkem, který zachovává text, ale bez tučného stylu
                    const newNode = document.createTextNode(selectedText);
                    parentStrong.replaceWith(newNode);
                }
            } else {
                // Pokud není tučný, obalit výběr do <strong>
                const strong = document.createElement('strong');
                strong.textContent = selectedText;

                // Nahradíme výběr novým <strong> elementem
                range.deleteContents();
                range.insertNode(strong);
            }

            // Vyčištění výběru
            selection.removeAllRanges();
        }
    }
});



///////         pomlcka         ///////

// Získání tlačítka pro přidání pomlčky
const addDashButton = document.getElementById('add-dash');

// Funkce pro přidání pomlčky na nový řádek a pokračování textu na stejném řádku
addDashButton.addEventListener('click', () => {
    const selection = window.getSelection();
    const range = selection.getRangeAt(0); // Získáme aktuální výběr (kurzor)

    if (selection.rangeCount > 0) {
        // Vytvoříme nový odstavec
        const paragraph = document.createElement('p');

        // Vytvoříme pomlčku a mezeru, které budou na novém řádku
        const dashText = document.createTextNode(' — '); // Pomlčka a mezera

        // Vytvoříme <br> pro nový řádek
        const lineBreak = document.createElement('br');

        // Přidáme <br> pro nový řádek
        paragraph.appendChild(lineBreak);
        // Přidáme pomlčku do nového řádku
        paragraph.appendChild(dashText);

        // Vložíme nový odstavec na pozici kurzoru
        range.insertNode(paragraph);




        // Umístíme kurzor na konec textu "Pokračujte zde..."
        const newRange = document.createRange();
        newRange.setStart(continueText, continueText.textContent.length); // Umístíme kurzor na konec textu
        newRange.setEnd(continueText, continueText.textContent.length);
        selection.removeAllRanges();
        selection.addRange(newRange); // Nastavíme nový výběr (kurzor)
    }
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
function showAlert(message){
    const alert = document.createElement('div');
    alert.classList.add('alert');
    alert.textContent=message;

    const alertContainer = document.getElementById('alert-container');
    alertContainer.appendChild(alert);
    serTimeout(()=>{
        alert.remove();
    },6000);
}
function validateForm(event){
    const firstname=document.getElementById('firstname').ariaValueMax.trim();
    const lastname=document.getElementById('lastname').ariaValueMax.trim();
    const username=document.getElementById('username').ariaValueMax.trim();
    const password=document.getElementById('password').ariaValueMax.trim();
    let errors=[];
    if(firstname==="")errors.push("Chybí jméno");
    if(lastname==="")errors.push("Chybí příjmení");
    if(username==="")errors.push("Chybí uživatelské jméno");
    if(password===""|| password.length < 8)errors.push("Heslo musí obsahovat alespň 8 znaků");

    if (errors.length>0) {
        event.preventDefault();
        errors.forEach(error => showAlert(error));
        return false;
    }
    showAlert("Úspěšné přihlášení");
    return true;
}
document.getElementById('signup-modal').addEventListener('submit',validateForm);

