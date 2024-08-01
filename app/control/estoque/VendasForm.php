<?php

class VendasForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'estoque';
    private static $activeRecord = 'Vendas';
    private static $primaryKey = 'id';
    private static $formName = 'form_VendasForm';

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
        $this->form->setFormTitle("Cadastro de Vendas");

        $criteria_produto_id = new TCriteria();
        $criteria_clientes_id = new TCriteria();

        $produto_id = new TDBCombo('produto_id', 'estoque', 'Produto', 'id', '{nome}','id asc' , $criteria_produto_id );
        $data_venda = new TDateTime('data_venda');
        $total_venda = new TEntry('total_venda');
        $forma_pagamento = new TEntry('forma_pagamento');
        $vendedor = new TEntry('vendedor');
        $quantidade = new TEntry('quantidade');
        $clientes_id = new TDBCombo('clientes_id', 'estoque', 'Clientes', 'id', '{nome}','id asc' , $criteria_clientes_id );
        $valor = new TEntry('valor');

        $data_venda->addValidation("Data da Venda", new TRequiredValidator()); 

        $data_venda->setMask('dd/mm/yyyy hh:ii');
        $data_venda->setDatabaseMask('yyyy-mm-dd hh:ii');
        $produto_id->enableSearch();
        $clientes_id->enableSearch();

        $valor->setSize('100%');
        $data_venda->setSize(150);
        $vendedor->setSize('100%');
        $produto_id->setSize('100%');
        $quantidade->setSize('100%');
        $total_venda->setSize('100%');
        $clientes_id->setSize('100%');
        $forma_pagamento->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Produto:", null, '14px', null)],[$produto_id],[new TLabel("Data da Venda:", null, '14px', null)],[$data_venda]);
        $row2 = $this->form->addFields([new TLabel("Total da Venda:", null, '14px', null)],[$total_venda],[new TLabel("Forma de Pagamento:", null, '14px', null)],[$forma_pagamento]);
        $row3 = $this->form->addFields([new TLabel("Nome Do Vendedor:", null, '14px', null)],[$vendedor],[new TLabel("Quantidade:", null, '14px', null)],[$quantidade]);
        $row4 = $this->form->addFields([new TLabel("Cliente", null, '14px', null)],[$clientes_id],[new TLabel("Preço Varejo:", null, '14px', null)],[$valor]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['VendasHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new Vendas(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

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
            TApplication::loadPage('VendasHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Vendas($key); // instantiates the Active Record 

                                $object->produto_id = $object->produto->id;

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

