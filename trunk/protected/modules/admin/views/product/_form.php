<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'product-form',
        'type' => 'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
            ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <?php
    if (!$model->isNewRecord) {
        $disabled = 'disabled';
    } else {
        $disabled = '';
    }
    echo $form->dropDownListRow($model, 'company_id', CHtml::listData($companies, 'company_id', 'company_name'), array('prompt' => '--- Select Company ---',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('customCategory'),
            'update' => '#ProductCustomCategory_custom_category_id',
            'data' => array('company_id' => 'js:this.value'),
        ),
        'disabled' => $disabled
    ));
    ?>

    <?php echo $form->textFieldRow($model, 'name', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Product Name')); ?>

    <?php echo $form->textFieldRow($model, 'sku', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'SKU')); ?>

    <?php echo $form->radioButtonListRow($model, 'category_type', array('Main Category', 'Self Defined Category', 'Both'), array('separator' => '', 'onclick' => 'showCategoryList($(this).val())', 'id' => 'categoryList')); ?>
    <span class="hint">The main category is the category defined by the system admin. The self defined category is the category defined by members to meet their product category.</span>
    <div class="category">
        <?php
//        if (isset($_POST['ProductCategory']['category_id'])) {
//            $productCategory->category_id = implode(', ', $_POST['ProductCategory']['category_id']);
//        }
//        if (isset($productCategoryList)) {
//            foreach ($productCategoryList as $list) {
//                $categoryListArray[] = $list->category_id;
//            }
//            $productCategory->category_id = $categoryListArray;
//        }
        if (!$model->isNewRecord) {
            $isParent = Category::model()->findByPk($productCategoryList->category_id);
            if ($isParent->parent_id != 0) {
                $productCategory->subcategory_id = $isParent->category_id;
                $productCategory->category_id = $isParent->parent_id;
                $data = CHtml::listData(Category::model()->findAllByAttributes(array('parent_id' => $isParent->parent_id)), 'category_id', 'title');
                $display = 'block';
            } else {
                $productCategory->category_id = $isParent->category_id;
                $display = 'none';
            }
        } else {
            $data = array();
            $display = 'none';
        }
        ?>
        <?php
        echo $form->dropDownListRow($productCategory, 'category_id', CHtml::listData($categories, 'category_id', 'title'), array('prompt' => '--- Select Category ---',
            'ajax' => array(
                'type' => 'POST',
                'url' => CController::createUrl('subCategoryList'),
                'update' => '#ProductCategory_subcategory_id',
                'complete' => '$("#subcategory").css("display","block")',
                'data' => array('parent_id' => 'js:this.value'),
            )
        ));
        ?>
        <div id="subcategory" style="display: <?php echo $disaplay; ?>"><?php echo $form->dropDownListRow($productCategory, 'subcategory_id', $data, array('prompt' => '--- Select Subcategory ---')); ?></div>
    </div>
    <div class="custom-category">
        <?php
        if (isset($_POST['ProductCustomCategory']['custom_category_id'])) {
            $productCustomCategory->custom_category_id = implode(', ', $_POST['ProductCustomCategory']['custom_category_id']);
        }
        if (isset($_POST['Product']['company_id'])) {
            $parents = CustomCategory::model()->findAll('company_id = ' . $_POST['Product']['company_id'] . ' and parent_id = 0 and status = 1');
            foreach ($parents as $parent) {
                $children = CustomCategory::model()->findAll('company_id =' . $_POST['Product']['company_id'] . ' and parent_id = ' . $parent->id . ' and status = 1');
                $data[$parent->id] = $parent->title;
                foreach ($children as $child) {
                    $data[$child->id] = $child->title;
                }
            }
        } else {
            $data = array();
        }
        if (isset($productCustomCategoryList)) {
            foreach ($productCustomCategoryList as $customCategoryList) {
                $customCategoryListArray[] = $customCategoryList->custom_category_id;
            }
            $productCustomCategory->custom_category_id = $customCategoryListArray;
        }
        if (!$model->isNewRecord) {
            $data = CHtml::listData(CustomCategory::model()->findAllByAttributes(array('company_id' => $model->company_id)), 'id', 'title');
        }
        ?>
        <?php
        echo $form->dropDownListRow($productCustomCategory, 'custom_category_id', $data, array('prompt' => '--- Select Custom Category ---', 'name' => 'ProductCustomCategory[custom_category_id][]'));?>
    </div>
    <?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'placeholder' => 'Product Description')); ?>

    <?php echo $form->textFieldRow($model, 'price', array('placeholder' => 'Price')); ?>

    <?php // echo $form->textFieldRow($model, 'price_type', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Currency'));  ?>

    <?php echo $form->textFieldRow($model, 'minimum_quantitiy', array('maxlength' => 10, 'placeholder' => 'Minimum Order Quantity')); ?>

    <?php echo $form->textFieldRow($model, 'stock', array('maxlength' => 10, 'placeholder' => 'Stock Unit')); ?>

    <div class="control-group">
        <div class="control-label"><?php echo $form->labelEx($productImages, 'image'); ?></div>
        <div class="controls">
            <?php
            $this->widget('ext.EAjaxUpload.EAjaxUpload', //select file button
                    array(
                'id' => 'uploadFile',
                'config' => array(
                    'action' => Yii::app()->createAbsoluteUrl('admin/product/upload'),
                    'multiple' => true,
                    'debug' => false,
                    'allowedExtensions' => array("jpg", "jpeg", 'gif', 'png'), //array("jpg","jpeg","gif","exe","mov" and etc...
                    'sizeLimit' => 2 * 1024 * 1024, // maximum file size in bytes (10 MB))
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
                                                $('#thumbs_list').append('<div id=\"image_preview\" class=\"preview_'+index+'\"><li id=\"thumbs_'+index+'\" class=\"pull-left thumbnail span2\"><img src=\"'+responseJSON.imageThumb+'\" alt=\"'+responseJSON.filename+'\" class=\span2\"></li>'+
                                                '<a href=\"javascript:(void);\" onClick=\"getRemove('+index+', \''+responseJSON.filename+'\')\" class=\"btn btn-danger\">Remove</a><input type=\"hidden\" name=\"ProductImages[image][]\" value=\"'+responseJSON.filename+'\"></div><div class=\"clearfix\"></div>');
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
            <?php echo $form->error($productImages, 'image'); ?>
            <div class="clearfix"></div>
            <ul id="thumbs_list">
                <?php
                if (!$model->isNewRecord && is_array($productImageLists)) {
                    foreach ($productImageLists as $image) {
                        static $i = 1;
                        echo '<li id="thumbs_' . $i . '" class="preview_' . $i . ' pull-left">';
                        echo CHtml::hiddenField('ProductImages[image][]', $image->image);
                        echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/product/thumbs/' . $image->image), $image->image, array('class' => 'thumbnail span2'));
                        echo '<a href="javascript:void(0);" onClick="getRemove(' . $i . ',\'' . $image->image . '\')" class="btn btn-danger">Remove</a>';
                        echo '</li>';
                        $i++;
                    }
                }
                ?>
            </ul>
        </div>
    </div>


    <?php echo $form->dropDownListRow($model, 'status', array(0 => 'Draft', 1 => 'Publish'), array('prompt' => '--- Select Status ---')); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-success')); ?>
        <?php if ($model->isNewRecord) echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>

    <?php if (!$model->isNewRecord) { ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $.ajax({
                    type: 'post',
                    url: '<?php echo Yii::app()->createAbsoluteUrl('admin/product/customCategory'); ?>',
                    data: {company_id: <?php echo $model->company_id; ?>},
                    success: function(html){
                        update('#ProductCustomCategory_custom_category_id', html);
                    }
                                                                                
                });
            })
        </script>
    <?php } ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $(document).ready(function(){
        $('.category').hide();
        $('.custom-category').hide();
        showCategoryList(<?php echo (!$model->isNewRecord) ? $model->category_type : '0'; ?>);
    });
    
    function showCategoryList(val){
        if(val == 0){
            $('.category').show();
            $('.custom-category').hide();
        }else if(val == 1){
            $('.custom-category').show();
            $('.category').hide();
        }else{
            $('.custom-category').show();
            $('.category').show();
        }
    }
    
    function getRemove(index, image) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("admin/product/remove_image"); ?>',
            data: {image: image},
            success: function(data) {
                if (data === 'success') {
                    $('#thumbs_list .preview_' + index).remove();
                    $('#thumbs_list #thumbs_'+index).remove();
                    
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