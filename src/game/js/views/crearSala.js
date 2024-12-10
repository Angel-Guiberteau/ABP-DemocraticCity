document.addEventListener("DOMContentLoaded", () => {
    // Referencias a los elementos del DOM
    const modalCrearSala = document.getElementById("modalCrearSala");
    const openModalCrearSalaButton = document.getElementById("crearSalaButton");
    const closeModalCrearSalaButton = document.getElementById("closeModalCrearSala");
    const crearSalaForm = document.getElementById("crearSalaForm");

    // Abrir el modal al hacer clic en el botón "Crear Sala"
    openModalCrearSalaButton.addEventListener("click", (e) => {
        e.preventDefault(); // Evita el comportamiento por defecto del enlace
        modalCrearSala.style.display = "block"; // Muestra el modal
    });

    // Cerrar el modal al hacer clic en el botón "Cerrar"
    closeModalCrearSalaButton.addEventListener("click", () => {
        modalCrearSala.style.display = "none"; // Oculta el modal
    });

    // Cerrar el modal al hacer clic fuera del contenido del modal
    window.addEventListener("click", (e) => {
        if (e.target === modalCrearSala) {
            modalCrearSala.style.display = "none"; // Oculta el modal
        }
    });

    // Manejo del envío del formulario
    crearSalaForm.addEventListener("submit", (e) => {
        e.preventDefault(); // Evita el envío por defecto

        // Recoge los datos del formulario (si son necesarios)
        const nombreCiudad = document.getElementById("nombreCiudad").value;

        // Redirige a la página con los datos (puedes ajustar la URL)
        window.location.href = `index.php?c=Partida&m=mostrarSala`;
    });
});
