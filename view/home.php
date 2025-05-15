<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Sistema de Chamados</title>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#4bb6b7',
            darkblue: 'rgb(43, 43, 151)',
          },
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

    const toggleTheme = () => {
      if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
      } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
      }
    }
  </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center px-4">

  <div class="max-w-4xl w-full bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="grid grid-cols-1 md:grid-cols-2">

      <!-- Lado esquerdo: apresentação -->
      <div class="flex flex-col justify-center p-8 bg-primary text-white">
        <h2 class="text-3xl font-bold mb-4">Bem-vindo ao Sistema de Chamados</h2>
        <p class="mb-6">Gerencie solicitações, resolva problemas e acompanhe atendimentos com eficiência.</p>
        <ul class="space-y-2 text-sm">
          <li><i class="fas fa-check mr-2"></i>Crie ou acompanhe chamados</li>
          <li><i class="fas fa-check mr-2"></i>Acesso diferenciado para técnicos</li>
          <li><i class="fas fa-check mr-2"></i>Interface intuitiva e rápida</li>
        </ul>
      </div>

      <!-- Lado direito: ações -->
      <div class="flex flex-col justify-center items-center p-10 space-y-6 bg-white dark:bg-gray-900">
        <h3 class="text-2xl font-semibold">Escolha sua opção</h3>

        <!-- Botões de ação -->
        <div class="w-full space-y-4">
          <a href="./login.php" class="block text-center bg-primary text-white py-3 rounded-xl font-bold hover:bg-[#3ba7a7] transition duration-300">Sou Usuário - Cadastrar/Logar</a>
          <a href="./loginTec.php" class="block text-center border-2 border-darkblue text-darkblue py-3 rounded-xl font-bold hover:bg-darkblue hover:text-white transition duration-300">Sou Técnico - Entrar</a>
        </div>

        <!-- Alternância de tema -->
        <button onclick="toggleTheme()" class="mt-6 text-sm underline hover:text-primary transition">Alternar tema</button>
      </div>

    </div>
  </div>

</body>

</html>