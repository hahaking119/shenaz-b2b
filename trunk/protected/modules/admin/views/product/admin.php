<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs = array(
    'Products' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Product', 'url' => array('index')),
    array('label' => 'Create Product', 'url' => array('create')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#product-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Manage Products</h1>

<?php // echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'product-grid',
    'dataProvider' => $model->search(array('condition' => 'trash = 0')),
    'filter' => $model,
    'columns' => array(
        'product_id',
        'company_id',
        'name',
        'slug',
        'sku',
        'category_id',
        /*
          'custom_category_id',
          'description',
          'price',
          'price_type',
          'minimum_quantitiy',
          'stock',
          'status',
          'trash',
          'created_at',
          'modified_at',
          'trashed_at',
         */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 60px'),
            'template' => '{view}{update}{trash}',
            'buttons' => array(
                'trash' => array(
                    'label' => 'Trash',
                    'icon' => 'icon-trash',
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/product/trash", array("id"=>$data->product_id))',
                    'click' => 'js:function(){return confirm("Are you sure you want to trash the product?")}'
                ),
            ),
        ),
    ),
));
?>
