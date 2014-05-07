<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs = array(
    'Memberships' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Membership Options', 'url' => array('index')),
    array('label' => 'Create Membership Option', 'url' => array('create')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#membership-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Manage Membership Options</h1>

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
    'id' => 'membership-grid',
    'dataProvider' => $model->search(array('condition' => 'trash = 0')),
    'filter' => $model,
    'columns' => array(
        'membership_id',
        'title',
        array(
            'name' => 'description',
            'type' => 'raw',
            'value' => 'CommonClass::getShortDescription($data->description)',
            'filter' => ''
        ),
        'shopfront_limit',
        'product_limit',
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => 'CHtml::dropDownList("Membership[status]", $data->status, array("Draft", "Publish"), array("onchange" => "updateStatus($data->membership_id, $(this).val())"))',
            'filter' => array('' => 'All', 0 => 'Draft', 1 => 'Publish'),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 60px'),
            'template' => '{view}{update}{trash}',
            'buttons' => array(
                'trash' => array(
                    'label' => 'Trash',
                    'icon' => 'icon-trash',
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/membership/trash", array("id"=>$data->membership_id))',
                    'click' => 'js:function(){return confirm("Are you sure you want to trash the membership option?")}'
                ),
            ),
        ),
    ),
));
?>
<script type="text/javascript">
    function updateStatus(id, value){
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("admin/membership/updateStatus/id"); ?>'+'/'+id,
            data: {status: value},
            success: function(data) {
                if (data == 'success') {
                    var message = '<div class="alert alert-success"><span class="close" data-dismiss="alert">×</span><strong>Updated!</strong> Status has been updated.</div>';
                    $("#msg").html(message).fadeIn().animate({opacity: 1.0}, 4000).fadeOut("slow");
                }
            }
        });
    }
</script>