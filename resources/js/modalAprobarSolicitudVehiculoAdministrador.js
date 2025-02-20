// Tu archivo principal (probablemente main.js o index.js)

console.log('aprobada pendiente'); // Esto se ejecutará

function openModal() {
    console.log('open');
    let modal = document.getElementById("confirmModal");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
}

function closeModal() {
    console.log('close');
    let modal = document.getElementById("confirmModal");
    modal.classList.remove("flex");
    modal.classList.add("hidden");
}

// Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    const openModalButton = document.getElementById('openModalButton'); // ID del botón que abre el modal
    const closeModalButton = document.getElementById('closeModalButton'); // ID del botón que cierra el modal
    if (openModalButton) {
        openModalButton.addEventListener('click', openModal);
    }
    if (closeModalButton) {
        closeModalButton.addEventListener('click', closeModal);
    }
});
