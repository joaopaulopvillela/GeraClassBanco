<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once 'class/SQL.php';
        $sql = new SQL();
        $dados['TABLE_NAME'] = '';
        foreach ($sql->executaSQL($dados, "TABLES", "SELECT", "TABLE_SCHEMA = 'colegioMetodo'") as $tabelas) {


            $dados['COLUMN_NAME'] = '';
            $dados['DATA_TYPE'] = '';
            $dados['CHARACTER_MAXIMUM_LENGTH'] = '';
            $dados['COLUMN_TYPE'] = '';

            foreach ($sql->executaSQL($dados, 'COLUMNS', 'SELECT', 'TABLE_SCHEMA = "colegioMetodo" AND TABLE_NAME = "' . $tabelas['TABLE_NAME'] . '"') as $result) {
                $array['atributos'][] = $result['COLUMN_NAME'];
                $array['tipo'][] = $result['DATA_TYPE'];
                $array['tamanho'][] = $result['CHARACTER_MAXIMUM_LENGTH'];
                $array['resulno'][] = $result['COLUMN_TYPE'];
            }

            //Criando a class
            //Inicio da class
            $incial = 'include_once "DAO.php";
                  include_once "../funcoes/Data.php";
                /**
                 * Gerada automaticamente pelo sistema.<br>
                 * Description of ' . $tabelas['TABLE_NAME'] . '
                 *
                 * @author João Paulo
                 */
                class ' . ucfirst($tabelas['TABLE_NAME']) . ' extends DAO {
                ';
            $total = count($array['atributos']);
            for ($i = 0; $i < $total; $i++) {
                $atributos = $array['atributos'][$i];
                $tipo = $array['tipo'][$i];
                $tamanho = $array['tamanho'][$i];
                $resuno = $array['resulno'][$i];
                $private .= '/**
                              * Valor adequado para a varivel deve ser ' . $resuno . '
                              * @var ' . $tipo . '
                              */
                              ';
                $private .= 'private $' . $atributos . ';
                            ';
                $set .= '/**
                          * Setando um novo valor para ' . $resuno . '
                          * @param ' . $tipo . ' $' . $atributos . '
                          */';
                $set .= 'public function set' . ucfirst($atributos) . '($' . $atributos . ') {
                            if(!empty($' . $atributos . ')){
                            $this->' . $atributos . ' = $' . $atributos . ';
                                }
                         }';
                $set .= '/**
                          * Valor do atributo ' . $atributos . '
                          * @return ' . $tipo . ' 
                          */
                          ';
                $set .= 'public function get' . ucfirst($atributos) . '() {
                                return $this->' . $atributos . ';
                         }';
            }
            unset ($array);
            $final .= '/** 
                        * Instancia o objeto
                        */
                        public function __construct() {
                            parent::__construct("' . $tabelas['TABLE_NAME'] . '");
                            $this->idUsuario = 2;
                        }';

            $final .= '/**
                        * Colocar todos os dados dentro de um objeto. passando um Array com a possição e o seu valor
                        * @param array $array
                        */
                         public function todosDados($array) {
                            parent::todosDados($array, $this);
                         }';

            $final .= '/** 
                        * Grava os dados do objeto na tabela.
                        */
                        public function gravar() {
                            try {
                                if (!$this->validar()) {
                                    throw new Exception("Campos Obrigatoris não preenchidos.");
                                }
                                converteData($this->dataCadastro);

                                return parent::gravar($this->buscarTodos());
                            } catch (Exception $erro) {
                                echo $erro->getMessage();
                            }
                        }';
            $final .= '/**
                        * Altera os dados
                        */
                        public function alterar() {
                                if (!$this->validar()) {
                                    throw new Exception("Campos Obrigatoris não preenchidos.");
                                }
                                parent::alterar($this->buscarTodos());
                            }';
            $final .= '/** 
                        * Seleciona o dado passado
                        *
                        * @param int $id
                        */
                        public function seleciona($id) {
                            parent::seleciona($id, $this);
                            desConverteData($this->dataCadastro);
                        }';
            $final .= '/** 
                        * Seleciona o dado passado
                        *
                        * @param int $id
                        */
                        private function buscarTodos() {

                            $reflector = new ReflectionClass($this);

                            //Now get all the properties from class A in to $properties array
                            $properties = $reflector->getProperties();
                            //Now go through the $properties array and populate each property
                            foreach ($properties as $property) {
                                $nome = $property->getName();
                                $dados[$nome] = $this->$nome;
                            }
                            return $dados;
                        }';

            $final .= '/** 
                        * Valida a função para saber se esta tudo correto para ser gravado.
                        */
                        private function validar() { return true;}';
            
            $fp = fopen('classGeradas/'.ucfirst($tabelas['TABLE_NAME']).".php", "a");

            $escrito = fwrite($fp, "<?\n");
            $escrito = fwrite($fp, $incial);
            $escrito = fwrite($fp, $private);
            $escrito = fwrite($fp, $set);
            $escrito = fwrite($fp, $final);
            $escrito = fwrite($fp, "\n} ?>");
            fclose($fp);
            echo "Arquivo ".ucfirst($tabelas['TABLE_NAME'])." escrito com sucesso.<br>";
            $incial = $private = $set = $final = "";
            
        }
        ?>
    </body>
</html>
