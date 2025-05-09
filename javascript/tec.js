

// Seleciona elementos do login
const accessInput = document.getElementById("accessInput"); // Campo de email/usuário
const passwordInput = document.getElementById("senha_entrar"); // Campo de senha
const validarLogin = document.getElementById("vali_login"); // Botão de login
const formLogin = document.getElementById("formLogin"); // Formulário de login

// Funções de validação para registro
const validators = [
  (value) => value.length >= 3 || "O nome deve ter pelo menos 3 caracteres.",
  (value) => emailRegex.test(value) || "Email inválido.",
  (value) =>
    value.length >= 11 || "O número deve ter pelo menos 11 caracteres.",
  (value) => {
    if (value.length < 8) return "A senha deve ter pelo menos 8 caracteres.";
    if (!/[A-Z]/.test(value))
      return "A senha deve ter pelo menos uma letra maiúscula.";
    if (!/[!@#$%^&*(),.?":{}|<>]/.test(value))
      return "A senha deve ter pelo menos um caractere especial.";
    return true;
  },
  (value, campos) => {
    if (value === "") return "Campo Obrigatório";
    if (value !== campos[3].value) return "As senhas não coincidem.";
    return true;
  },
];

// Funções de manipulação de erros
function setError(index, message) {
  campos[index].style.border = "2px solid red";
  span[index].style.display = "block";
  span[index].textContent = message;
}

function removeError(index) {
  campos[index].style.border = "2px solid green";
  span[index].style.display = "none";
}

// Validação de um campo específico
function validateField(index) {
  const field = campos[index];
  const validator = validators[index];
  const result = validator(field.value, campos);

  if (result === true) {
    removeError(index);
    return true;
  } else {
    setError(index, result);
    return false;
  }
}



//! local storege

document.addEventListener("DOMContentLoaded", function () {
    const accessInput = document.getElementById("accessInput");
    const rememberCheckbox = document.getElementById("rememberCheckbox");

    // Verifica se já existe uma forma de acesso salva no localStorage
    const savedAccess = localStorage.getItem("userAccessInfo");

    if (savedAccess) {
        accessInput.value = savedAccess;
        rememberCheckbox.checked = true;
    }

    // Adiciona um evento de mudança ao checkbox
    rememberCheckbox.addEventListener("change", function () {
        if (this.checked) {
            localStorage.setItem("userAccessInfo", accessInput.value);
        } else {
            localStorage.removeItem("userAccessInfo");
        }
    });

    // Atualiza o localStorage toda vez que o usuário digita no input
    accessInput.addEventListener("input", function () {
        if (rememberCheckbox.checked) {
            localStorage.setItem("userAccessInfo", this.value);
        }
    });
});

//! expor senha

document.querySelectorAll(".olhos").forEach(function (icon) {
  icon.addEventListener("click", function () {
    // Seleciona o input associado ao ícone clicado
    const input = this.previousElementSibling;

    // Alterna o tipo do input entre 'password' e 'text'
    if (input.type === "password") {
      input.type = "text";
      this.classList.remove("fa-eye");
      this.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      this.classList.remove("fa-eye-slash");
      this.classList.add("fa-eye");
    }
  });
});

