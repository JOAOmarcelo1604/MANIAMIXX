<?php

class Clientes extends TRecord
{
    const TABLENAME  = 'clientes';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('email');
        parent::addAttribute('telefone');
        parent::addAttribute('endereco');
            
    }

    /**
     * Method getVendass
     */
    public function getVendass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('clientes_id', '=', $this->id));
        return Vendas::getObjects( $criteria );
    }

    public function set_vendas_produto_to_string($vendas_produto_to_string)
    {
        if(is_array($vendas_produto_to_string))
        {
            $values = Produto::where('id', 'in', $vendas_produto_to_string)->getIndexedArray('id', 'id');
            $this->vendas_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->vendas_produto_to_string = $vendas_produto_to_string;
        }

        $this->vdata['vendas_produto_to_string'] = $this->vendas_produto_to_string;
    }

    public function get_vendas_produto_to_string()
    {
        if(!empty($this->vendas_produto_to_string))
        {
            return $this->vendas_produto_to_string;
        }
    
        $values = Vendas::where('clientes_id', '=', $this->id)->getIndexedArray('produto_id','{produto->id}');
        return implode(', ', $values);
    }

    public function set_vendas_clientes_to_string($vendas_clientes_to_string)
    {
        if(is_array($vendas_clientes_to_string))
        {
            $values = Clientes::where('id', 'in', $vendas_clientes_to_string)->getIndexedArray('id', 'id');
            $this->vendas_clientes_to_string = implode(', ', $values);
        }
        else
        {
            $this->vendas_clientes_to_string = $vendas_clientes_to_string;
        }

        $this->vdata['vendas_clientes_to_string'] = $this->vendas_clientes_to_string;
    }

    public function get_vendas_clientes_to_string()
    {
        if(!empty($this->vendas_clientes_to_string))
        {
            return $this->vendas_clientes_to_string;
        }
    
        $values = Vendas::where('clientes_id', '=', $this->id)->getIndexedArray('clientes_id','{clientes->id}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
            

        if(Vendas::where('clientes_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
    }

    
}

