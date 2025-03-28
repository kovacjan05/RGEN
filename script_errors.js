
/////////////////       error message login       ////////////////


// Při zavření modal se vymažou všechny údaje
document.getElementById("close-login-modal").addEventListener("click", function () {
    document.getElementById("username").value = "";
    document.getElementById("password").value = "";
    document.getElementById("error-message").style.display = "none";
    document.getElementById("login-modal").style.display = "none";
});
document.getElementById("login-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Zabránit klasickému odeslání formuláře

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;

    fetch("login/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`,
    })
        .then((response) => {
            if (!response.ok) {

                document.getElementById("error-message").style.display = "block";
                document.getElementById("password").value = "";
                throw new Error("Přihlášení neúspěšné");
            }

            window.location.reload();
            alert("Úspěšné přihlášení");
        })
        .catch((error) => {
            console.error("Chyba při přihlašování:", error);
        });
});



/////////////////////////////////     error message register       ////////////////////////////


document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("close-signup-modal").addEventListener("click", function () {
        document.getElementById("firstname-registr").value = "";
        document.getElementById("lastname-registr").value = "";
        document.getElementById("username-registr").value = "";
        document.getElementById("password-registr").value = "";
        document.querySelectorAll(".error").forEach((error) => {
            error.style.display = "none";
        });
        document.getElementById("signup-modal").style.display = "none";



        console.log("Modal zavřen");


    });

    document.getElementById("registr-form").addEventListener("submit", function (e) {
        e.preventDefault();

        const firstname = document.getElementById("firstname-registr").value.trim();
        const lastname = document.getElementById("lastname-registr").value.trim();
        const username = document.getElementById("username-registr").value.trim();
        const password = document.getElementById("password-registr").value.trim();




        const errorMessageEmpty = document.getElementById("error-message-registr-empty");
        const errorMessagePassword = document.getElementById("error-message-registr-password");
        errorMessageEmpty.style.display = "none";
        errorMessagePassword.style.display = "none";
        const contentToBlur = [document.querySelector('main'), document.querySelector('.header'), document.querySelector('.leva-strana')];


        if (!firstname || !lastname || !username || !password) {
            errorMessageEmpty.style.display = "block";
            console.log("Všechna pole musí bít vyplněna.");
            return;
        }

        if (password.length < 8) {
            errorMessagePassword.style.display = "block";
            console.log("Heslo musí mít alespoň 8 znaků.");
            return;
        }

        console.log("Odesílám data na server...");
        console.log({ firstname, lastname, username, password });


        fetch("register/register.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `firstname=${encodeURIComponent(firstname)}&lastname=${encodeURIComponent(lastname)}&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`,
        })
            .then((response) => response.json())
            .then((data) => {
                console.log("Odpověď serveru:", data);
                if (data.errors) {

                    errorMessage.textContent = "* " + data.errors.join(", ");
                    errorMessage.style.display = "block";
                } else if (data.success) {
                    alert(data.success);
                    document.getElementById("signup-modal").style.display = "none";
                    contentToBlur.forEach(element => element.classList.remove('blurred'));
                }
            })
            .catch((error) => {
                console.error("Chyba při odesílání dat na server:", error);
                errorMessage.textContent = "* Chyba při komunikaci se serverem.";
                errorMessage.style.display = "block";
            });
    });
});


/////////////////////////////////     logout       ////////////////////////////

document.getElementById("logoutButton").addEventListener("click", function (e) {
    e.preventDefault();
    alert("Byl jste odhlášen.");
    window.location.href = 'logout/logout.php';
});



/////////////////////////////////     generovaný text textboxy      ////////////////////////////


document.getElementById("textForm").addEventListener("submit", function (e) {

    const inputs = document.querySelectorAll("#textForm input[type='text']");
    const errorGEN = document.getElementById("error-message-gen");
    let isValid = true;


    inputs.forEach(input => {
        if (input.value.trim() === "") {
            input.style.border = "2px solid red";
            isValid = false;

        } else {
            input.style.border = "";
        }
    });


    if (!isValid) {
        e.preventDefault();
        errorGEN.style.display = "block";
    }
});







