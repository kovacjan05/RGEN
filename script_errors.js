
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
                // Pokud server vrátil chybu (např. 401 Unauthorized)
                document.getElementById("error-message").style.display = "block";
                document.getElementById("password").value = ""; // Vymazání hesla
                throw new Error("Přihlášení neúspěšné");
            }
            // Přihlášení bylo úspěšné

            window.location.reload(); // Aktualizace stránky nebo přesměrování
            alert("Úspěšné přihlášení");
        })
        .catch((error) => {
            console.error("Chyba při přihlašování:", error);
        });
});






/////////////////       error message registr       ////////////////





