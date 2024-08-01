<?php

class MovimentacaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'estoque';
    private static $activeRecord = 'Movimentacao';
    private static $primaryKey = 'id';
    private static $formName = 'form_MovimentacaoForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro De Movimentação");

        $criteria_produto_id = new TCriteria();
        $criteria_tipo_movimentacao_id = new TCriteria();

        $id = new TEntry('id');
        $produto_id = new TDBCombo('produto_id', 'estoque', 'Produto', 'id', '{nome}','id asc' , $criteria_produto_id );
        $quantidade = new TEntry('quantidade');
        $data_movimentacao = new TDateTime('data_movimentacao');
        $tipo_movimentacao_id = new TDBCombo('tipo_movimentacao_id', 'estoque', 'TipoMovimentacao', 'id', '{nome}','id asc' , $criteria_tipo_movimentacao_id );

        $produto_id->addValidation("Produto id", new TRequiredValidator()); 
        $tipo_movimentacao_id->addValidation("Tipo movimentacao id", new TRequiredValidator()); 

        $id->setEditable(false);
        $data_movimentacao->setMask('dd/mm/yyyy hh:ii');
        $data_movimentacao->setDatabaseMask('yyyy-mm-dd hh:ii');
        $produto_id->enableSearch();
        $tipo_movimentacao_id->enableSearch();

        $id->setSize(100);
        $produto_id->setSize('100%');
        $quantidade->setSize('100%');
        $data_movimentacao->setSize(150);
        $tipo_movimentacao_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id]);
        $row1->layout = ['col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Produto:", null, '14px', null, '100%'),$produto_id]);
        $row2->layout = ['col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Quantidade:", null, '14px', null, '100%'),$quantidade]);
        $row3->layout = ['col-sm-12'];

        $row4 = $this->form->addFields([new TLabel("Data:", null, '14px', null, '100%'),$data_movimentacao]);
        $row4->layout = ['col-sm-12'];

        $row5 = $this->form->addFields([new TLabel("Tipo De Movimentação:", null, '14px', null, '100%'),$tipo_movimentacao_id]);
        $row5->layout = ['col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['MovimentacaoHeaderList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Movimentacao(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $produto = Produto::find( $object ->produto_id );
            if($produto)
            {
            if($object -> tipo_movimentacao_id == TipoMovimentacao::ENTRADA)
            {
                   $produto->total_estoque += $object->quantidade;
            }
            elseif ($object->tipo_movimentacao_id == TipoMovimentacao::SAIDA) 
            {
                $produto->total_estoque -= $object->quantidade;
            }

                $produto->store();    
            }

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('MovimentacaoHeaderList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Movimentacao($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

