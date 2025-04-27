<?php

class Caminho {
    public static $host = "localhost";
    public static $usuario = "root";
    public static $senha = "";
    public static $banco = "";
    public static $connect = null;

    public static function setDados($host, $usuario, $senha, $banco) {
        self::$host = $host;
        self::$usuario = $usuario;
        self::$senha = $senha;
        self::$banco = $banco;
    }

    private static function conectar() {
        try {
            if (self::$connect == null) {
                self::$connect = new PDO("host=localhost;dbname=bdlojinha2000;", self::$usuario, self::$senha);
                self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (Exception $ex) {
            echo "Erro ao conectar ao banco de dados: " . $ex->getMessage();
            die;
        }

        return self::$connect;
    }

    public function getConexao() {
        return self::conectar();
    }
}

// statica voce não precisa instanciar a classe para usar o atributo, ela so usa dentro da classe
// self é para referenciar a classe atual, ou seja, o mesmo que Caminho::$connect, usado para staticos
// this é para referenciar a instancia da classe, ou seja, o mesmo que $this->connect, usado para não estaticos

// pdo não é um banco de dados, é uma classe que permite conectar a varios bancos de dados, como mysql, postgresql, sqlite, etc
?>
