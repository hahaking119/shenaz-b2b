<?php
/* @var $this MemberController */
/* @var $model DirectoryInformation */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" href="<?php echo Yii::app()->createUrl("/scripts/datepicker/datepicker.css"); ?>" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->createUrl("/scripts/datepicker/bootstrap-datepicker.js"); ?>"></script>
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
            
            <div class="control-group">
                <div class="control-label"><?php echo $form->labelEx($companyInformation,'established_at'); ?></div>
                <div class="controls">
                    <?php echo $form->textField($companyInformation,'established_at',array('class'=>'date_picker')); ?>
                </div>
            </div>
            <?php echo $form->error($model,'messageDate'); ?>
            
            
            <?php echo $form->textFieldRow($companyInformation, 'active_business_years'); ?>
            
            <?php echo $form->radioButtonListRow($companyInformation, 'import_export', array('2' => 'Import', '1' => 'Export','0'=>'Both')); ?>
            
            <?php echo $form->textFieldRow($companyInformation, 'no_of_staffs'); ?>
            
            <?php echo $form->textAreaRow($companyInformation, 'description',array('rows' => 6, 'cols' => 50)); ?>
            
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
                                                '<a href=\"javascript:(void);\" onClick=\"getRemove('+index+', \''+responseJSON.filename+'\','+'\'logo\')\" class=\"btn btn-danger\">Remove</a></div>');
                                                $('#company_logo_hidden').val(responseJSON.filename);
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
                    <div class="logo_msg"></div>
                    <?php echo $form->error($companyInformation, 'logo'); ?>
                    <?php echo $form->hiddenField($companyInformation, 'logo',array('id'=>'company_logo_hidden')); ?>
                    <div class="clearfix"></div>
                    <div id="thumbs_list">
                        <?php
                        if (!$companyInformation->isNewRecord && !empty($companyInformation->logo)){
                            static $i = 1;
                            echo '<li style="list-style-type: none;" id="thumbs_' . $i . '" class="preview_' . $i . '">';
                            echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/company/logo/thumbs/' . $companyInformation->logo), $companyInformation->logo, array('class' => 'thumbnail span2'));
                            echo '<a href="javascript:void(0);" onClick="hideImg(' . $i . ')" class="btn btn-danger">Remove</a>';
                            echo '</li>';
                            echo '<div class="clearfix"></div>';
                        }
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
                                                '<a href=\"javascript:(void);\" onClick=\"getRemove('+index+', \''+responseJSON.filename+'\','+'\'banner\')\" class=\"btn btn-danger\">Remove</a><input type=\"hidden\" name=\"CompanyInformation[banner_image]\" value=\"'+responseJSON.filename+'\"></div>');
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
                        if (!$companyInformation->isNewRecord && !empty($companyInformation->banner_image)){
                            static $i = 1;
                            echo '<li style="list-style-type: none;" id="thumbs_' . $i . '" class="preview_' . $i . '">';
                            echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/company/banner/thumbs/' . $companyInformation->banner_image), $companyInformation->banner_image, array('class' => 'thumbnail span2'));
                            echo '<a href="javascript:void(0);" onClick="getRemove(' . $i . ',\'' . $companyInformation->banner_image. '\',\''.'banner\''.',\''.$companyInformation->company_id.'\')" class="btn btn-danger">Remove</a>';
                            echo '</li>';
                            echo '<div class="clearfix"></div>';
                        }
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
                                                '<a href=\"javascript:(void);\" onClick=\"getRemove('+index+', \''+responseJSON.filename+'\','+'\'image\')\" class=\"btn btn-danger\">Remove</a><input type=\"hidden\" name=\"DirectoryInformation[image]\" value=\"'+responseJSON.filename+'\"></div>');
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
                        if (!$model->isNewRecord && !empty($model->image)){
                            static $i = 1;
                            echo '<li style="list-style-type: none;" id="thumbs_' . $i . '" class="preview_' . $i . '">';
                            echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/directory/image/thumbs/' . $model->image), $model->image, array('class' => 'thumbnail span2'));
                            echo '<a href="javascript:void(0);" onClick="getRemove(' . $i . ',\'' . $model->image. '\',\''.'image\''.',\''.$model->directory_id.'\')" class="btn btn-danger">Remove</a>';
                            echo '</li>';
                            echo '<div class="clearfix"></div>';
                        }
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
                <?php if ($model->isNewRecord) echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
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
    function getRemove(index, image, type, id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("seller/directoryInformation/remove_image"); ?>',
            data: {image: image, id: id},
            success: function(data) {
                if (data === 'success') {
                    if(type==='banner'){
                        //alert(type);
                        $('#banner_list .preview_' + index).remove();
                        $('#banner_list #thumbs_'+index).remove();
                    }
                    else if(type==='logo'){
                        $('#thumbs_list .preview_' + index).remove();
                        $('#thumbs_list #thumbs_'+index).remove();
                        $('#company_logo_hidden').val('');
                    }
                    else{
                        $('#image_list .preview_' + index).remove();
                        $('#image_list #thumbs_'+index).remove();
                    }
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
    
    $('.date_picker').datepicker({
        format:'yyyy-mm-dd'
    });
    function hideImg(index){
        $('#thumbs_list .preview_' + index).remove();
        $('#thumbs_list #thumbs_'+index).remove();
        $('#company_logo_hidden').val('');
        var logo_message = '<div class="alert alert-danger"><span class="close" data-dismiss="alert">×</span>Please upload a new Company Logo</div>';
        $(".logo_msg").html(logo_message).fadeIn().animate({opacity: 1.0}, 4000).fadeOut("slow");
    }
</script>