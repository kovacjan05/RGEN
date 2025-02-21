document.addEventListener("DOMContentLoaded", function () {
    let quill = new Quill("#editor", {
        theme: "snow",
        modules: {
            toolbar: true
        }
    });

    // Načtení obsahu editoru ze session (pokud existuje)
    let editorContent = document.getElementById("editor").dataset.content;
    if (editorContent) {
        quill.root.innerHTML = editorContent;
    }

    document.getElementById("saveButton").addEventListener("click", function (event) {
        event.preventDefault(); // Zabráníme okamžitému odeslání formuláře

        let editorContent = quill.root.innerHTML;
        let textNameInput = document.querySelector("input[name='Textname']").value;

        // Kontrola, jestli uživatel zadal název textu
        if (!textNameInput.trim()) {
            document.getElementById("error-message-savetext").style.display = "block";
            return; // Ukončí akci, pokud není vyplněn Textname
        }

        document.getElementById("error-message-savetext").style.display = "none";

        // Uložíme obsah editoru do session
        fetch("textUser/saveSession.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "content=" + encodeURIComponent(editorContent),
        })
            .then(response => response.text())
            .then(data => {
                console.log("Session uložená:", data);

                // Počkáme 500 ms, aby session měla čas se uložit, a pak odešleme formulář
                setTimeout(() => {
                    document.querySelector("#saveForm form").submit();
                }, 500);
            })
            .catch(error => console.error("Chyba při ukládání session:", error));
    });
});

///////////////////////////    save text    ////////////////

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

////////////////////////////// duplicate text//////////////
document.addEventListener("DOMContentLoaded", function () {
    var userStatusDiv = document.getElementById("user-status");
    var isLoggedIn = userStatusDiv.getAttribute("data-logged-in") === "true";

    if (isLoggedIn) {
        document.getElementById("saveForm").style.display = "block";
    }

    document.querySelector("#saveForm form").addEventListener("submit", function (event) {
        var textNameInput = document.querySelector("#saveForm input[name='Textname']");
        var emptyErrorMessage = document.getElementById("error-message-savetext");
        var duplicateErrorMessage = document.getElementById("error-message-savetext-duplicate");

        // Skrytí chybových hlášek před validací
        emptyErrorMessage.style.display = "none";
        duplicateErrorMessage.style.display = "none";

        if (textNameInput.value.trim() === "") {
            event.preventDefault();
            emptyErrorMessage.style.display = "block";
            return;
        }

        // AJAX kontrola na duplikaci názvu
        fetch("textUser/check_duplicate.php", {
            method: "POST",
            body: new URLSearchParams({ name: textNameInput.value.trim() }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
            .then(response => response.text())
            .then(data => {
                if (data === "duplicate") {
                    duplicateErrorMessage.style.display = "block"; // Pouze zobrazí chybovou hlášku
                    event.preventDefault(); // Zabrání odeslání
                }
            })
            .catch(error => console.error("Chyba při ověřování duplikace:", error));
    });
});
