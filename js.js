const selectElement = document.getElementById("vyber");
const posunutiDiv = document.querySelector(".posunuti");

// Přidáme třídu při zaměření na select
selectElement.addEventListener("focus", () => {
    posunutiDiv.classList.add("posunuto-dolu");
});

// Odstraníme třídu při opuštění selectu
selectElement.addEventListener("blur", () => {
    posunutiDiv.classList.remove("posunuto-dolu");
});

// Odstraníme třídu při změně výběru a zároveň odstraníme focus
selectElement.addEventListener("change", () => {
    posunutiDiv.classList.remove("posunuto-dolu");
    selectElement.blur(); // Programově odstraníme focus, aby už nešlo znovu rozkliknout
});
