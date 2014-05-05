<h1>Custom Category Lists</h1>
<?php if (isset($customCategory) && !empty($customCategory)) { ?>
    <ul>
        <?php
        foreach ($customCategory as $category) {
            $children = CustomCategory::model()->findAllByAttributes(array('parent_id' => $category->id));
            ?>
            <li><?php echo CHtml::link($category->title, Yii::app()->createAbsoluteUrl('admin/member/update_custom_category/id/' . $category->id)); ?>
                <?php if (!empty($children)) { ?>
                    <ul>
                        <?php foreach ($children as $child) {
                            ?>
                            <li> - <?php echo CHtml::link($child->title, Yii::app()->createAbsoluteUrl('admin/member/update_custom_category/id/' . $child->id)); ?></li>
                        <?php }
                        ?>
                    </ul>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
<?php }
?>
<?php
echo CHtml::link('+ Add Category', '#form', array('class' => 'pull-right connect btn', 'id' => 'custom-category'));

$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => '#custom-category'));
?>
<div id="form" style="display: none">
    <?php $this->renderPartial('_custom_category_form', array('model' => $model, 'customCategory' => $customCategory)); ?>
</div>


