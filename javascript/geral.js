//! trocar de tema

const obj = document.querySelectorAll(".obj");
const icon = document.getElementById("dark");

icon.addEventListener("click", respostaTema);

function respostaTema() {
  obj.forEach((element) => {
    element.classList.toggle("dark");
  });
  icon.classList.toggle("fa-sun");
  icon.classList.toggle("fa-moon");
}

//! mostrar o gerador de senha

const btnGerar = document.querySelector(".senha_btn");
const painelEsquerda = document.querySelector(".overlay-left");
const esquerdaElements = document.querySelectorAll(".gerador-local");
const gerador = document.querySelector(".senha_container");

let valido = false;

btnGerar.addEventListener("click", SenhaEspaco);

function SenhaEspaco(event) {
  event.preventDefault();

  const computedStyle = getComputedStyle(painelEsquerda);

  if (computedStyle.padding === "0px" || computedStyle.padding === "0px 0px") {
    painelEsquerda.style.padding = "0 40px";
  } else {
    painelEsquerda.style.padding = "0px";
  }

  valido = true;
  gerarGerador();
}

function gerarGerador() {
  if (valido) {
    esquerdaElements.forEach((element) => {
      const displayStyle = getComputedStyle(element).display;
      element.style.display = displayStyle === "none" ? "block" : "none"; //? getComputedStyle() retorna um objeto que contém os valores de todas as propriedades CSS de um elemento
    });

    const geradorDisplayStyle = getComputedStyle(gerador).display;
    gerador.style.display = geradorDisplayStyle === "none" ? "flex" : "none";
  } else {
    alert("erro");
  }
}

//! gerador de senhas

const senhaLinha = document.getElementById("senha-linha");
const senhaCaixa = document.getElementById("senha-caixa");
const senhaMostrar = document.getElementById("mostrar");
const btnGeraracao = document.getElementById("gerar");
const btnCopiar = document.getElementById("copiar");
const lugarPassword = document.getElementById("password");
const containerSenha = document.querySelector(".senha");
const inputSenha = document.querySelectorAll(".senha-marcavel");
const letramaiuscula = document.getElementById("maiscula");
const letraMinuscula = document.getElementById("minuscula");
const numero = document.getElementById("numero");
const simbolo = document.getElementById("simbolo");
const senhaCopyInputs = document.querySelectorAll(".senha-copy");

letraMinuscula.value = "abcdefghijklmnopqrstuvwxyz";
letramaiuscula.value = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
numero.value = "0123456789";
simbolo.value = "!@#$%&*()_+";

senhaLinha.oninput = function () {
  senhaMostrar.innerHTML = this.value;
  senhaCaixa.value = this.value;
};

senhaCaixa.oninput = function () {
  senhaMostrar.innerHTML = this.value;
  senhaLinha.value = this.value;
};

let novaSenha = "";
let senha = "";

btnGeraracao.addEventListener("click", geracaoSenha);

function geracaoSenha() {
  let cond = true;
  inputSenha.forEach(function (dados) {
    if (!dados.checked) {
      cond = false;
      return;
    }
  });

  if (cond) {
    senha = ""; // Resetar a senha a cada geração

    inputSenha.forEach(function (dados) {
      if (dados.checked) {
        senha += dados.value;
      }
    });

    let pass = "";

    for (let i = 0, n = senha.length; i < senhaLinha.value; i++) {
      pass += senha.charAt(Math.floor(Math.random() * n));
    }

    containerSenha.style.display = "flex";
    lugarPassword.innerHTML = pass;

    novaSenha = pass;
  } else {
    return;
  }
}

lugarPassword.addEventListener("click", function () {
  alert("Senha copiada com sucesso");
  navigator.clipboard.writeText(novaSenha);
});

//? passa o valor para os input

btnCopiar.addEventListener("click", function () {
  senhaCopyInputs.forEach(function (input) {
    input.value = novaSenha;
    removeError(3);
    removeError(4);
  });
  navigator.clipboard.writeText(novaSenha);
  if (
    painelEsquerda.style.padding === "0px" ||
    painelEsquerda.style.padding === ""
  ) {
    painelEsquerda.style.padding = "0 40px";
  } else {
    painelEsquerda.style.padding = "0px";
  }
  gerarGerador();
});
