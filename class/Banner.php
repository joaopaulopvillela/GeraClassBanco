<?

include_once "DAO.php";
include_once "../funcoes/Data.php";

/**
 * Gerada automaticamente pelo sistema.
 * Description of banner
 *
 * @author João Paulo
 */
class Banner extends DAO {

    /**
     * Valor adequado para a varivel deve ser int(11)
     * @var int
     */
    private $id;
    /**
     * Valor adequado para a varivel deve ser varchar(30)
     * @var varchar
     */
    private $tipo;
    /**
     * Valor adequado para a varivel deve ser varchar(100)
     * @var varchar
     */
    private $descricao;
    /**
     * Valor adequado para a varivel deve ser datetime
     * @var datetime
     */
    private $dataInicio;
    /**
     * Valor adequado para a varivel deve ser datetime
     * @var datetime
     */
    private $dataFim;
    /**
     * Valor adequado para a varivel deve ser varchar(150)
     * @var varchar
     */
    private $linkArquivo;
    /**
     * Valor adequado para a varivel deve ser enum('S','N')
     * @var enum
     */
    private $ativo;
    /**
     * Valor adequado para a varivel deve ser datetime
     * @var datetime
     */
    private $dataCadastro;
    /**
     * Valor adequado para a varivel deve ser varchar(45)
     * @var varchar
     */
    private $idUsuario;

    /**
     * Setando um novo valor para int(11)
     * @param int $id
     * */
    public function setId($id) {
        if (!empty($id)) {
            $this->id = $id;
        }
    }

    /**
     * Valor do atributo id
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Setando um novo valor para varchar(30)
     * @param varchar $tipo
     * */
    public function setTipo($tipo) {
        if (!empty($tipo)) {
            $this->tipo = $tipo;
        }
    }

    /**
     * Valor do atributo tipo
     * @return varchar
     */
    public function getTipo() {
        return $this->tipo;
    }

    /**
     * Setando um novo valor para varchar(100)
     * @param varchar $descricao
     * */
    public function setDescricao($descricao) {
        if (!empty($descricao)) {
            $this->descricao = $descricao;
        }
    }

    /**
     * Valor do atributo descricao
     * @return varchar
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Setando um novo valor para datetime
     * @param datetime $dataInicio
     * */
    public function setDataInicio($dataInicio) {
        if (!empty($dataInicio)) {
            $this->dataInicio = $dataInicio;
        }
    }

    /**
     * Valor do atributo dataInicio
     * @return datetime
     */
    public function getDataInicio() {
        return $this->dataInicio;
    }

    /**
     * Setando um novo valor para datetime
     * @param datetime $dataFim
     * */
    public function setDataFim($dataFim) {
        if (!empty($dataFim)) {
            $this->dataFim = $dataFim;
        }
    }

    /**
     * Valor do atributo dataFim
     * @return datetime
     */
    public function getDataFim() {
        return $this->dataFim;
    }

    /**
     * Setando um novo valor para varchar(150)
     * @param varchar $linkArquivo
     * */
    public function setLinkArquivo($linkArquivo) {
        if (!empty($linkArquivo)) {
            $this->linkArquivo = $linkArquivo;
        }
    }

    /**
     * Valor do atributo linkArquivo
     * @return varchar
     */
    public function getLinkArquivo() {
        return $this->linkArquivo;
    }

    /**
     * Setando um novo valor para enum('S','N')
     * @param enum $ativo
     * */
    public function setAtivo($ativo) {
        if (!empty($ativo)) {
            $this->ativo = $ativo;
        }
    }

    /**
     * Valor do atributo ativo
     * @return enum
     */
    public function getAtivo() {
        return $this->ativo;
    }

    /**
     * Setando um novo valor para datetime
     * @param datetime $dataCadastro
     * */
    public function setDataCadastro($dataCadastro) {
        if (!empty($dataCadastro)) {
            $this->dataCadastro = $dataCadastro;
        }
    }

    /**
     * Valor do atributo dataCadastro
     * @return datetime
     */
    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    /**
     * Setando um novo valor para varchar(45)
     * @param varchar $idUsuario
     * */
    public function setIdUsuario($idUsuario) {
        if (!empty($idUsuario)) {
            $this->idUsuario = $idUsuario;
        }
    }

    /**
     * Valor do atributo idUsuario
     * @return varchar
     */
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    /**
     * Instancia o objeto
     * */ public function __construct() {
        parent::__construct("banner");
        $this->idUsuario = 2;
    }

/**
     * Colocar todos os dados dentro de um objeto. passando um Array com a possição e o seu valor
     * @param array $array
     * */

    public function todosDados($array) {
        parent::todosDados($array, $this);
    }

/**
     * Grava os dados do objeto na tabela.
     * */

    public function gravar() {
        try {
            if (!$this->validar()) {
                throw new Exception("Campos Obrigatoris não preenchidos.");
            } converteData($this->dataCadastro);
            return parent::gravar($this->buscarTodos());
        } catch (Exception $erro) {
            echo $erro->getMessage();
        }
    }

/**
     * Altera os dados
     *
     * */

    public function alterar() {
        if (!$this->validar()) {
            throw new Exception("Campos Obrigatoris não preenchidos.");
        } parent::alterar($this->buscarTodos());
    }

/**
     * Seleciona o dado passado
     *
     * @param int $id
     * */

    public function seleciona($id) {
        parent::seleciona($id, $this);
        desConverteData($this->dataCadastro);
    }

/**
     * Seleciona o dado passado
     *
     * @param int $id
     * */

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
    }

/**
     * Valida a função para saber se esta tudo correto para ser gravado.
     * */

    private function validar() {
        return true;
    }

}
?>