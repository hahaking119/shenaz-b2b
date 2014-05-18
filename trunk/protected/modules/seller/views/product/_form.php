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
        echo $form->hiddenField($model, 'company_id'); 
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
        if(!$model->isNewRecord){
            $category_id = $productCategory->category_id;
            // Fetch the selected Category.
            $category = Category::model()->findByPk($productCategory->category_id);
            if($category->parent_id != 0){
                $category2 = Category::model()->findByPk($category->parent_id);
                if($category2->parent_id != 0){
                    $category3 = Category::model()->findByPk($category2->parent_id);
                    $productCategory->category_id = $category3->category_id;
                    $productCategory->subcategory_id = $category2->category_id;
                    $productCategory->level2 = $category_id;
                }
                else{
                    $category2 = Category::model()->findByPk($category->parent_id);
                    $productCategory->category_id = $category2->category_id;
                    $productCategory->subcategory_id = $category_id;
                }
            }
            else{
                $productCategory->category_id = $category_id;
                $productCategory->subcategory_id = "";
                $productCategory->level2 = "";
            }
            
            if(!empty($productCategory->category_id)){
                $data1 = CHtml::listData(Category::model()->findAllByAttributes(array('parent_id'=>$productCategory->category_id, 'trash' => 0, 'status' => 1)),'category_id','title');
            }
            else{
                $data1 = array();
            }
            if(!empty($productCategory->subcategory_id)){
                $data2 = CHtml::listData(Category::model()->findAllByAttributes(array('parent_id'=>$productCategory->subcategory_id, 'trash' => 0, 'status' => 1)), 'category_id', 'title');
            }
            else{
                $data2 = array();
            }
        }
        else{ 
            $data1 = array();
            $data2 = array();
            $display = 'none';
        }
        ?>
        <?php echo $form->dropDownListRow($productCategory, 'category_id', CHtml::listData($categories, 'category_id', 'title'), array('prompt' => '--- Select Category ---',
            'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('listSubCategories'),
            'update' => '#ProductCategory_subcategory_id',
            'complete' => '$("#subcategory").css("display","block")',
            'data' => array('id' => 'js:this.value'),
        )
            )); ?>
    </div>
    <div id="subcategory" style="display: <?php echo $display; ?>">
        <?php echo $form->dropDownListRow($productCategory, 'subcategory_id', $data1, array(
            'prompt' => '--- Select Sub Category ---',
            'style' => '',
            'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('listLevel2Categories'),
            'update' => '#ProductCategory_level2',
            'complete' => '$("#level_2_cat").css("display","block")',
            'data' => array('id' => 'js:this.value'),
        )
            )); ?>
    </div>
    
    <div id="level_2_cat" style="display: <?php echo $display; ?>">
        <?php echo $form->dropDownListRow($productCategory, 'level2', $data2, array('prompt'=>'--- Select Level 2 Category ---')); ?>
    </div>
    
    <div class="custom-category">
        <?php
//        if (isset($productCustomCategoryList)) {
//            foreach ($productCustomCategoryList as $customCategoryList) {
//                $customCategoryListArray[] = $customCategoryList->custom_category_id;
//            }
//            $productCustomCategory->custom_category_id = $customCategoryListArray;
//        }
        if (!$model->isNewRecord) {
            $custom_category_id = $productCustomCategory->custom_category_id;
            // Fetch the selected Custom Category.
            $custom_category = CustomCategory::model()->findByPk($productCustomCategory->custom_category_id);
            if($custom_category->parent_id != 0){
                $custom_category2 = CustomCategory::model()->findByPk($custom_category->parent_id);
                if($custom_category2->parent_id != 0){
                    $custom_category3 = CustomCategory::model()->findByPk($custom_category2->parent_id);
                    $productCustomCategory->custom_category_id = $custom_category3->id;
                    $productCustomCategory->level1 = $custom_category2->id;
                    $productCustomCategory->level2 = $custom_category_id;
                }
                else{
                    $custom_category2 = CustomCategory::model()->findByPk($custom_category->parent_id);
                    $productCustomCategory->custom_category_id = $custom_category2->id;
                    $productCustomCategory->level1 = $custom_category_id;
                }
            }
            else{
                $productCustomCategory->custom_category_id = $custom_category_id;
            }
                        
            $level_1_data = CHtml::listData(CustomCategory::model()->findAllByAttributes(array('parent_id'=>$productCustomCategory->custom_category_id, 'trash' => 0, 'status' => 1)),'id','title');
            if(empty($level_1_data)){
                $level_1_data = array();
            }
            $level_2_data = CHtml::listData(CustomCategory::model()->findAllByAttributes(array('parent_id'=>$productCustomCategory->level1, 'trash' => 0, 'status' => 1)), 'id', 'title');
            if(empty($level_2_data)){
                $level_2_data = array();
            }
        }
        else{
            $data = CHtml::listData(CustomCategory::model()->findAllByAttributes(array('company_id' => $company_id, 'parent_id'=>0, 'status'=>1, 'trash'=>0)), 'id', 'title');
            $level_1_data = array();
            $level_2_data = array();
        }
        if(empty($data))
            $data = array();
        ?>
        <?php
        echo $form->dropDownListRow($productCustomCategory, 'custom_category_id', CHtml::listData(CustomCategory::model()->findAllByAttributes(array('company_id' => $model->company_id, 'parent_id'=>0, 'status'=>1, 'trash'=>0)), 'id', 'title'), array('prompt' => '--- Select Custom Category ---',
            'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('listLevel1CustomCategories'),
            'update' => '#ProductCustomCategory_level1',
            'complete' => '$("#custom_cat_level_1").css("display","block")',
            'data' => array('id' => 'js:this.value'),
            )
            ));
        ?>
        <div id="custom_cat_level_1" style="display: <?php echo $display; ?>">
            <?php echo $form->dropDownListRow($productCustomCategory, 'level1', $level_1_data, array('prompt'=>'Select Level 1 Custom Category',
                'ajax' => array(
                'type' => 'POST',
                'url' => CController::createUrl('listLevel2CustomCategories'),
                'update' => '#ProductCustomCategory_level2',
                'complete' => '$("#custom_cat_level_2").css("display","block")',
                'data' => array('id' => 'js:this.value'),
                )
                )); ?>
        </div>
        <div id="custom_cat_level_2" style="display: <?php echo $display; ?>">
            <?php echo $form->dropDownListRow($productCustomCategory, 'level2', $level_2_data, array('prompt'=>'Select Level 2 Custom Category')); ?>
        </div>
    </div>
    <?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'placeholder' => 'Product Description')); ?>

    <?php echo $form->textFieldRow($model, 'price', array('placeholder' => 'Price')); ?>

    <?php // echo $form->textFieldRow($model, 'price_type', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Currency')); ?>

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
                    'action' => Yii::app()->createAbsoluteUrl('seller/product/upload'),
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
                        echo '<a href="javascript:void(0);" onClick="getRemove(' . $i . ',\'' . $image->image . '\','.$image->id.')" class="btn btn-danger">Remove</a>';
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
        showCategoryList(<?php echo (!$model->isNewRecord) ? $model->category_type : ''; ?>);
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
    
    function getRemove(index, image, id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("seller/product/remove_image"); ?>',
            data: {image: image, id: id},
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