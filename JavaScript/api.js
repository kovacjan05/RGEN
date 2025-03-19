
document.addEventListener("DOMContentLoaded", function () {
    // Tlačítko pro načtení dat z API
    document.getElementById("fetchApiButton").addEventListener("click", function () {
        // URL API, které vrátí text
        const apiUrl = "textUser/get_text.php"; // Nahraďte skutečnou URL vašeho PHP skriptu

        // Otevření nového okna prohlížeče
        const newWindow = window.open("", "_blank");

        // Provedení HTTP GET požadavku
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Chyba při načítání dat z API");
                }
                return response.json(); // Předpokládáme, že API vrací JSON
            })
            .then(data => {
                // Zpracování dat z API a zobrazení v novém okně
                let content = "";

                // Pokud je text v session, připravíme ho k zobrazení
                if (data.generated_text) {
                    content = data.generated_text.join("\n"); // Oddělíme odstavce novými řádky
                } else if (data.text_from_database) {
                    content = data.text_from_database;
                } else {
                    content = "Žádný text nebyl nalezen.";
                }

                // Zápis obsahu do nového okna (pouze čistý text)
                newWindow.document.write(content);
                newWindow.document.close(); // Uzavření dokumentu pro zobrazení
            })
            .catch(error => {
                console.error("Chyba:", error);
                newWindow.document.write("Nepodařilo se načíst data z API.");
                newWindow.document.close();
            });
    });
});