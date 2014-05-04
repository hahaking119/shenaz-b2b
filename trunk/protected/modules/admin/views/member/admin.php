<?php
/* @var $this MemberController */
/* @var $model Member */

$this->menu = array(
    array('label' => 'List Member', 'url' => array('index')),
    array('label' => 'Create Member', 'url' => array('create')),
);
?>

<h1>Manage Members</h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(array('condition' => 'trash = 0')),
    'template' => "{items}",
    'columns' => array(
        array(
            'header' => '#',
            'value' => '$data->member_id'
        ),
        array(
            'header' => 'Name',
            'value' => 'Member::model()->getName($data->member_id)',
        ),
        'email',
        'phone',
        array(
            'name' => 'business_type',
            'type' => 'raw',
            'header' => 'Business',
            'value' => 'Member::model()->getBusinessType($data->business_type)'
        ),
        array(
            'name' => 'membership_id',
            'header' => 'Membership',
            'value' => 'Membership::model()->findByPk($data->membership_id)->title'
        ),
        array(
            'name' => 'status',
            'header' => 'Status',
            'type' => 'raw',
            'value' => 'CHtml::dropDownList("Registrants[status]", $data->status, array(0 => "Inactive", 1=> "Active"), array("class"=>"span2", "onchange"=>"updateStatus($data->member_id, $(this))", "prompt"=>"--- Select Status ---"))',
            'filter' => array('' => 'All', 0 => 'Inactive', 1 => 'Active')
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 60px'),
            'template' => '{view}{update}{add}{edit}{trash}',
            'buttons' => array(
                'add' => array(
                    'label' => 'Add Company/Directory Information',
                    'icon' => 'icon-plus',
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/member/add_directory_company_info", array("id"=>$data->member_id))',
                    'visible' => '($data->companyInformations =="")? 1:0'
                ),
                'edit' => array(
                    'label' => 'Update Company/Directory Information',
                    'icon' => 'icon-edit',
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/member/add_directory_company_info", array("id"=>$data->member_id))',
                    'visible' => '($data->companyInformations !="")? 1:0'
                ),
                'trash' => array(
                    'label' => 'Trash',
                    'icon' => 'icon-trash',
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/member/trash", array("id"=>$data->member_id))',
                    'click' => 'js:function(){return confirm("Are you sure you want to trash the member information?")}'
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
            url: '<?php echo Yii::app()->createAbsoluteUrl("admin/member/updateStatus/id"); ?>'+'/'+id,
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
