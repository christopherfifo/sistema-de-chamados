<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../javascript/tec.js" defer></script>
  <title>Login dos tecnicos</title>
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
              '0%, 49.99%': {
                opacity: '0',
                zIndex: '1'
              },
              '50%, 100%': {
                opacity: '1',
                zIndex: '5'
              },
            }
          }
        }
      }
    }
  </script>
  <script>
    (function() {
      const userPref = localStorage.getItem('theme');
      const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

      if (userPref === 'dark' || (!userPref && systemPrefersDark)) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    })();
  </script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">

  <div class="w-full max-w-md p-6">
    <div class="form-container login-container w-full bg-white shadow-lg rounded-2xl">
      <form action="../controller/authController.php" method="POST" class="form_login flex flex-col items-center justify-center text-center px-8 py-10" id="formLogin">
        <h1 class="font-bold text-3xl mb-4">Tecnicos</h1>
        <input type="hidden" name="action" value="Tectechnicians_login">
        <input type="text" id="accessInput" name="usuario" placeholder="matrícula" class="inputs_login bg-gray-200 rounded-xl border-none py-3 px-4 my-2 w-full">
        <div class="espaco-senha w-full relative">
          <input type="password" name="password" placeholder="Password" class="inputs_login bg-gray-200 rounded-xl border-none py-3 px-4 my-2 w-full pr-10" id="senha_entrar">
          <i class="fa-regular fa-eye olhos obj absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer z-10 text-primary dark:text-darkblue"></i>
        </div>
        <div class="content w-full h-[50px] flex pl-1 text-sm mt-2">
          <label class="flex items-center">
            <input type="checkbox" id="rememberCheckbox" name="checkbox" class="w-3 h-3 accent-gray-800">
            <span class="pl-2 select-none">lembre-me</span>
          </label>
        </div>
        <button type="submit" class="rl-tema obj rounded-2xl border border-primary bg-primary text-white font-bold py-3 px-20 my-4 transition-slow hover:tracking-wider active:scale-95 focus:outline-none dark:border-darkblue dark:bg-darkblue" id="vali_login">
          Login
        </button>
      </form>
    </div>
  </div>

</body>

</html>