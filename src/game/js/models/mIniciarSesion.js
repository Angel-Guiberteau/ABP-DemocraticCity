export class MIniciarSesion {
    constructor() {}
    async mIniciarSesion(formData){

        try {
            const response = await fetch('index.php?c=Usuarios&m=inicio', {
                method: 'POST',
                body: formData,
            });
    
            if(response.ok) {
                const result = await response.text();
    
                if (result=='correcto') {
                    window.location.href = "index.php?c=Usuarios&m=mostrarInicio";
                } else {
                    const error = document.querySelector('.loginIncorrecto');
                    if(result == 'PasswIncorrecta'){
                        error.innerHTML = 'Contraseña incorrecta';
                    }else{
                        error.innerHTML = 'Usuario o contraseña incorrecto';
                    }
                    document.querySelector('.loginIncorrecto').style.display = 'inline'; 
                }
            } else {
                let error = document.querySelector('.loginIncorrecto');
                error.innerHTML = 'ERROR AL CONECTAR CON EL SERVIDOR. Inténtelo de nuevo más tarde.'
                error.style.display = 'inline'; ;
            }
        } catch (error) {
            console.error('Error:', error); 
            document.getElementById('resultado').innerText = 'Error de conexión.';
            resultado.style.color = 'red';
        }
    }
}