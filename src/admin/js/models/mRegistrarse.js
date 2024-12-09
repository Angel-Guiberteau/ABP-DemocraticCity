export class MRegistrarse {
    constructor() {}
    async mRegistrarse(formData){
        try{
            const response = await fetch('index.php?c=Usuarios&m=registrarAdm',{ //CAMBIAR SERVIDOR
                method: 'POST', //Usamos post para enviar datos
                body: formData, //Enviamos datos en el body de la solicitud
            });
    
            if(response.ok){
                const result = await response.text();
                if(result == 'correcto'){
                    window.location.href = "index.php?c=Usuarios&m=registrarAdmin&registro=correcto";
                    // document.querySelector('.registroIncorrecto').style.display = 'inline';
                }else{
                    const error = document.querySelector('.registrarseIncorrecto');
                    if(result == '1062')
                        error.innerHTML = 'El usuario ya existe';
                    else
                        error.innerHTML = 'Las contraseñas no son iguales';
    
                    document.querySelector('.registrarseIncorrecto').style.display = 'inline';
                }
            }else{
                document.querySelector('.registrarseIncorrecto').style.display = 'inline';
            }
        }catch(error){
            console.log(error);
            document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
            resultado.style.color = 'red';
        }
    }
}