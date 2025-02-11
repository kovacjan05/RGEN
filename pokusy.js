

document.addEventListener("DOMContentLoaded", function () {
    // Získání informace o přihlášení z HTML (data-attribut)
    var userStatusDiv = document.getElementById("user-status");
    var isLoggedIn = userStatusDiv.getAttribute("data-logged-in") === "true";

    // Pokud je uživatel přihlášen, zobrazíme formulář
    if (isLoggedIn) {
        document.getElementById("saveForm").style.display = "block";
    }

    // Validace formuláře
    document.querySelector("#saveForm form").addEventListener("submit", function (event) {
        var textNameInput = document.querySelector("#saveForm input[name='name']");
        var errorMessage = document.getElementById("error-message-savetext");

        if (textNameInput.value.trim() === "") {
            event.preventDefault(); // Zabrání odeslání formuláře
            errorMessage.style.display = "block";
        } else {
            errorMessage.style.display = "none";

            setTimeout(function () {
                alert("Text úspěšně uložen.");
            }, 100);
        }
    });
});