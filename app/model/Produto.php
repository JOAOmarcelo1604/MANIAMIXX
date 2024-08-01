<?php

class Produto extends TRecord
{
    const TABLENAME  = 'produto';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $categoria_produto;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('categoria_produto_id');
        parent::addAttribute('nome');
        parent::addAttribute('total_estoque');
        parent::addAttribute('valor');
        parent::addAttribute('imagem');
        parent::addAttribute('valor_atacado');
            
    }

    /**
     * Method set_categoria_produto
     * Sample of usage: $var->categoria_produto = $object;
     * @param $object Instance of CategoriaProduto
     */
    public function set_categoria_produto(CategoriaProduto $object)
    {
        $this->categoria_produto = $object;
        $this->categoria_produto_id = $object->id;
    }

    /**
     * Method get_categoria_produto
     * Sample of usage: $var->categoria_produto->attribute;
     * @returns CategoriaProduto instance
     */
    public function get_categoria_produto()
    {
    
        // loads the associated object
        if (empty($this->categoria_produto))
            $this->categoria_produto = new CategoriaProduto($this->categoria_produto_id);
    
        // returns the associated object
        return $this->categoria_produto;
    }

    /**
     * Method getMovimentacaos
     */
    public function getMovimentacaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return Movimentacao::getObjects( $criteria );
    }
    /**
     * Method getVendass
     */
    public function getVendass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return Vendas::getObjects( $criteria );
    }
    /**
     * Method getItensVendass
     */
    public function getItensVendass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return ItensVendas::getObjects( $criteria );
    }

    public function set_movimentacao_produto_to_string($movimentacao_produto_to_string)
    {
        if(is_array($movimentacao_produto_to_string))
        {
            $values = Produto::where('id', 'in', $movimentacao_produto_to_string)->getIndexedArray('id', 'id');
            $this->movimentacao_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->movimentacao_produto_to_string = $movimentacao_produto_to_string;
        }

        $this->vdata['movimentacao_produto_to_string'] = $this->movimentacao_produto_to_string;
    }

    public function get_movimentacao_produto_to_string()
    {
        if(!empty($this->movimentacao_produto_to_string))
        {
            return $this->movimentacao_produto_to_string;
        }
    
        $values = Movimentacao::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->id}');
        return implode(', ', $values);
    }

    public function set_movimentacao_tipo_movimentacao_to_string($movimentacao_tipo_movimentacao_to_string)
    {
        if(is_array($movimentacao_tipo_movimentacao_to_string))
        {
            $values = TipoMovimentacao::where('id', 'in', $movimentacao_tipo_movimentacao_to_string)->getIndexedArray('id', 'id');
            $this->movimentacao_tipo_movimentacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->movimentacao_tipo_movimentacao_to_string = $movimentacao_tipo_movimentacao_to_string;
        }

        $this->vdata['movimentacao_tipo_movimentacao_to_string'] = $this->movimentacao_tipo_movimentacao_to_string;
    }

    public function get_movimentacao_tipo_movimentacao_to_string()
    {
        if(!empty($this->movimentacao_tipo_movimentacao_to_string))
        {
            return $this->movimentacao_tipo_movimentacao_to_string;
        }
    
        $values = Movimentacao::where('produto_id', '=', $this->id)->getIndexedArray('tipo_movimentacao_id','{tipo_movimentacao->id}');
        return implode(', ', $values);
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
    
        $values = Vendas::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->id}');
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
    
        $values = Vendas::where('produto_id', '=', $this->id)->getIndexedArray('clientes_id','{clientes->id}');
        return implode(', ', $values);
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
    
        $values = ItensVendas::where('produto_id', '=', $this->id)->getIndexedArray('vendas_id','{vendas->id}');
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
    
        $values = ItensVendas::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->id}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
            

        if(Movimentacao::where('produto_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
        if(Vendas::where('produto_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
        if(ItensVendas::where('produto_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
    }

    
}

