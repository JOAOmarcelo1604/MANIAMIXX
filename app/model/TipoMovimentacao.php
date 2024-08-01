<?php

class TipoMovimentacao extends TRecord
{
    const TABLENAME  = 'tipo_movimentacao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const ENTRADA = '1';
    const SAIDA = '2';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
            
    }

    /**
     * Method getMovimentacaos
     */
    public function getMovimentacaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tipo_movimentacao_id', '=', $this->id));
        return Movimentacao::getObjects( $criteria );
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
    
        $values = Movimentacao::where('tipo_movimentacao_id', '=', $this->id)->getIndexedArray('produto_id','{produto->id}');
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
    
        $values = Movimentacao::where('tipo_movimentacao_id', '=', $this->id)->getIndexedArray('tipo_movimentacao_id','{tipo_movimentacao->id}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
            

        if(Movimentacao::where('tipo_movimentacao_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
    }

    
}

