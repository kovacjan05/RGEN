
function saveGeneratedText() {
    const textName = prompt("Zadejte název textu:");

    if (!textName) {
        alert("Název textu není vyplněn.");
        return;
    }

    // Odeslání AJAX požadavku na PHP skript
    fetch("save_text.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            name: textName,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert("Text byl úspěšně uložen.");
            } else {
                alert("Došlo k chybě při ukládání: " + (data.error || "Neznámá chyba."));
            }
        })
        .catch((error) => {
            console.error("Chyba:", error);
        });
}
