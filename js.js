const selectElement = document.getElementById('vyber');

selectElement.addEventListener('focus', () => {
    selectElement.classList.add('open');
});

selectElement.addEventListener('blur', () => {
    selectElement.classList.remove('open');
});
