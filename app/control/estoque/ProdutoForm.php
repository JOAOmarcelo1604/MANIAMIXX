<?php

class ProdutoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'estoque';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'form_ProdutoForm';

    use Adianti\Base\AdiantiFileSaveTrait;

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
        $this->form->setFormTitle("Cadastro De Produto");

        $criteria_categoria_produto_id = new TCriteria();

        $id = new TEntry('id');
        $categoria_produto_id = new TDBCombo('categoria_produto_id', 'estoque', 'CategoriaProduto', 'id', '{nome}','id asc' , $criteria_categoria_produto_id );
        $nome = new TEntry('nome');
        $total_estoque = new TEntry('total_estoque');
        $valor = new TEntry('valor');
        $valor_atacado = new TEntry('valor_atacado');
        $imagem = new TImageCropper('imagem');

        $categoria_produto_id->addValidation("Categoria produto id", new TRequiredValidator()); 

        $id->setEditable(false);
        $categoria_produto_id->enableSearch();
        $imagem->enableFileHandling();
        $imagem->setAllowedExtensions(["jpg","jpeg","png","gif"]);
        $imagem->setImagePlaceholder(new TImage("fas:file-upload #dde5ec"));
        $id->setSize(100);
        $nome->setSize('100%');
        $valor->setSize('100%');
        $imagem->setSize('100%', 80);
        $total_estoque->setSize('100%');
        $valor_atacado->setSize('100%');
        $categoria_produto_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id]);
        $row1->layout = ['col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Categoria Do Produto :", null, '14px', null, '100%'),$categoria_produto_id]);
        $row2->layout = ['col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Nome:", null, '14px', null, '100%'),$nome]);
        $row3->layout = ['col-sm-12'];

        $row4 = $this->form->addFields([new TLabel("Total Estoque:", null, '14px', null, '100%'),$total_estoque]);
        $row4->layout = ['col-sm-12'];

        $row5 = $this->form->addFields([new TLabel("Valor Varejo:", null, '14px', null, '100%'),$valor]);
        $row5->layout = ['col-sm-12'];

        $row6 = $this->form->addFields([new TLabel("Valor Atacado:", null, '14px', null)],[$valor_atacado]);
        $row7 = $this->form->addFields([new TLabel("Imagem:", null, '14px', null, '100%'),$imagem]);
        $row7->layout = ['col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ProdutoHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new Produto(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $imagem_dir = 'app/imagens'; 

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'imagem', $imagem_dir);
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
            TApplication::loadPage('ProdutoHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Produto($key); // instantiates the Active Record 

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

