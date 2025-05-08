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

//! vericação

//! verifcação do login se é email ou matricula

document.getElementById('formLogin').addEventListener('submit', function (e) {
  const accessInput = document.getElementById('accessInput').value;
  const actionInput = document.getElementById('actioninput');

  // Verifica se é um email ou matrícula
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (emailRegex.test(accessInput)) {
      actionInput.value = 'login'; // Rota para usuários
  } else {
      actionInput.value = 'Tectechnicians_login'; // Rota para técnicos
  }
});

// Seleciona elementos do DOM
const formRegister = document.getElementById("form"); // Formulário de registro
const campos = document.querySelectorAll(".required"); // Campos obrigatórios
const span = document.querySelectorAll(".error_span"); // Mensagens de erro
const validarRegistro = document.getElementById("vali_register"); // Botão de registro
const emailRegex =
  /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

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
        "http://localhost/sistema-de-chamados/controller/authController.php",
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
        alert(data.error); // Mensagem de erro
      }
    } catch (error) {
      console.error("Erro:", error);
      alert("Erro ao registrar usuário. Tente novamente.");
    }
  } else {
    alert("Formulário inválido!");
  }
}

// Validação de login
async function validacaoLogin(event) {
  event.preventDefault(); // Impede o comportamento padrão do botão

  const formData = new FormData(formLogin); // Captura dados do formLogin

  // Verifique se o FormData não está vazio
  if (
    formData.get("accessInput") === "" ||
    formData.get("senha_entrar") === ""
  ) {
    alert("Por favor, preencha todos os campos.");
    return;
  }

  try {
    const response = await fetch(
      "http://localhost/sistema-de-chamados/controller/authController.php",
      {
        method: "POST",
        body: formData,
      }
    );

    const data = await response.json();
    if (data.success) {
      alert(data.success); // Mensagem de sucesso

      // Salva o token no localStorage
      localStorage.setItem("authToken", data.token);

      // Redirecionar ou realizar outra ação após o login
      window.location.href = "";
    } else {
      alert(data.error); // Mensagem de erro
    }
  } catch (error) {
    console.error("Erro:", error);
    alert("Erro ao entrar. Tente novamente.");
  }
}

// Adiciona o ouvinte de eventos para o botão de registro
validarRegistro.addEventListener("click", validacaoFinal);

// Adiciona o ouvinte de eventos para o botão de login
validarLogin.addEventListener("click", validacaoLogin);



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

