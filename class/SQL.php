<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'Banco.php';
/**
 * Description of util
 *
 * @author joaopaulo
 */
class SQL {
    protected $banco;

    //put your code here
    public function __construct() {
        $this->banco = new Banco();
        $this->banco->open();
    }

    public function __destruct() {
        
    }

    /**
     * Verifica se a pesquisa retornou algum valor SELECT
     * @param <type> $res
     * @param <type> $valor
     * @return <bool>
     */
    public function verificaPesquisa($res, $valor) {

        if (mysql_num_rows($res) > 0)
            return true;
        else
            return false;
    }

    /**
     * Verifica se a operacao com o banco retornou algum valor DELET, INSERT, UPADATE
     * @param <type> $valor
     * @return <type>
     */
    public function verificaInsercao($valor) {
        if (mysql_affect_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param array $dados
     * @param string $tabela
     * @param string $tipoSQL INSERT-UPDATE-SELECT-DELETE
     * @param string $limit Não precisa ser informado a palavra limit
     * @param string $order Não precisa ser informado a palavra order by
     * @param string $condicao
     * @return string $sql
     *
     */
    public function gerarSQL($dados, $tabela, $tipoSQL, $condicao='', $order='', $limit='', $group='') {

        if (!empty($order)) {
            $order = "ORDER BY " . $order;
        }
        if (!empty($limit)) {
            $limit = "LIMIT " . $limit;
        }
        if (!empty($group)) {
            $group = "GROUP BY " . $group;
        }
        $sql = "";
        $column = "";
        $values = "";
        $update = "";
        $select = "";
        foreach ($dados as $key => $value) {
            if (!is_array($value)) {
                $column .= $key . ", ";
                $values .= '\'' . $value . '\', ';
                $update .= $key . ' = \'' . $value . '\', ';
                $select .= $key . ' = \'' . $value . '\' AND ';
            }
        }
        $column = substr($column, 0, strlen($column) - 2);
        $values = substr($values, 0, strlen($values) - 2);
        $update = substr($update, 0, strlen($update) - 2);
        $select = substr($select, 0, strlen($select) - 5);
        if ($tipoSQL == "INSERT") {
            $sql = "INSERT INTO $tabela (" . $column . ") VALUES (" . $values . ");";
        } else if ($tipoSQL == "UPDATE") {
            $sql = "UPDATE $tabela SET $update WHERE $condicao";
        } else if ($tipoSQL == "SELECT") {
            if (empty($condicao))
                $sql = "SELECT " . $column . " FROM " . $tabela . " WHERE " . $select;
            else
                $sql = "SELECT " . $column . " FROM " . $tabela . " WHERE " . $condicao;
        } else if ($tipoSQL == "DELETE") {
            $sql = "DELETE FROM {$tabela} WHERE {$condicao}";
        }
        return $sql . ' ' . $group . ' ' . $order . ' ' . $limit;
    }

    /**
     *
     * @param array $dados
     * @param string $tabela
     * @param string $tipoSQL INSERT-UPDATE-SELECT-DELETE
     * @param string $condicao
     * @param string $order
     * @param string $limit
     * @return array $valores
     */
    public function executaSQL($dados, $tabela, $tipoSQL, $condicao='', $order='', $limit='', $group='') {

        $sql = $this->gerarSQL($dados, $tabela, $tipoSQL, $condicao, $order, $limit, $group);
//        print $sql;
        $res = mysql_query($sql);
        if (!$res)
            throw new Exception("Erro na hora de executar o sql na tabela $tabela. " . mysql_error() . "<br>");
        //Faz o calculo para saber a quantidade geral.
        if ($tipoSQL == "SELECT") {
            $temp = explode("LIMIT", $sql);
            if(count($temp) > 1){
                $sqlTemp = $temp[0];
            } else $sqlTemp = $sql;
            
            $resTemp = mysql_query($sqlTemp);
            if (!$resTemp) throw new Exception("Erro na hora de executar o sql na tabela $tabela. " . mysql_error() . "<br>" . $sqlTemp);
           $_SESSION['totalRelatorio'] = mysql_num_rows($resTemp);
        }

        if ($tipoSQL == "INSERT") {
            return mysql_insert_id();
        }
        if ($tipoSQL == "UPDATE" || $tipoSQL == "DELETE") {
            return mysql_affected_rows($res);
        }
        if ($tipoSQL == "SELECT") {
            while ($x = mysql_fetch_assoc($res)) {
                $valores[] = $x;
            }
            return $valores;
        }
    }

    /**
     * Seleciona todos os dados da $tabela com a $codicao e retorno o sql de UPDATE
     * @param  string $tabela
     * @param  string $codicao
     * @return string $sql
     */
    public function geraReverso($tabela, $codicao) {
        //print "Gerar o reverso $tabela => $codicao<br>";

        conectaDB();
        $sql = "SELECT * FROM $tabela WHERE " . $codicao;
        $resReverso = mysql_query($sql) or die(print "Vixi deu erro");
        $dados = mysql_fetch_assoc($resReverso);

        return $this->gerarSQL($dados, $tabela, "UPDATE", $codicao);
    }

}

?>
