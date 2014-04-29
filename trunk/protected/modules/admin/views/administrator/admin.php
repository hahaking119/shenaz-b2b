<?php
/* @var $this AdministratorController */
/* @var $model Administrator */

$this->breadcrumbs = array(
    'Administrators' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Administrators', 'url' => array('index')),
    array('label' => 'Add Administrator', 'url' => array('create')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#administrator-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Manage Administrators</h1>

<!--<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

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
    'id' => 'administrator-grid',
    'dataProvider' => $model->search(array('condition' => 'trash = 0')),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'administrator_id',
            'header' => '#',
            'value' => '$data->administrator_id'
        ),
        'email',
        'first_name',
        'middle_name',
        'last_name',
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => 'CHtml::dropDownList("Administrator[status]", $data->status, array(0 => "Inactive", 1 => "Active"), array("prompt" => "--- Select Status ---", "onchange" => "updateStatus($data->administrator_id, $(this).val())"))',
            'filter' => array('' => 'All', 0 => 'Inactive', 1 => 'Active')
        ),
        /*
          'last_name',
          'role_id',
          'activation_key',
          'activation_status',
          'status',
          'trash',
          'created_at',
          'modified_at',
          'trashed_at',
         */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
            'template' => '{update}{trash}',
            'buttons' => array(
                'trash' => array(
                    'label' => 'Trash',
                    'icon' => 'icon-trash',
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/administrator/trash", array("id" => $data->administrator_id))',
                    'click' => 'js:function(){return confirm("Are you sure you want to trash the administrator?")}',
                    'options' => array('style' => 'margin-left: 10px')
                ),
            ),
        ),
    ),
));
?>
<script type="text/javascript">
    function updateStatus(id, val) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("admin/administrator/updateStatus/id"); ?>' + '/' + id,
            data: {status: val},
            success: function(data) {
                if (data == 'success') {
                    var message = '<div class="alert alert-success"><span class="close" data-dismiss="alert">×</span><strong>Updated!</strong> Status has been updated.</div>';
                    $("#msg").html(message);
                } else {
                    var message = '<div class="alert alert-error"><span class="close" data-dismiss="alert">×</span><strong>Error!</strong> An error has occured.</div>';
                    $("#msg").html(message);
                }
            }
        });
    }
</script>
