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

    // Odeslání formuláře
    document.querySelector("#saveForm form").addEventListener("submit", function (event) {
        event.preventDefault(); // Zabráníme okamžitému odeslání formuláře

        var textNameInput = document.querySelector("#saveForm input[name='Textname']");
        var duplicateErrorMessage = document.getElementById("error-message-savetext-duplicate");

        // Skrytí chybové hlášky na začátku
        duplicateErrorMessage.style.display = "none";

        // Odeslání dat na server
        fetch("textUser/saveText.php", {
            method: "POST",
            body: new URLSearchParams({ Textname: textNameInput.value.trim() }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
            .then(response => response.json()) // Zpracování JSON odpovědi
            .then(data => {
                console.log("Odpověď ze serveru:", data);

                if (data.status === "error") {
                    // Zobrazíme chybovou zprávu
                    duplicateErrorMessage.textContent = data.message; // Nastavíme text chyby
                    duplicateErrorMessage.style.display = "block"; // Zobrazíme label
                } else if (data.status === "success") {
                    // Přesměrování na úspěšnou stránku
                    window.location.href = "../textUser/findText.php";
                }
            })
            .catch(error => console.error("Chyba při odesílání formuláře:", error));
    });
});