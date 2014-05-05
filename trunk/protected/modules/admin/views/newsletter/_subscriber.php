<?php
/* @var $this NewsletterController */
/* @var $model Newsletter */

//$this->breadcrumbs = array(
//    'Newsletters' => array('index'),
//    'Manage',
//);
//
//$this->menu = array(
//    array('label' => 'List Newsletter', 'url' => array('index')),
//    array('label' => 'Create Newsletter', 'url' => array('create')),
//);
//
//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#newsletter-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1> Newsletter Subscribers</h1>



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
    'id' => 'newslettersubscriber-grid',
    'dataProvider'=>$model->search(),
//    'filter' => $model,
    'columns' => array(
//        array(
//            'name' => 'id',
//            'header' => '#',
//            'value' => '$data->id'
//        ),
        array(
            'name' => 'member_id',
            'header' => 'Name',
            'value' => 'Member::model()->getName($data->member_id)', 
        ),
        array(
            'name' => 'email',
            'header' => 'Email',
            'value' => '$data->email'
        )
    ),
));
?>
