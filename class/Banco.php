<?php

/*
  - Classes para acesso a bancos de dados
  - Jorél Luiz Precoma
 */

define("DB_HOSTI", "localhost"); // host de conexão com o MySQL
define("DB_USERNAMEI", "root"); // nome do usuário para conexão
define("DB_PASSWORDI", "root"); // senha do usuário para conexão
define("DB_DATABASEI", "information_schema"); // nome do bd

class Banco {

    var $dbi;
    var $query;

    // função que starta o MySql, sem ela é impossivel conectar ao banco
    function open() {
        // conecta com o bd com as variáveis prédefinidas
        $this->dbi = mysql_connect(DB_HOSTI, DB_USERNAMEI, DB_PASSWORDI);
        if (!$this->dbi) {
            echo "Erro na conexão!";
        }
        if (!mysql_select_db(DB_DATABASEI)) {
            echo "Erro na seleção do banco de dados!";
        }
    }

    // fecha a conexão com o bco de dados
    function close() {
        mysql_close($this->dbi);
    }

    // retorna quantas linhas aquela query resultou
    function linhas() {
        return mysql_num_rows($this->query);
    }

    // retorna o conteúdo do campo e linha escolhidos
    function result($linha, $campo) {
        return mysql_result($this->query, $linha, $campo);
    }

    // mesma coisa que o result() vou demonstrar a diferença no uso
    function retorno($linha, $campo) {
        return mysql_result($this->consulta, $linha, $campo);
    }

    // mesma coisa que o linhas() vou demonstrar a diferença
    function resultado() {
        return mysql_num_rows($this->consulta);
    }

}

?>