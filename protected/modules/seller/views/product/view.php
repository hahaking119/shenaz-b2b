<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Update Product', 'url'=>array('update', 'id'=>$model->product_id)),
	array('label'=>'Delete Product', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->product_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>View Product #<?php echo $model->product_id; ?></h1>
 
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'product_id',
        'name',
        'sku',
        array(
            'name' => 'Company',
            'type' => 'raw',
            'value' => $model->company->company_name
        ),
//        'category_id',
//        'custom_category_id',
        'description',
        array(
            'name' => 'Price',
            'type' => 'raw',
            'value' => CommonClass::getPriceFormat($model->company->member_id) . ' ' . $model->price
        ),
        'minimum_quantitiy',
        'stock',
        'status',
    ),
));
?>