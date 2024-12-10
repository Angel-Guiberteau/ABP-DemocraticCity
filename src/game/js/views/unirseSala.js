// Referencias al modal y botones
const modalUnirseSala = document.getElementById('modalUnirseSala');
const unirseSalaButton = document.getElementById('unirseSalaButton');
const closeModalUnirseSala = document.getElementById('closeModalUnirseSala');
const unirseSalaForm = document.getElementById('unirseSalaForm');

// Abrir modal
unirseSalaButton.addEventListener('click', () => {
    modalUnirseSala.style.display = 'block';
});

// Cerrar modal
closeModalUnirseSala.addEventListener('click', () => {
    modalUnirseSala.style.display = 'none';
});

// Manejar envío del formulario
unirseSalaForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const codigoSala = document.getElementById('codigoSala').value;

    // Redirigir a la misma vista con el código de la sala
    window.location.href = `index.php?c=Usuarios&m=unirseSala&codigo=${codigoSala}`;
});
