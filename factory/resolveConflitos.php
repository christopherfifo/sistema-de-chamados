<?php

require_once 'model/conflitos.php';

class ResolveConflitos
{
    private $conflitos;

    public function __construct()
    {
        $this->conflitos = new Conflitos();
    }

    public function getNovoCodeCalled($idCalled)
    {
        // Obtém os códigos existentes
        $existingCodes = $this->conflitos->getConflitos($idCalled);

        // Extrai os valores de code_called em um array simples
        $codes = array_column($existingCodes, 'code_called');

        // Ordena os códigos em ordem crescente
        sort($codes);

        // Encontra o menor valor possível que não cause conflito
        $novoCode = 1; // Começa com o menor valor possível
        foreach ($codes as $code) {
            if ($code == $novoCode) {
                $novoCode++; // Incrementa se houver conflito
            } else {
                break; // Para quando encontrar um valor disponível
            }
        }

        return $novoCode;
    }
}

?>