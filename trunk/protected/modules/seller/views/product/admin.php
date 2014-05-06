<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
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
        array(
            'header' => '#',
            'value' => '$data->product_id'
        ),
        array(
            'name' => 'company_id',
            'type' => 'raw',
            'value' => 'CompanyInformation::model()->getName($data->company_id)',
            'filter' => '',
        ),
        'name',
//        'slug',
        'price',
        'sku',
        array(
            'name' => 'status',
//            'header' => 'Status',
            'type' => 'raw',
            'value' => 'CHtml::dropDownList("CustomCategory[status]", $data->status, array(0 => "Draft", 1=> "Publish"), array("class"=>"span2", "onchange"=>"updateStatus($data->product_id, $(this))", "prompt"=>"--- Select Status ---"))',
            'filter' => array('' => 'All', 0 => 'Draft', 1 => 'Publish')
        ),
//        'category_id',
        /*
          'custom_category_id',
          'description',
          'price_type',
          'minimum_quantitiy',
          'stock',
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
                    'url' => 'Yii::app()->createAbsoluteUrl("seller/product/trash", array("id"=>$data->product_id))',
                    'click' => 'js:function(){return confirm("Are you sure you want to trash the product?")}'
                ),
            ),
        ),
    ),
));
?>
<script type="text/javascript">
    function updateStatus(id, input) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("seller/product/updateStatus/id"); ?>'+'/'+id,
            data: {status: input.val()},
            success: function(data) {
                if (data == 'success') {
                    var message = '<div class="alert alert-success"><span class="close" data-dismiss="alert">×</span><strong>Updated!</strong> Status has been updated.</div>';
                    $("#msg").html(message).fadeIn().animate({opacity: 1.0}, 4000).fadeOut("slow");
                }
            }
        });
    }
</script>