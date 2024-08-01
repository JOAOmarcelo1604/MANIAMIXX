<?php

class Movimentacao extends TRecord
{
    const TABLENAME  = 'movimentacao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $produto;
    private $tipo_movimentacao;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('produto_id');
        parent::addAttribute('quantidade');
        parent::addAttribute('data_movimentacao');
        parent::addAttribute('tipo_movimentacao_id');
            
    }

    /**
     * Method set_produto
     * Sample of usage: $var->produto = $object;
     * @param $object Instance of Produto
     */
    public function set_produto(Produto $object)
    {
        $this->produto = $object;
        $this->produto_id = $object->id;
    }

    /**
     * Method get_produto
     * Sample of usage: $var->produto->attribute;
     * @returns Produto instance
     */
    public function get_produto()
    {
    
        // loads the associated object
        if (empty($this->produto))
            $this->produto = new Produto($this->produto_id);
    
        // returns the associated object
        return $this->produto;
    }
    /**
     * Method set_tipo_movimentacao
     * Sample of usage: $var->tipo_movimentacao = $object;
     * @param $object Instance of TipoMovimentacao
     */
    public function set_tipo_movimentacao(TipoMovimentacao $object)
    {
        $this->tipo_movimentacao = $object;
        $this->tipo_movimentacao_id = $object->id;
    }

    /**
     * Method get_tipo_movimentacao
     * Sample of usage: $var->tipo_movimentacao->attribute;
     * @returns TipoMovimentacao instance
     */
    public function get_tipo_movimentacao()
    {
    
        // loads the associated object
        if (empty($this->tipo_movimentacao))
            $this->tipo_movimentacao = new TipoMovimentacao($this->tipo_movimentacao_id);
    
        // returns the associated object
        return $this->tipo_movimentacao;
    }

    
}

