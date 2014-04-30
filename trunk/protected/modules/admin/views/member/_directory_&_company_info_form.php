<?php
/* @var $this MemberController */
/* @var $model DirectoryInformation */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'directory-information-form',
        'type' => 'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'clientOptions' => array('validateOnSubmit' => true),
            ));
    ?>

    <?php echo $form->errorSummary(array($model, $companyInformation)); ?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="active com"><a href="#company-information">Company Information</a></li>
        <li class="dir"><a href="#directory-information">Directory Information</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="company-information">

            <?php echo $form->hiddenField($companyInformation, 'member_id'); ?>
            
            <?php echo $form->textFieldRow($companyInformation, 'company_name'); ?>

            <?php echo $form->textFieldRow($companyInformation, 'company_location'); ?>

            <?php echo $form->textFieldRow($companyInformation, 'country_of_origin'); ?>

            <?php echo $form->textFieldRow($companyInformation, 'website'); ?>
            
            
            <?php echo $form->labelEx($model,'established_at'); ?>
            <?php 
//                $this->widget('ext.rezvan.RDatePicker',array(
//                    'name'=>'CompanyInformation[established_at]',
//                    'value'=>$companyInformation->established_at,
//                    'options' => array(
//                        'format' => 'yyyy/mm/dd',
//                        'viewformat' => 'yyyy/mm/dd',
//                        'placement' => 'right',
//                        'todayBtn'=>true,
//                        'language'=>'en',
//                    )
//                ));  
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'name'=>'CompanyInformation[established_at]',
                    'value'=>$companyInformation->established_at,
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'fold',
                    ),
                    'htmlOptions'=>array(
                        'style'=>'height:20px;'
                    ),
                ));
            ?>
            <?php echo $form->error($model,'messageDate'); ?>
            
            
            <?php echo $form->textFieldRow($companyInformation, 'active_business_years'); ?>
            
            <?php echo $form->radioButtonListRow($companyInformation, 'import_export', array('2' => 'Import', '1' => 'Export','0'=>'Both')); ?>
            
            <?php echo $form->textFieldRow($companyInformation, 'no_of_staffs'); ?>
            
            <?php echo $form->textAreaRow($companyInformation, 'description'); ?>
            
            <?php echo $form->dropDownListRow($companyInformation, 'status', array(''=>'--Select Status--','1'=>'Active', '0'=>'Inactive')); ?>
            
            <div class="control-group">
                <div class="control-label"><?php echo $form->labelEx($companyInformation, 'logo'); ?></div>
                <div class="controls">
                    <?php
                    $this->widget('ext.EAjaxUpload.EAjaxUpload', //select file button
                            array(
                        'id' => 'uploadFile',
                        'config' => array(
                            'action' => Yii::app()->createAbsoluteUrl('admin/member/upload/type/logo'),
                            'multiple' => false,
                            'debug' => false,
                            'allowedExtensions' => array("jpg", "jpeg", 'gif', 'png'), //array("jpg","jpeg","gif","exe","mov" and etc...
                            'sizeLimit' => 2 * 1024 * 1024, // maximum file size in bytes (10 MB))
                            'hideDropzones' => true,
                            'disableDefaultDropzone' => TRUE,
                            'uploadButtonText' => 'Upload Logo ',
                            'dragText' => 'Drop image here to upload',
                            'listElement' => '',
                            //'minSizeLimit'=>1024,// minimum file size in bytes
                            'onProgress' => "js:function(id, fileName, loaded, total){
                                        $('.qq-upload-button').val('Uploading...').attr('disabled', true);
                                    }",
                            'onComplete' => "js:function(id, fileName, responseJSON){
                                            $('.qq-upload-button').val('Upload Image').attr('disabled', false);
                                            if(responseJSON.success)
                                            {
                                                var counter = jQuery($(\"#thumbs_list li\")).size();
                                                if(counter<=0){
                                                    counter = 0;
                                                    var index = counter;
                                                }else{
                                                    var last = $('#thumbs_list li[id^=thumbs_]:last').attr('id');
                                                    var index = last.split('_')[1];
                                                    index++;
                                                }
                                                $('.qq-upload-list').remove()+
                                                $('#thumbs_list').html('<div id=\"image_preview\" class=\"preview_'+index+'\"><div id=\"thumbs_'+index+'\" class=\"pull-left thumbnail\"><img src=\"'+responseJSON.imageThumb+'\" alt=\"'+responseJSON.filename+'\" class=\"span2\"></div>'+
                                                '<a href=\"javascript:(void);\" onClick=\"getRemove('+index+', \''+responseJSON.filename+'\')\" class=\"btn btn-danger\">Remove</a><input type=\"hidden\" name=\"CompanyInformation[logo]\" value=\"'+responseJSON.filename+'\"></div>');
                                            }
                                            else
                                            {
                                                alert('something went wrong!');
                                            }  
                                   }",
                            'messages' => array(
                                'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
                                'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
                                'minSizeError' => "{file} is too small, minimum file size is {minSizeLimit}.",
                                'emptyError' => "{file} is empty, please select files again without it.",
                                'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
                            ),
                            'showMessage' => "js:function(message){ alert(message); }"
                        )
                    ));
                    ?>
                    <?php echo $form->error($companyInformation, 'company_logo'); ?>
                    <div class="clearfix"></div>
                    <div id="thumbs_list">
                        <?php
                        if (!$companyInformation->isNewRecord && !empty($companyInformation->logo))
                            echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/company/logo/thumbs/' . $companyInformation->logo), $companyInformation->logo, array('class' => 'thumbnail span2'));
                        ?>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <div class="control-label"><?php echo $form->labelEx($companyInformation, 'banner_image'); ?></div>
                <div class="controls">
                    <?php
                    $this->widget('ext.EAjaxUpload.EAjaxUpload', //select file button
                            array(
                        'id' => 'bannerImage',
                        'config' => array(
                            'action' => Yii::app()->createAbsoluteUrl('admin/member/upload/type/banner'),
                            'multiple' => false,
                            'debug' => false,
                            'allowedExtensions' => array("jpg", "jpeg", 'gif', 'png'), //array("jpg","jpeg","gif","exe","mov" and etc...
                            'sizeLimit' => 10 * 1024 * 1024, // maximum file size in bytes (10 MB))
                            'hideDropzones' => true,
                            'disableDefaultDropzone' => TRUE,
                            'uploadButtonText' => 'Upload Banner',
                            'dragText' => 'Drop image here to upload',
                            'listElement' => '',
                            //'minSizeLimit'=>1024,// minimum file size in bytes
                            'onProgress' => "js:function(id, fileName, loaded, total){
                                        $('.qq-upload-button').val('Uploading...').attr('disabled', true);
                                    }",
                            'onComplete' => "js:function(id, fileName, responseJSON){
                                            $('.qq-upload-button').val('Upload Image').attr('disabled', false);
                                            if(responseJSON.success)
                                            {
                                                var counter = jQuery($(\"#thumbs_list li\")).size();
                                                if(counter<=0){
                                                    counter = 0;
                                                    var index = counter;
                                                }else{
                                                    var last = $('#thumbs_list li[id^=thumbs_]:last').attr('id');
                                                    var index = last.split('_')[1];
                                                    index++;
                                                }
                                                $('.qq-upload-list').remove()+
                                                $('#banner_list').html('<div id=\"image_preview\" class=\"preview_'+index+'\"><div id=\"thumbs_'+index+'\" class=\"pull-left thumbnail\"><img src=\"'+responseJSON.imageThumb+'\" alt=\"'+responseJSON.filename+'\" class=\"span2\"></div>'+
                                                '<a href=\"javascript:(void);\" onClick=\"getRemove('+index+', \''+responseJSON.filename+'\')\" class=\"btn btn-danger\">Remove</a><input type=\"hidden\" name=\"CompanyInformation[banner_image]\" value=\"'+responseJSON.filename+'\"></div>');
                                            }
                                            else
                                            {
                                                alert('something went wrong!');
                                            }  
                                   }",
                            'messages' => array(
                                'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
                                'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
                                'minSizeError' => "{file} is too small, minimum file size is {minSizeLimit}.",
                                'emptyError' => "{file} is empty, please select files again without it.",
                                'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
                            ),
                            'showMessage' => "js:function(message){ alert(message); }"
                        )
                    ));
                    ?>
                    <?php echo $form->error($companyInformation, 'banner_image'); ?>
                    <div class="clearfix"></div>
                    <div id="banner_list">
                        <?php
                        if (!$companyInformation->isNewRecord && !empty($companyInformation->banner_image))
                            echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/company/banner/thumbs/' . $companyInformation->banner_image), $companyInformation->banner_image, array('class' => 'thumbnail span2'));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-actions">
            <a href="#directory-information" onClick="show()" class="btn btn-info">Next</a>
            </div>
        </div>
        <div class="tab-pane" id="directory-information">

            <?php echo $form->textFieldRow($model, 'first_name', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'middle_name', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'last_name', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'job_title', array('size' => 20, 'maxlength' => 20)); ?>
