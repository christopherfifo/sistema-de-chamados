<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../javascript/script.js" defer></script>
    <title>login</title>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#4bb6b7',
                        darkblue: 'rgb(43, 43, 151)',
                    },
                    animation: {
                        'show': 'show 0.6s ease-in-out',
                    },
                    keyframes: {
                        show: {
                            '0%, 49.99%': { opacity: '0', zIndex: '1' },
                            '50%, 100%': { opacity: '1', zIndex: '5' },
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .error-border {
                @apply border-2 border-red-500;
            }
            .success-border {
                @apply border-2 border-green-500;
            }
            .transition-slow {
                @apply transition-all duration-300 ease-in-out;
            }
            .bg-overlay {
                @apply bg-gradient-to-t from-[rgba(46,94,109,0.4)] from-40% to-transparent;
            }
            .bg-overlay-dark {
                @apply bg-gradient-to-t from-[rgba(0,0,0,0.6)] from-40% to-transparent;
            }
            .shadow-custom {
                box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
            }
            .shadow-custom-dark {
                box-shadow: 0 14px 28px rgba(255, 255, 255, 0.25), 0 10px 10px rgba(255, 255, 255, 0.22);
            }
            
            /* Animação do overlay */
            .right-panel-active .register-container {
                transform: translateX(100%);
                opacity: 1;
                z-index: 5;
                animation: show 0.6s;
            }
            .right-panel-active .overlay-container {
                transform: translateX(-100%);
            }
            .right-panel-active .overlay {
                transform: translateX(50%);
            }
            .right-panel-active .overlay-left {
                transform: translateX(0);
            }
            .right-panel-active .overlay-right {
                transform: translateX(20%);
            }
        }
    </style>
</head>
<body class="obj bg-gray-100 flex justify-center items-center flex-col h-screen overflow-hidden dark:bg-black">
    <header class="topo w-full absolute top-0 left-0 z-[1000] px-4 flex justify-between items-center">
        <button class="tema obj bg-transparent border-none p-0 m-0 cursor-pointer">
            <a href="../index.php" class="home-link obj no-underline text-black flex items-center gap-2 dark:text-white">
                <span class="home-title text-xl flex items-center gap-1">
                    <i class="fa-solid fa-house text-2xl" id="home"></i>Home
                </span>
            </a>
        </button>
        <button class="tema bg-transparent border-none w-auto p-0 m-0 cursor-pointer">
            <i class="fa-solid fa-sun obj text-2xl" id="dark"></i>
        </button>
    </header>
    
    <div class="container obj bg-white rounded-3xl shadow-custom relative overflow-hidden w-[768px] max-w-full min-h-[500px] dark:shadow-custom-dark" id="container">
        <!-- Formulário de Login -->
        <div class="form-container login-container absolute top-0 h-full transition-all duration-600 ease-in-out left-0 w-1/2 z-10">
            <form action="" method="POST" class="form_login flex flex-col items-center justify-center bg-white text-center px-12 h-full" id="formLogin">
                <h1 class="font-bold text-3xl mb-3">Login</h1>
                <input type="email" id="accessInput" name="usuario" placeholder="Email ou matrícula" class="inputs_login bg-gray-200 rounded-xl border-none py-3 px-4 my-2 w-full">
                <div class="espaco-senha w-full relative">
                    <input type="password" name="password" placeholder="Password" class="inputs_login bg-gray-200 rounded-xl border-none py-3 px-4 my-2 w-full pr-10" id="senha_entrar">
                    <i class="fa-regular fa-eye olhos obj absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer z-10 text-primary dark:text-darkblue"></i>
                </div>
                <div class="content w-full h-[50px] flex justify-around items-center">
                    <div class="checkbox flex items-center justify-center">
                        <input type="checkbox" id="rememberCheckbox" name="checkbox" class="w-3 h-3 accent-gray-800">
                        <label for="remember-me" class="text-sm pl-1 select-none">lembre-me</label>
                    </div>
                    <div class="pass-link">
                        <a class="obj text-sm hover:text-primary transition-slow dark:hover:text-darkblue" href="./pages/esqueci.php">Esqueceu a senha?</a>
                    </div>
                </div>
                <button type="submit" class="rl-tema obj rounded-2xl border border-primary bg-primary text-white font-bold py-3 px-20 mx-2 my-2 transition-slow hover:tracking-wider active:scale-95 focus:outline-none dark:border-darkblue dark:bg-darkblue" id="vali_login">
                    Login
                </button>
                <div class="social-container obj my-5">
                    <a href="#" class="social obj border-2 border-gray-300 rounded-full inline-flex justify-center items-center h-10 w-10 mx-1 transition-slow hover:border-primary dark:hover:border-darkblue">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" class="social obj border-2 border-gray-300 rounded-full inline-flex justify-center items-center h-10 w-10 mx-1 transition-slow hover:border-primary dark:hover:border-darkblue">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a href="#" class="social obj border-2 border-gray-300 rounded-full inline-flex justify-center items-center h-10 w-10 mx-1 transition-slow hover:border-primary dark:hover:border-darkblue">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                    <a href="#" class="social obj border-2 border-gray-300 rounded-full inline-flex justify-center items-center h-10 w-10 mx-1 transition-slow hover:border-primary dark:hover:border-darkblue">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Formulário de Registro -->
        <div class="form-container register-container absolute top-0 h-full transition-all duration-600 ease-in-out left-0 w-1/2 opacity-0 z-0">
            <form action="" method="POST" id="form" class="form_register flex flex-col items-center justify-center bg-white text-center px-12 h-full">
                <h1 class="problema font-bold text-3xl mb-3">Registre aqui</h1>
                <div class="espaco-input w-full flex flex-col text-left mb-2">
                    <input type="text" name="name" placeholder="Name" class="required input-register bg-gray-200 rounded-xl border-none py-3 px-4 w-full outline-none">
                    <span class="error_span text-red-500 text-xs font-medium hidden"></span>
                </div>
                <div class="espaco-input w-full flex flex-col text-left mb-2">
                    <input type="email" name="email" placeholder="Email" class="required input-register bg-gray-200 rounded-xl border-none py-3 px-4 w-full outline-none">
                    <span class="error_span text-red-500 text-xs font-medium hidden"></span>
                </div>
                <div class="espaco-input w-full flex flex-col text-left mb-2">
                    <input type="tel" name="telefone" placeholder="Numero de telefone" class="required input-register bg-gray-200 rounded-xl border-none py-3 px-4 w-full outline-none">
                    <span class="error_span text-red-500 text-xs font-medium hidden"></span>
                </div>
                <div class="espaco-input w-full flex flex-col text-left mb-2">
                    <input type="text" name="cpf" placeholder="CPF" class="required input-register bg-gray-200 rounded-xl border-none py-3 px-4 w-full outline-none" minlength="11" maxlength="11" pattern="\d{11}" title="O CPF deve conter exatamente 11 dígitos numéricos">
                    <span class="error_span text-red-500 text-xs font-medium hidden"></span>
                </div>
                <div class="espaco-input w-full flex flex-col text-left mb-2">
                    <div class="espaco-senha w-full relative">
                        <input type="password" name="password" placeholder="Password" class="required input-register senha-copy bg-gray-200 rounded-xl border-none py-3 px-4 w-full outline-none pr-10">
                        <i class="fa-regular fa-eye olhos obj absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer z-10 text-primary dark:text-darkblue"></i>
                    </div>
                    <span class="error_span text-red-500 text-xs font-medium hidden"></span>
                </div>
                <div class="espaco-input w-full flex flex-col text-left mb-2">
                    <div class="espaco-senha w-full relative">
                        <input type="password" name="password_confirm" placeholder="Confirm Password" class="required input-register senha-copy bg-gray-200 rounded-xl border-none py-3 px-4 w-full outline-none pr-10">
                        <i class="fa-regular fa-eye olhos obj absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer z-10 text-primary dark:text-darkblue"></i>
                    </div>
                    <div class="gerar-senha flex">
                        <span class="title-senha flex-1 text-xs font-medium flex items-center gap-2">
                            Gere a sua senha:
                            <button class="senha_btn obj bg-transparent border-none text-black cursor-pointer m-0 p-0 w-auto hover:text-primary dark:hover:text-darkblue">
                                <i class="fa-solid fa-lock"></i>
                            </button>
                        </span>
                        <span class="error_span flex-1 text-red-500 text-xs font-medium hidden"></span>
                    </div>
                </div>
                <button type="submit" id="vali_register" class="rl-tema obj rounded-2xl border border-primary bg-primary text-white font-bold py-3 px-20 mx-2 my-2 transition-slow hover:tracking-wider active:scale-95 focus:outline-none dark:border-darkblue dark:bg-darkblue">
                    Registrar
                </button>
                <div class="social-container obj my-5">
                    <a href="#" class="social obj border-2 border-gray-300 rounded-full inline-flex justify-center items-center h-10 w-10 mx-1 transition-slow hover:border-primary dark:hover:border-darkblue">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" class="social obj border-2 border-gray-300 rounded-full inline-flex justify-center items-center h-10 w-10 mx-1 transition-slow hover:border-primary dark:hover:border-darkblue">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a href="#" class="social obj border-2 border-gray-300 rounded-full inline-flex justify-center items-center h-10 w-10 mx-1 transition-slow hover:border-primary dark:hover:border-darkblue">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                    <a href="#" class="social obj border-2 border-gray-300 rounded-full inline-flex justify-center items-center h-10 w-10 mx-1 transition-slow hover:border-primary dark:hover:border-darkblue">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Overlay Container -->
        <div class="overlay-container absolute top-0 left-1/2 w-1/2 h-full overflow-hidden transition-all duration-600 ease-in-out z-[100]">
            <div class="overlay obj bg-[url('../pictures/login/gif-dia.webp')] bg-cover bg-center text-white relative left-[-100%] h-full w-[200%] transition-all duration-600 ease-in-out dark:bg-[url('../pictures/login/gif-noite.webp')]">
                <!-- Gerador de Senha -->
                <div class="overlay-panel overlay-left absolute top-0 flex items-center justify-center flex-col px-10 h-full w-1/2 transition-all duration-600 ease-in-out transform -translate-x-[20%]">
                    <main class="senha_container obj w-full h-full hidden flex-col py-2 px-5 bg-[url('../pictures/login/senha-dia.webp')] bg-cover bg-center overflow-y-auto dark:bg-[url('../pictures/login/senha-noite.webp')]">
                        <section class="senha_dados flex flex-col flex-wrap">
                            <div class="senha_dados-info especial w-full flex flex-col gap-4 mb-3">
                                <div class="senha_title w-full flex items-center">
                                    <p class="title_gerador text-gray-100 font-extrabold text-xl m-0">
                                        Quantidade de caracteres:
                                        <span class="senha_mostrar text-white font-bold" id="mostrar"></span>
                                    </p>
                                </div>
                                <div class="senha_tamanho w-full flex justify-between items-center gap-12">
                                    <input class="senha_linha w-full h-5 bg-gray-200 border-none p-0 m-0" type="range" id="senha-linha" min="8" max="25" value="8">
                                    <input class="senha_caixa w-10 h-5 p-0 text-center" type="number" id="senha-caixa" min="8" max="25" value="8">
                                </div>
                            </div>
                            <div class="senha_dados-info w-full flex justify-between items-center my-3">
                                <p class="title_gerador text-gray-100 font-extrabold text-xl m-0">Incluir letras maiúsculas:</p>
                                <input class="senha-marcavel w-10 h-5 bg-gray-200 border-none p-0 m-0" type="checkbox" id="maiscula">
                            </div>
                            <div class="senha_dados-info w-full flex justify-between items-center my-3">
                                <p class="title_gerador text-gray-100 font-extrabold text-xl m-0">Incluir letras minúsculas:</p>
                                <input class="senha-marcavel w-10 h-5 bg-gray-200 border-none p-0 m-0" type="checkbox" id="minuscula">
                            </div>
                            <div class="senha_dados-info w-full flex justify-between items-center my-3">
                                <p class="title_gerador text-gray-100 font-extrabold text-xl m-0">Incluir números:</p>
                                <input class="senha-marcavel w-10 h-5 bg-gray-200 border-none p-0 m-0" type="checkbox" id="numero">
                            </div>
                            <div class="senha_dados-info w-full flex justify-between items-center my-3">
                                <p class="title_gerador text-gray-100 font-extrabold text-xl m-0">Incluir símbolos:</p>
                                <input class="senha-marcavel w-10 h-5 bg-gray-200 border-none p-0 m-0" type="checkbox" id="simbolo">
                            </div>

                            <div class="senha_button w-full flex justify-center items-center">
                                <button class="senha-btn obj rounded-md border-none bg-primary text-white font-extrabold w-[100px] h-[35px] cursor-pointer m-0 p-0 dark:bg-darkblue" id="gerar">Gerar</button>
                            </div>
                        </section>

                        <section class="senha w-full hidden flex-col rounded-xl h-full bg-gray-200 bg-opacity-90 my-2">
                            <div class="senha_lugar w-full h-full flex items-center justify-center p-1 text-center">
                                <p class="senha_texto m-auto w-full text-blue-600 font-bold text-3xl flex-wrap break-all text-center" id="password"></p>
                            </div>
                            <div class="senha_button w-full flex justify-center items-center">
                                <button class="senha-btn btn-copiar obj rounded-md border-none bg-primary text-white font-extrabold w-[100px] h-[35px] cursor-pointer my-2 p-0 dark:bg-darkblue" id="copiar">
                                    Copiar
                                </button>
                            </div>
                        </section>
                    </main>

                    <h1 class="title gerador-local text-4xl font-bold m-0">Bem-vindo de volta!</h1>
                    <p class="gerador-local p_description text-white font-medium my-5">
                        Para se manter conectado conosco, faça login com suas informações pessoais
                    </p>
                    <button class="ghost gerador-local bg-[rgba(255,255,255,0.2)] text-white border-2 border-white rounded-2xl py-3 px-16 mx-2 my-2 transition-slow hover:tracking-wider" id="login">
                        Login<i class="login fa-solid fa-arrow-left absolute left-16 opacity-0 transition-slow"></i>
                    </button>
                </div>
                <div class="overlay-panel overlay-right absolute top-0 right-0 flex items-center justify-center flex-col px-10 h-full w-1/2 transition-all duration-600 ease-in-out">
                    <h1 class="title text-4xl font-bold m-0">Olá, Amigo!</h1>
                    <p class="p_description text-white font-medium my-5">
                        Insira seus dados pessoais e comece sua jornada conosco
                    </p>
                    <button class="ghost bg-[rgba(255,255,255,0.2)] text-white border-2 border-white rounded-2xl py-3 px-16 mx-2 my-2 transition-slow hover:tracking-wider" id="register">
                        Registrar <i class="register fa-solid fa-arrow-right absolute right-16 opacity-0 transition-slow"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsividade -->
    <style>
        /* Estilos específicos para telas menores */
        @media (max-width: 735px) {
            .container {
                flex-direction: column;
                height: 85vh;
                margin: 2.5rem 0;
            }
            .form-container {
                width: 100%;
            }
            .login-container {
                height: 50%;
            }
            .register-container {
                height: 50%;
                overflow-y: auto;
                background: white;
            }
            .overlay-container {
                top: unset;
                width: 100%;
                height: 50%;
                bottom: 0;
                left: 0;
            }
            .content {
                flex-direction: column;
            }
            button {
                padding: 10px 40px;
            }
            .container.right-panel-active .overlay {
                transform: translateX(50%);
            }
            .container.right-panel-active .overlay-container {
                transform: translateY(-100%);
            }
            .container.right-panel-active .register-container {
                transform: translateY(100%);
            }
            .problema {
                margin-top: 4.5rem;
            }
            .social-container {
                width: 100%;
                justify-content: space-between;
                gap: 0.25rem;
                display: flex;
            }
            .social-container a {
                height: 3.25rem;
                width: 3.25rem;
                border: 2px solid #4bb6b7;
            }
        }

        @media (max-width: 475px) {
            form {
                padding: 20px;
                height: 100%;
            }
            .container {
                height: 85vh;
                margin: 1rem 0;
            }
            .senha_tamanho {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1.25rem;
            }
            .senha_title {
                font-size: 1.5em;
            }
            .senha_dados-info {
                margin: 0.5rem 0;
            }
            .especial {
                margin-bottom: 0;
            }
            .senha-btn {
                margin: 0.75rem 0;
            }
            .senha_texto {
                line-height: 1.5;
            }
        }

        @media (max-width: 320px) {
            .register-container {
                padding-top: 10.25rem;
            }
            .problema {
                margin-top: 0;
            }
            .container {
                margin-top: 3rem;
                margin-bottom: 1rem;
                height: 82vh;
            }
            .login-container {
                padding-top: 4.25rem;
            }
        }

        @media (max-height: 768px) {
            .register-container {
                padding-top: 10.20rem;
            }
            .problema {
                margin-top: 0;
            }
            .container {
                margin-top: 3rem;
                margin-bottom: 1rem;
            }
            .login-container {
                padding-top: 4.25rem;
                overflow-y: auto;
            }
        }

        /* Classes para o dark mode */
        .obj.dark #dark {
            color: white;
        }
        .home-link.dark {
            color: white;
        }
        .tema:hover .home-link.dark {
            color: rgb(43, 43, 151);
        }
        .social-container.dark a {
            border: 2px solid rgb(43, 43, 151);
        }
        .senha_btn.dark:hover i {
            color: rgb(43, 43, 151);
        }
        a.dark:hover {
            color: rgb(43, 43, 151);
        }
        .tema.dark:hover .home-link {
            color: rgb(43, 43, 151);
        }
    </style>
</body>
</html>