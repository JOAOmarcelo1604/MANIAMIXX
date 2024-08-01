<?php

class Vendas extends TRecord
{
    const TABLENAME  = 'vendas';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $produto;
    private $clientes;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('data_venda');
        parent::addAttribute('produto_id');
        parent::addAttribute('total_venda');
        parent::addAttribute('forma_pagamento');
        parent::addAttribute('vendedor');
        parent::addAttribute('lucro');
        parent::addAttribute('faturamento');
        parent::addAttribute('valor');
        parent::addAttribute('nome_produto');
        parent::addAttribute('quantidade');
        parent::addAttribute('clientes_id');
            
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
     * Method set_clientes
     * Sample of usage: $var->clientes = $object;
     * @param $object Instance of Clientes
     */
    public function set_clientes(Clientes $object)
    {
        $this->clientes = $object;
        $this->clientes_id = $object->id;
    }

    /**
     * Method get_clientes
     * Sample of usage: $var->clientes->attribute;
     * @returns Clientes instance
     */
    public function get_clientes()
    {
    
        // loads the associated object
        if (empty($this->clientes))
            $this->clientes = new Clientes($this->clientes_id);
    
        // returns the associated object
        return $this->clientes;
    }

    /**
     * Method getItensVendass
     */
    public function getItensVendass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('vendas_id', '=', $this->id));
        return ItensVendas::getObjects( $criteria );
    }

    public function set_itens_vendas_vendas_to_string($itens_vendas_vendas_to_string)
    {
        if(is_array($itens_vendas_vendas_to_string))
        {
            $values = Vendas::where('id', 'in', $itens_vendas_vendas_to_string)->getIndexedArray('id', 'id');
            $this->itens_vendas_vendas_to_string = implode(', ', $values);
        }
        else
        {
            $this->itens_vendas_vendas_to_string = $itens_vendas_vendas_to_string;
        }

        $this->vdata['itens_vendas_vendas_to_string'] = $this->itens_vendas_vendas_to_string;
    }

    public function get_itens_vendas_vendas_to_string()
    {
        if(!empty($this->itens_vendas_vendas_to_string))
        {
            return $this->itens_vendas_vendas_to_string;
        }
    
        $values = ItensVendas::where('vendas_id', '=', $this->id)->getIndexedArray('vendas_id','{vendas->id}');
        return implode(', ', $values);
    }

    public function set_itens_vendas_produto_to_string($itens_vendas_produto_to_string)
    {
        if(is_array($itens_vendas_produto_to_string))
        {
            $values = Produto::where('id', 'in', $itens_vendas_produto_to_string)->getIndexedArray('id', 'id');
            $this->itens_vendas_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->itens_vendas_produto_to_string = $itens_vendas_produto_to_string;
        }

        $this->vdata['itens_vendas_produto_to_string'] = $this->itens_vendas_produto_to_string;
    }

    public function get_itens_vendas_produto_to_string()
    {
        if(!empty($this->itens_vendas_produto_to_string))
        {
            return $this->itens_vendas_produto_to_string;
        }
    
        $values = ItensVendas::where('vendas_id', '=', $this->id)->getIndexedArray('produto_id','{produto->id}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
            

        if(ItensVendas::where('vendas_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
    }

    
}

