document.addEventListener("DOMContentLoaded", function () {
    // Inicializace Quill editoru
    let quill = Quill("#editor", {
        theme: "snow",
        modules: { toolbar: true }
    });

    // Načtení obsahu ze session (PHP přes datový atribut)
    let editorContent = document.getElementById("editor").dataset.content;
    if (editorContent) {
        quill.root.innerHTML = editorContent;
    }

    document.getElementById("saveButton").addEventListener("click", function (event) {
        event.preventDefault();

        let editorContent = quill.root.innerHTML;

        fetch("textUser/saveSession.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "content=" + encodeURIComponent(editorContent),
        })
            .then(response => response.text())
            .then(data => {
                console.log("Session uložená:", data);
            })
            .catch(error => console.error("Chyba při ukládání session:", error));
    });
});
