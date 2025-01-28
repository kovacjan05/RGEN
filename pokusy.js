// async function generateText() {
//     const vyber = document.getElementById("vyber").value;
//     const odstavce = document.getElementById("odstavce").value;
//     const slova = document.getElementById("slovaOdstavec").value;
//     const output = document.getElementById("generated-text");

//     if (odstavce < 1 || slova < 1) {
//         output.innerText = "Počet odstavců a slov musí být větší než 0!";
//         return;
//     }

//     const formData = new FormData();
//     formData.append("vyber", vyber);
//     formData.append("odstavce", odstavce);
//     formData.append("slovaOdstavec", slova);

//     try {
//         const response = await fetch("generate.php", {
//             method: "POST",
//             body: formData
//         });
//         const data = await response.json();

//         if (data.error) {
//             output.innerText = data.error;
//         } else {
//             output.innerText = data.text;
//         }
//     } catch (error) {
//         output.innerText = "Chyba při načítání dat.";
//     }
// }

async function loadText() {
    const response = await fetch("generate_text.php");
    const text = await response.text();
    document.getElementById("output").innerText = text;
}
window.onload = loadText;



