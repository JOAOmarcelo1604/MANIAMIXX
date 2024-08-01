<?php

class ProdutoBarCode extends TPage
{
    private static $database = 'estoque';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'formBarcode_Produto';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct($param = null)
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Etiqueta de Codigo de Barras");

        $criteria_categoria_produto_id = new TCriteria();

        $id = new TEntry('id');
        $categoria_produto_id = new TDBCombo('categoria_produto_id', 'estoque', 'CategoriaProduto', 'id', '{id}','id asc' , $criteria_categoria_produto_id );
        $nome = new TEntry('nome');
        $total_estoque = new TEntry('total_estoque');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $imagem = new TEntry('imagem');

        $categoria_produto_id->enableSearch();
        $id->setSize(100);
        $nome->setSize('100%');
        $valor->setSize('100%');
        $imagem->setSize('100%');
        $total_estoque->setSize('100%');
        $categoria_produto_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Categoria produto id:", null, '14px', null)],[$categoria_produto_id]);
        $row3 = $this->form->addFields([new TLabel("Nome:", null, '14px', null)],[$nome]);
        $row4 = $this->form->addFields([new TLabel("Total Estoque:", null, '14px', null)],[$total_estoque]);
        $row5 = $this->form->addFields([new TLabel("Valor:", null, '14px', null)],[$valor]);
        $row6 = $this->form->addFields([new TLabel("Imagem:", null, '14px', null)],[$imagem]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongenerate = $this->form->addAction("Gerar", new TAction([$this, 'onGenerate']), 'fas:cog #ffffff');
        $this->btn_ongenerate = $btn_ongenerate;
        $btn_ongenerate->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Estoque","Etiqueta de Codigo de Barras"]));
        $container->add($this->form);

        parent::add($container);

    }

    public function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $data = $this->form->getData();
            $criteria = new TCriteria();

            if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) ) 
            {

                $criteria->add(new TFilter('id', '=', $data->id));
            }
            if (isset($data->categoria_produto_id) AND ( (is_scalar($data->categoria_produto_id) AND $data->categoria_produto_id !== '') OR (is_array($data->categoria_produto_id) AND (!empty($data->categoria_produto_id)) )) ) 
            {

                $criteria->add(new TFilter('categoria_produto_id', '=', $data->categoria_produto_id));
            }
            if (isset($data->nome) AND ( (is_scalar($data->nome) AND $data->nome !== '') OR (is_array($data->nome) AND (!empty($data->nome)) )) ) 
            {

                $criteria->add(new TFilter('nome', 'like', "%{$data->nome}%"));
            }
            if (isset($data->total_estoque) AND ( (is_scalar($data->total_estoque) AND $data->total_estoque !== '') OR (is_array($data->total_estoque) AND (!empty($data->total_estoque)) )) ) 
            {

                $criteria->add(new TFilter('total_estoque', '=', $data->total_estoque));
            }
            if (isset($data->valor) AND ( (is_scalar($data->valor) AND $data->valor !== '') OR (is_array($data->valor) AND (!empty($data->valor)) )) ) 
            {

                $criteria->add(new TFilter('valor', '=', $data->valor));
            }
            if (isset($data->imagem) AND ( (is_scalar($data->imagem) AND $data->imagem !== '') OR (is_array($data->imagem) AND (!empty($data->imagem)) )) ) 
            {

                $criteria->add(new TFilter('imagem', 'like', "%{$data->imagem}%"));
            }

            TSession::setValue(__CLASS__.'_filter_data', $data);

            $properties = [];

            $properties['leftMargin']    = 10; // Left margin
            $properties['topMargin']     = 10; // Top margin
            $properties['labelWidth']    = 64; // Label width in mm
            $properties['labelHeight']   = 28; // Label height in mm
            $properties['spaceBetween']  = 4;  // Space between labels
            $properties['rowsPerPage']   = 10;  // Label rows per page
            $properties['colsPerPage']   = 3;  // Label cols per page
            $properties['fontSize']      = 12; // Text font size
            $properties['barcodeHeight'] = 9; // Barcode Height
            $properties['imageMargin']   = 0;
            $properties['barcodeMethod'] = 'EAN13';

            $label  = "
<u>{nome} </u>
#barcode#  ";

            $bcgen = new AdiantiBarcodeDocumentGenerator('p', 'A4');
            $bcgen->setProperties($properties);
            $bcgen->setLabelTemplate($label);

            $class = self::$activeRecord;

            $objects = $class::getObjects($criteria);

            if ($objects)
            {
                foreach ($objects as $object)
                {

                    $bcgen->addObject($object);
                }

                $filename = 'tmp/barcode_'.uniqid().'.pdf';

                $bcgen->setBarcodeContent('{id}');
                $bcgen->generate();
                $bcgen->save($filename);

                parent::openFile($filename);
                new TMessage('info', _t('Barcodes successfully generated'));
            }
            else
            {
                new TMessage('info', _t('No records found'));   
            }

            TTransaction::close();

            $this->form->setData($data);

        } 
        catch (Exception $e) 
        {
            $this->form->setData($data);

            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {

    }


}

