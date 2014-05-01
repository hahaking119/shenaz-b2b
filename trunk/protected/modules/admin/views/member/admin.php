<?php
/* @var $this MemberController */
/* @var $model Member */

$this->menu=array(
	array('label'=>'List Member', 'url'=>array('index')),
	array('label'=>'Create Member', 'url'=>array('create')),
);

?>

<h1>Manage Members</h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'template' => "{items}",
    'columns' => array(
        'member_id',
        'email',
        'first_name',
        'middle_name',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 60px'),
            'template' => '{view}{update}{add}{delete}',
            'buttons' => array(
                'add' => array(
                    'label' => 'Add Company/Directory Information',
                    'icon' => 'icon-plus',
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/member/add_directory_company_info", array("id"=>$data->member_id))',
                    'visible'=>'$data->member_id',
                ),
//                'trash' => array(
//                    'label' => 'Trash',
//                    'icon' => 'icon-trash',
//                    'url' => 'Yii::app()->createAbsoluteUrl("admin/registrant/trash", array("id"=>$data->id))',
//                    'click' => 'js:function(){return confirm("Are you sure you want to trash the retailer information?")}'
//                ),
            ),
        ),
    ),
));
?>
