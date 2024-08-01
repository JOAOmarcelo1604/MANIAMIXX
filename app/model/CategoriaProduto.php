<?php

class CategoriaProduto extends TRecord
{
    const TABLENAME  = 'categoria_produto';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
            
    }

    /**
     * Method getProdutos
     */
    public function getProdutos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categoria_produto_id', '=', $this->id));
        return Produto::getObjects( $criteria );
    }

    public function set_produto_categoria_produto_to_string($produto_categoria_produto_to_string)
    {
        if(is_array($produto_categoria_produto_to_string))
        {
            $values = CategoriaProduto::where('id', 'in', $produto_categoria_produto_to_string)->getIndexedArray('id', 'id');
            $this->produto_categoria_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_categoria_produto_to_string = $produto_categoria_produto_to_string;
        }

        $this->vdata['produto_categoria_produto_to_string'] = $this->produto_categoria_produto_to_string;
    }

    public function get_produto_categoria_produto_to_string()
    {
        if(!empty($this->produto_categoria_produto_to_string))
        {
            return $this->produto_categoria_produto_to_string;
        }
    
        $values = Produto::where('categoria_produto_id', '=', $this->id)->getIndexedArray('categoria_produto_id','{categoria_produto->id}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
            

        if(Produto::where('categoria_produto_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
    }

    
}

