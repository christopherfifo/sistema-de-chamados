//!trocar de lado

const registerbtn = document.getElementById("register");
const loginbtn = document.getElementById("login");
const container = document.getElementById("container");

registerbtn.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

loginbtn.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});



// Seleciona elementos do DOM
const formRegister = document.getElementById("form"); // Formulário de registro
const campos = document.querySelectorAll(".required"); // Campos obrigatórios
const span = document.querySelectorAll(".error_span"); // Mensagens de erro
const validarRegistro = document.getElementById("vali_register"); // Botão de registro
const emailRegex =
  /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

// Seleciona elementos do login

const passwordInput = document.getElementById("senha_entrar"); // Campo de senha

// Funções de validação para registro
const validators = [
  (value) => value.length >= 3 || "O nome deve ter pelo menos 3 caracteres.", // Nome
  (value) => emailRegex.test(value) || "Email inválido.", // Email
  (value) => value.length >= 11 || "O número deve ter pelo menos 11 caracteres.", // Telefone
  (value) => /^\d{11}$/.test(value) || "O CPF deve conter exatamente 11 dígitos numéricos.", // CPF
  (value) => {
    if (value.length < 8) return "A senha deve ter pelo menos 8 caracteres.";
    if (!/[A-Z]/.test(value))
      return "A senha deve ter pelo menos uma letra maiúscula.";
    if (!/[!@#$%^&*(),.?":{}|<>]/.test(value))
      return "A senha deve ter pelo menos um caractere especial.";
    return true;
  }, // Senha
  (value, campos) => {
    if (value === "") return "Campo Obrigatório";
    if (value !== campos[4].value) return "As senhas não coincidem."; // Comparação com o campo de senha
    return true;
  }, // Confirmação de senha
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

// Validação do registro e requisição para a API
async function validacaoFinal(event) {
  event.preventDefault(); // Impede o comportamento padrão do botão

  let formValido = true;

  campos.forEach((campo, index) => {
    if (!validateField(index)) {
      formValido = false;
    }
  });

  if (formValido) {
    const formData = new FormData(formRegister);
    try {
      const response = await fetch(
        "../controller/authController.php",
        {
          method: "POST",
          body: formData,
        }
      );

      const data = await response.json();
      if (data.success) {
        alert(data.success); // Mensagem de sucesso
        formRegister.reset(); // Limpa o formulário
        window.location.href = "";
      } else {
        alert(data.error || "Erro desconhecido"); // Mensagem de erro
      }
    } catch (error) {
      console.error("Erro:", error);
      alert("Erro ao registrar usuário. Tente novamente.");
    }
  } else {
    alert("Formulário inválido!");
  }
}


// Adiciona o ouvinte de eventos para o botão de registro
validarRegistro.addEventListener("click", validacaoFinal);


//! local storege

document.addEventListener("DOMContentLoaded", function () {
  const accessInput = document.getElementById("accessInput");
  const rememberCheckbox = document.getElementById("rememberCheckbox");

  // Verifica se já existe uma forma de acesso salva no localStorage
  const savedAccess = localStorage.getItem("accessInfo");

  if (savedAccess) {
    accessInput.value = savedAccess;
    rememberCheckbox.checked = true;
  }

  // Adiciona um evento de mudança ao checkbox
  rememberCheckbox.addEventListener("change", function () {
    if (this.checked) {
      localStorage.setItem("accessInfo", accessInput.value);
    } else {
      localStorage.removeItem("accessInfo");
    }
  });

  // Atualiza o localStorage toda vez que o usuário digita no input
  accessInput.addEventListener("input", function () {
    if (rememberCheckbox.checked) {
      localStorage.setItem("accessInfo", this.value);
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

