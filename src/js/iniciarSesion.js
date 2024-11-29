//----------------MOSTRAR CONTRASEÑAS
function mostrarPassw(){
    let passlogin = document.querySelector('#passw');
        
    let checkbox = document.querySelector('#verPassw');
    passlogin.type = checkbox.checked ? "text" : "password";
}

