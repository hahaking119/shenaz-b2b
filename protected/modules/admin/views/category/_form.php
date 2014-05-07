<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'category-form',
        'type' => 'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
            ));
    ?>

    <?php echo $form->errorSummary($model); ?>


    <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Title')); ?>

    <?php
    if (isset($parentCategories)) {
        $Categories = CHtml::listData($parentCategories, 'category_id', 'title');
        if (!empty($Categories))
            $parentCategories = $Categories;
    } else {
        $parentCategories = array();
    }
    if (!$model->isNewRecord) {
        $isParent = Category::model()->findByPk($model->parent_id);
        if ($isParent->parent_id !== 0) {
            $model->subcategory_id = $model->parent_id;
            $model->parent_id = $isParent->parent_id;
            $data = CHtml::listData(Category::model()->findAllByAttributes(array('parent_id' => $isParent->parent_id)), 'category_id', 'title');
            $display = 'block';
        } else {
            $display = 'none';
        }
    } else {
        $data = array();
        $display = 'none';
    }
    echo $form->dropDownListRow($model, 'parent_id', array(0 => 'Parent Category') + $parentCategories, array('prompt' => '--- Select Parent Category ---',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('listSubCategories'),
            'update' => '#Category_subcategory_id',
            'complete' => '$("#subcategory").css("display","block")',
            'data' => array('id' => 'js:this.value'),
        )
    ));
    ?>
    <div id="subcategory" style="display: <?php echo $display;
    s ?>"><?php echo $form->dropDownListRow($model, 'subcategory_id', $data, array('style' => '')); ?></div>

    <div class="control-group">
        <div class="control-label"><?php echo $form->labelEx($model, 'image'); ?></div>
        <div class="controls">
            <?php
            $this->widget('ext.EAjaxUpload.EAjaxUpload', //select file button
                    array(
                'id' => 'image',
                'config' => array(
                    'action' => Yii::app()->createAbsoluteUrl('admin/category/upload/type/image'),
                    'multiple' => false,
                    'debug' => false,
                    'allowedExtensions' => array("jpg", "jpeg", 'gif', 'png'), //array("jpg","jpeg","gif","exe","mov" and etc...
                    'sizeLimit' => 10 * 1024 * 1024, // maximum file size in bytes (10 MB))
                    'hideDropzones' => true,
                    'disableDefaultDropzone' => true,
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
                                                var counter = jQuery($(\"#cat-image li\")).size();
                                                if(counter<=0){
                                                    counter = 0;
                                                    var index = counter;
                                                }else{
                                                    var last = $('#cat-image li[id^=thumbs_]:last').attr('id');
                                                    var index = last.split('_')[1];
                                                    index++;
                                                }
                                                $('.qq-upload-list').remove()+
                                                $('#cat-image').append('<li id=\"thumbs_'+index+'\" class=\"pull-left thumbnail span2\"><div id=\"image_preview\" class=\"preview_'+index+'\"><img src=\"'+responseJSON.imageThumb+'\" alt=\"'+responseJSON.filename+'\">'+
                                                '<a href=\"javascript:(void);\" onClick=\"getRemove('+index+',\''+responseJSON.filename+'\','+'\'image\')\" class=\"btn btn-danger\">Remove</a><input type=\"hidden\" name=\"Category[image]\" value=\"'+responseJSON.filename+'\"></div></li>');
                                            }
                                            else
                                            {
                                                alert('An error has occured!');
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
            <div class="clearfix"></div>
            <ul id="cat-image">
                <?php
                if (!$model->isNewRecord && !empty($model->image)) {
                    static $i = 1;
                    echo '<li style="list-style-type: none;" id="thumbs_' . $i . '" class="preview_' . $i . '">';
                    echo CHtml::hiddenField('CategoryBanner[banner][]', $model->image);
                    echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/category/image/thumbs/' . $model->image), $model->image, array('class' => 'thumbnail span2'));
                    echo '<a href="javascript:void(0);" onClick="getRemove(' . $i . ',\'' . $model->image . '\',\'' . 'image\'' . ',\'' . $model->category_id . '\')" class="btn btn-danger">Remove</a>';
                    echo '</li>';
                    echo '<div class="clearfix"></div>';
                }
                ?>
            </ul>
            <div class="clearfix"></div>
<?php echo $form->error($model, 'image'); ?>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label"><?php echo $form->labelEx($categoryBanner, 'banner'); ?></div>
        <div class="controls">
            <?php
            $this->widget('ext.EAjaxUpload.EAjaxUpload', //select file button
                    array(
                'id' => 'banner',
                'config' => array(
                    'action' => Yii::app()->createAbsoluteUrl('admin/category/upload/type/banner'),
                    'multiple' => true,
                    'debug' => false,
                    'allowedExtensions' => array("jpg", "jpeg", 'gif', 'png'), //array("jpg","jpeg","gif","exe","mov" and etc...
                    'sizeLimit' => 10 * 1024 * 1024, // maximum file size in bytes (10 MB))
                    'hideDropzones' => true,
                    'disableDefaultDropzone' => true,
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
                                                $('#thumbs_list').append('<li id=\"thumbs_'+index+'\" class=\"pull-left thumbnail span2\"><div id=\"image_preview\" class=\"preview_'+index+'\"><img src=\"'+responseJSON.imageThumb+'\" alt=\"'+responseJSON.filename+'\">'+
                                                '<a href=\"javascript:(void);\" onClick=\"getRemove('+index+',\''+responseJSON.filename+'\','+'\'banner\')\" class=\"btn btn-danger\">Remove</a><input type=\"hidden\" name=\"ProductImages[image][]\" value=\"'+responseJSON.filename+'\"></div></li>');
                                            }
                                            else
                                            {
                                                alert('An error has occured!');
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
            <div class="clearfix"></div>
            <ul id="thumbs_list">
                <?php
                if (!$model->isNewRecord && is_array($banners)) {//die();
                    foreach ($banners as $image) {
                        static $i = 1;
                        echo '<li style="list-style-type: none;" id="thumbs_' . $i . '" class="preview_' . $i . '">';
                        echo CHtml::hiddenField('CategoryBanner[banner][]', $image->banner);
                        echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/category/banner/thumbs/' . $image->banner), $image->banner, array('class' => 'thumbnail span2'));
                        echo '<a href="javascript:void(0);" onClick="getRemove(' . $i . ',\'' . $image->banner . '\',\'' . 'banner\'' . ',\'' . $image->id . '\')" class="btn btn-danger">Remove</a>';
                        echo '</li>';
                        echo '<div class="clearfix"></div>';
                        $i++;
                    }
                }
                ?>
            </ul>
            <div class="clearfix"></div>
<?php echo $form->error($categoryBanner, 'banner'); ?>
        </div>
    </div>

<?php echo $form->dropDownListRow($model, 'status', array(0 => 'Draft', 1 => 'Publish'), array('prompt' => '--- Select Status ---')); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-success')); ?>
<?php if ($model->isNewRecord) echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    function getRemove(index, image, type, id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("admin/member/remove_image"); ?>',
            data: {image: image, id: id},
            success: function(data) {
                if (data === 'success') {
                    if(type==='banner'){
                        //alert(type);
                        $('#thumbs_list .preview_' + index).remove();
                        $('#thumbs_list #thumbs_'+index).remove();
                    }
                    else{
                        $('#cat-image .preview_' + index).remove();
                        $('#cat-image #thumbs_'+index).remove();
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
</script>