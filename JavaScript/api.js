
document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("fetchApiButton").addEventListener("click", function () {

        const apiUrl = "textUser/get_text.php";


        const newWindow = window.open("", "_blank");


        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Chyba při načítání dat z API");
                }
                return response.json();
            })
            .then(data => {

                let content = "";


                if (data.generated_text) {
                    content = data.generated_text.join("\n");
                } else if (data.text_from_database) {
                    content = data.text_from_database;
                } else {
                    content = "Žádný text nebyl nalezen.";
                }


                newWindow.document.write(content);
                newWindow.document.close();
            })
            .catch(error => {
                console.error("Chyba:", error);
                newWindow.document.write("Nepodařilo se načíst data z API.");
                newWindow.document.close();
            });
    });
});