document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalEliminar');
    const confirmarEliminar = document.getElementById('confirmarEliminar');
    const cancelarEliminar = document.getElementById('cancelarEliminar');
    let formSeleccionado = null;

    // Muestra el modal al hacer clic en un botón "Eliminar"
    document.querySelectorAll('.eliminar').forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            formSeleccionado = e.target.closest('form');
            modal.style.display = 'flex';
        });
    });

    // Cierra el modal sin eliminar
    cancelarEliminar.addEventListener('click', () => {
        modal.style.display = 'none';
        formSeleccionado = null;
    });

    // Confirma la eliminación
    confirmarEliminar.addEventListener('click', () => {
        if (formSeleccionado) {
            formSeleccionado.submit();
        }
    });

    // Cierra el modal si se hace clic fuera de él
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
            formSeleccionado = null;
        }
    });
});
