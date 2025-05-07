<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/senha.css" />
    <link rel="stylesheet" href="../css/tema.css" />
    <script src="../javascript/script.js" defer></script>
    <title>login</title>
  </head>
  <body class="obj">
    <header class="topo">
      <button class="tema obj">
        <a href="../index.php" class="home-link obj"
          ><span class="home-title"
            ><i class="fa-solid fa-house" id="home"></i>Home</span
          ></a
        >
      </button>
      <button class="tema">
        <i class="fa-solid fa-sun obj" id="dark"></i>
      </button>
    </header>
    <div class="container obj" id="container">

      <div class="form-container register-container">
        <form
          action="../backend/loginRegister.php"
          method="POST"
          id="form"
          class="form_register"
        >
          <h1 class="problema"> Registre aqui</h1>
          <div class="espaco-input">
            <input
              type="text"
              name="name"
              placeholder="Name"
              class="required input-register"
            />
            <span class="error_span"></span>
          </div>
          <div class="espaco-input">
            <input
              type="email"
              name="email"
              placeholder="Email"
              class="required input-register"
            />
            <span class="error_span"></span>
          </div>
          <div class="espaco-input">
            <input
              type="tel"
              name="telefone"
              placeholder="Numero de telefone"
              class="required input-register"
            />
            <span class="error_span"></span>
          </div>
          <div class="espaco-input">
            <div class="espaco-senha">
              <input
                type="password"
                name="password"
                placeholder="Password"
                class="required input-register senha-copy"
              />
              <i class="fa-regular fa-eye olhos obj"></i>
            </div>
            <span class="error_span"></span>
          </div>
          <div class="espaco-input">
            <div class="espaco-senha">
              <input
                type="password"
                name="password_confirm"
                placeholder="Confirm Password"
                class="required input-register senha-copy"
              />
              <i class="fa-regular fa-eye olhos obj"></i>
            </div>
            <div class="gerar-senha">
              <span class="title-senha size-span"
                >Gere a sua senha:
                <button class="senha_btn obj">
                  <i class="fa-solid fa-lock"></i>
                </button>
              </span>
              <span class="error_span size-span"></span>
            </div>
          </div>
          <button type="submit" id="vali_register" class="rl-tema obj">
            Registrar
          </button>
          <div class="social-container obj">
            <a href="#" class="social obj"
              ><i class="fa-brands fa-facebook"></i
            ></a>
            <!-- talvez tenha a classe lni -->
            <a href="#" class="social obj"
              ><i class="fa-brands fa-google"></i
            ></a>
            <a href="#" class="social obj"
              ><i class="fa-brands fa-linkedin"></i
            ></a>
            <a href="#" class="social obj"
              ><i class="fa-brands fa-github"></i
            ></a>
          </div>
        </form>
      </div>

      <div class="form-container login-container">
        <form
          action="../backend/loginApi.php"
          method="POST"
          class="form_login"
          id="formLogin"
        >
          <h1>Login</h1>
          <input
            type="email"
            id="accessInput"
            name="email"
            placeholder="Email ou Telefone"
            class="inputs_login"
          />
          <div class="espaco-senha">
            <input
              type="password"
              name="password"
              placeholder="Password"
              class="inputs_login"
              id="senha_entrar"
            />
            <i class="fa-regular fa-eye olhos obj"></i>
          </div>
          <div class="content">
            <div class="checkbox">
              <input type="checkbox" id="rememberCheckbox" name="checkbox" />
              <label for="remember-me">lembre-me</label>
            </div>
            <div class="pass-link">
              <a class="obj" href="./pages/esqueci.php">Esqueceu a senha?</a>
            </div>
          </div>
          <button type="submit" class="rl-tema obj" id="vali_login">
            Login
          </button>
          <div class="social-container obj">
            <a href="#" class="social obj"
              ><i class="fa-brands fa-facebook"></i
            ></a>
            <a href="#" class="social obj"
              ><i class="fa-brands fa-google"></i
            ></a>
            <a href="#" class="social obj"
              ><i class="fa-brands fa-linkedin"></i
            ></a>
            <a href="#" class="social obj"
              ><i class="fa-brands fa-github"></i
            ></a>
          </div>
        </form>
      </div>

      <div class="overlay-container">

      <div class="overlay obj">
          <div class="overlay-panel overlay-left">

          <main class="senha_container obj">
              <section class="senha_dados">
                <div class="senha_dados-info especial">
                  <div class="senha_title">
                    <p class="title_gerador">
                    Quantidade de caracteres:
                      <span class="senha_mostrar" id="mostrar"></span>
                    </p>
                  </div>
                  <div class="senha_tamanho">
                    <input
                      class="senha_linha"
                      type="range"
                      name=""
                      id="senha-linha"
                      min="8"
                      max="25"
                      value="8"
                    />
                    <input
                      class="senha_caixa"
                      type="number"
                      name=""
                      id="senha-caixa"
                      min="8"
                      max="25"
                      value="8"
                    />
                  </div>
                </div>
                <div class="senha_dados-info">
                  <p class="title_gerador">Incluir letras maiúsculas:" </p>
                  <input
                    class="senha-marcavel"
                    type="checkbox"
                    name=""
                    id="maiscula"
                  />
                </div>
                <div class="senha_dados-info">
                  <p class="title_gerador">Incluir letras minúsculas:</p>
                  <input
                    class="senha-marcavel"
                    type="checkbox"
                    name=""
                    id="minuscula"
                  />
                </div>
                <div class="senha_dados-info">
                  <p class="title_gerador">Incluir números:</p>
                  <input
                    class="senha-marcavel"
                    type="checkbox"
                    name=""
                    id="numero"
                  />
                </div>
                <div class="senha_dados-info">
                  <p class="title_gerador">Incluir símbolos:</p>
                  <input
                    class="senha-marcavel"
                    type="checkbox"
                    name=""
                    id="simbolo"
                  />
                </div>

                <div class="senha_button">
                  <button class="senha-btn obj" id="gerar">Gerar</button>
                </div>
              </section>

              <section class="senha">
                <div class="senha_lugar">
                  <p class="senha_texto" id="password"></p>
                </div>
                <div class="senha_button">
                  <button class="senha-btn btn-copiar obj" id="copiar">
                  Copiar
                  </button>
                </div>
              </section>
            </main>


            <h1 class="title gerador-local">Bem-vindo de volta!</h1>
            <p class="gerador-local p_description">
            Para se manter conectado conosco, faça login com suas informações pessoais
            </p>
            <button class="ghost gerador-local" id="login">
            Login<i class="login fa-solid fa-arrow-left"></i>
            </button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1 class="title">Olá, Amigo!</h1>
            <p class="p_description">
            Insira seus dados pessoais e comece sua jornada conosco
          </p>
            <button class="ghost" id="register">
            Registrar <i class="register fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>


      </div>
    </div>
  </body>
</html>
