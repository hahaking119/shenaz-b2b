<?php
/* @var $this CustomCategoryController */
/* @var $model CustomCategory */

$this->breadcrumbs=array(
	'Custom Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CustomCategory', 'url'=>array('index')),
	array('label'=>'Create CustomCategory', 'url'=>array('create')),
);

?>

<h1>Manage Custom Categories</h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(array('condition' => 'trash = 0')),
//    'filter' => $model,
//    'template' => "{items}",
    'columns' => array(
        array(
            'header' => '#',
            'value' => '$data->id'
        ),
//        array(
//            'name' => 'company_id',
//            'type' => 'raw',
//            'value'=> 'CompanyInformation::model()->getName($data->company_id)',
//        ),
        'title',
        array(
            'name' => 'parent_id',
            'type' => 'raw',
            'value' => 'Category::model()->getName($data->parent_id)',
        ),
        array(
            'name' => 'status',
            'header' => 'Status',
            'type' => 'raw',
            'value' => 'CHtml::dropDownList("CustomCategory[status]", $data->status, array(0 => "Draft", 1=> "Publish"), array("class"=>"span2", "onchange"=>"updateStatus($data->id, $(this))", "prompt"=>"--- Select Status ---"))',
            'filter' => array('' => 'All', 0 => 'Draft', 1 => 'Publish')
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 60px'),
            'template' => '{view}{update}{trash}',
            'buttons' => array(
                'trash' => array(
                    'label' => 'Trash',
                    'icon' => 'icon-trash',
                    'url' => 'Yii::app()->createAbsoluteUrl("seller/customCategory/trash", array("id"=>$data->id))',
                    'click' => 'js:function(){return confirm("Are you sure you want to trash the custom category?")}'
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
            url: '<?php echo Yii::app()->createAbsoluteUrl("seller/customCategory/updateStatus/id"); ?>'+'/'+id,
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