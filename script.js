const form = document.querySelector("form")
const email = document.getElementById("email")
const senha = document.getElementById("senha")

function validarEmail(email) {
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regexEmail.test(email);
}

function validarSenha(senha) {
    const regexSenha = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    return regexSenha.test(senha) 
}

form.addEventListener("submit", function(event){
      if (!validarEmail(email.value)) {
        alert("Formato de E-mail Inválido!")
        event.preventDefault();
    } else if (!validarSenha(senha.value)) {
        alert("Formato de Senha Inválido!")
        event.preventDefault();
    } 
})
