<?php
/* @var $this NewsletterController */
/* @var $model Newsletter */

$this->breadcrumbs=array(
	'Newsletters'=>array('index'),
	$model->title=>array('view','id'=>$model->newsletter_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Newsletter', 'url'=>array('index')),
	array('label'=>'Create Newsletter', 'url'=>array('create')),
	array('label'=>'View Newsletter', 'url'=>array('view', 'id'=>$model->newsletter_id)),
	array('label'=>'Manage Newsletter', 'url'=>array('admin')),
);
?>

<h1>Update Newsletter <?php echo $model->newsletter_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>