<!-- Image -->
            <div class="control-group">
                <div class="control-label"><?php echo $form->labelEx($model, 'image'); ?></div>
                <div class="controls">
                    <?php
                    $this->widget('ext.EAjaxUpload.EAjaxUpload', //select file button
                            array(
                        'id' => 'directoryImage',
                        'config' => array(
                            'action' => Yii::app()->createAbsoluteUrl('admin/member/upload/type/profile'),
                            'multiple' => false,
                            'debug' => false,
                            'allowedExtensions' => array("jpg", "jpeg", 'gif', 'png'), //array("jpg","jpeg","gif","exe","mov" and etc...
                            'sizeLimit' => 10 * 1024 * 1024, // maximum file size in bytes (10 MB))
                            'hideDropzones' => true,
                            'disableDefaultDropzone' => TRUE,
                            'uploadButtonText' => 'Upload Image',
                            'dragText' => 'Drop image here to upload',
                            'listElement' => '',
                            //'minSizeLimit'=>1024,// minimum file size in bytes
                            'onProgress' => "js:function(id, fileName, loaded, total){
                                        $('.qq-upload-button').val('Uploading...').attr('disabled', true);
                                    }",
                            'onComplete' => "js:function(id, fileName, responseJSON){
                                            $('.qq-upload-button').val('Upload Image').attr('disabled', false);
                                            if(responseJSON.success)
                                            {
                                                var counter = jQuery($(\"#thumbs_list li\")).size();
                                                if(counter<=0){
                                                    counter = 0;
                                                    var index = counter;
                                                }else{
                                                    var last = $('#thumbs_list li[id^=thumbs_]:last').attr('id');
                                                    var index = last.split('_')[1];
                                                    index++;
                                                }
                                                $('.qq-upload-list').remove()+
                                                $('#image_list').html('<div id=\"image_preview\" class=\"preview_'+index+'\"><div id=\"thumbs_'+index+'\" class=\"pull-left thumbnail\"><img src=\"'+responseJSON.imageThumb+'\" alt=\"'+responseJSON.filename+'\" class=\"span2\"></div>'+
                                                '<a href=\"javascript:(void);\" onClick=\"getRemove('+index+', \''+responseJSON.filename+'\')\" class=\"btn btn-danger\">Remove</a><input type=\"hidden\" name=\"DirectoryInformation[image]\" value=\"'+responseJSON.filename+'\"></div>');
                                            }
                                            else
                                            {
                                                alert('something went wrong!');
                                            }  
                                   }",
                            'messages' => array(
                                'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
                                'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
                                'minSizeError' => "{file} is too small, minimum file size is {minSizeLimit}.",
                                'emptyError' => "{file} is empty, please select files again without it.",
                                'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
                            ),
                            'showMessage' => "js:function(message){ alert(message); }"
                        )
                    ));
                    ?>
                    <?php echo $form->error($model, 'image'); ?>
                    <div class="clearfix"></div>
                    <div id="image_list">
                        <?php
                        if (!$model->isNewRecord && !empty($model->image))
                            echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/directory/image/thumbs/' . $model->image), $model->image, array('class' => 'thumbnail span2'));
                        ?>
                    </div>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'phone', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'fax', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'zip_code', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'address', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'area', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'province', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->textFieldRow($model, 'country', array('size' => 60, 'maxlength' => 255)); ?>

            <?php echo $form->dropDownListRow($model, 'status', array(''=>'--Select Status--','1'=>'Active', '0'=>'Inactive')); ?>

            <div class="form-actions">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-info')); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
</script>
<script>
    function getRemove(index, image) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("admin/member/remove_image"); ?>',
            data: {image: image},
            success: function(data) {
                if (data == 'success') {
                    $('.preview_' + index).remove();
                    var message = '<div class="alert alert-success"><span class="close" data-dismiss="alert">×</span>Image removed.</div>';
                    $("#msg").html(message).fadeIn().animate({opacity: 1.0}, 4000).fadeOut("slow");
                }
            }
        });
    }
    $(function() {
        $('.qq-upload-list').remove();
    });
    function show(){
        $('.com').removeClass('active');
        $('.dir').addClass('active');
        $('#company-information').removeClass('active');
        $('#directory-information').addClass('active');
    }
    
</script>