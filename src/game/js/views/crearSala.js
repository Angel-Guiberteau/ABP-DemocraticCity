
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalCrearSala");
    const openModalButton = document.getElementById("crearSalaButton");
    const closeModalButton = document.getElementById("closeModal");
    const crearSalaForm = document.getElementById("crearSalaForm");

    // Abrir el modal
    openModalButton.addEventListener("click", (e) => {
        e.preventDefault(); // Evitar el comportamiento por defecto
        modal.style.display = "block";
    });

    // Cerrar el modal
    closeModalButton.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Cerrar modal al hacer clic fuera
    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    // Redirigir al enviar el formulario
    crearSalaForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const nombreSala = document.getElementById("nombreSala").value;
        if (nombreSala.trim()) {
            window.location.href = `index.php?c=Usuarios&m=mostrarSala&nombreSala=${encodeURIComponent(nombreSala)}`;
        }
    });
});
  