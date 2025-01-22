
document.addEventListener("DOMContentLoaded", function () {
    // Zavření modálního okna a reset formuláře
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

    // Zpracování odeslání formuláře
    document.getElementById("registr-form").addEventListener("submit", function (e) {
        e.preventDefault(); // Zabránit klasickému odeslání formuláře

        const firstname = document.getElementById("firstname-registr").value.trim();
        const lastname = document.getElementById("lastname-registr").value.trim();
        const username = document.getElementById("username-registr").value.trim();
        const password = document.getElementById("password-registr").value.trim();

        console.log("Zpracování formuláře...");




        // Skrytí předchozích chybových zpráv
        const errorMessageEmpty = document.getElementById("error-message-registr-empty");
        const errorMessagePassword = document.getElementById("error-message-registr-password");
        errorMessageEmpty.style.display = "none";
        errorMessagePassword.style.display = "none";

        // Validace dat na straně klienta
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

        // Odeslání dat na server
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
                    // Zobrazit chybové zprávy ze serveru
                    errorMessage.textContent = "* " + data.errors.join(", ");
                    errorMessage.style.display = "block";
                } else if (data.success) {
                    alert(data.success);
                    document.getElementById("signup-modal").style.display = "none"; // Zavření okna
                }
            })
            .catch((error) => {
                console.error("Chyba při odesílání dat na server:", error);
                errorMessage.textContent = "* Chyba při komunikaci se serverem.";
                errorMessage.style.display = "block";
            });
    });
});
