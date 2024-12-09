document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('modalEliminar');
        const confirmarEliminar = document.getElementById('confirmarEliminar');
        const cancelarEliminar = document.getElementById('cancelarEliminar');
        let idPreguntaSeleccionada = null;

        document.querySelectorAll('.eliminar').forEach(boton => {
            boton.addEventListener('click', (e) => {
                e.preventDefault();
                idPreguntaSeleccionada = e.target.getAttribute('data-id');
                modal.style.display = 'flex';
            });
        });

        cancelarEliminar.addEventListener('click', () => {
            modal.style.display = 'none';
            idPreguntaSeleccionada = null;
        });

        confirmarEliminar.addEventListener('click', () => {
            if (idPreguntaSeleccionada) {
                window.location.href = `index.php?c=Preguntas&m=eliminarPregunta&id=${idPreguntaSeleccionada}`;
            }
        });
    });