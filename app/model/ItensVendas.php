<?php

class ItensVendas extends TRecord
{
    const TABLENAME  = 'itens_vendas';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $vendas;
    private $produto;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('quantidade');
        parent::addAttribute('preco_unitario');
        parent::addAttribute('preco_total');
        parent::addAttribute('vendas_id');
        parent::addAttribute('produto_id');
            
    }

    /**
     * Method set_vendas
     * Sample of usage: $var->vendas = $object;
     * @param $object Instance of Vendas
     */
    public function set_vendas(Vendas $object)
    {
        $this->vendas = $object;
        $this->vendas_id = $object->id;
    }

    /**
     * Method get_vendas
     * Sample of usage: $var->vendas->attribute;
     * @returns Vendas instance
     */
    public function get_vendas()
    {
    
        // loads the associated object
        if (empty($this->vendas))
            $this->vendas = new Vendas($this->vendas_id);
    
        // returns the associated object
        return $this->vendas;
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

    
}

