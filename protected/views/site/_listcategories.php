<?php
foreach ($categories as $category) {
    $subCategories = Category::model()->findAllByAttributes(array('parent_id' => $category->category_id, 'status' => 1, 'trash' => 0));
    if (!empty($subCategories)) {
        ?>
        <!--<div class="row">-->

            <?php
            foreach ($subCategories as $subCategory) {
                $level_3 = Category::model()->findAllByAttributes(array('parent_id' => $subCategory->category_id, 'status' => 1, 'trash' => 0), array('order' => 'title ASC'));
                if (!empty($level_3)) {
                    ?>
                    <div class="span3 pull-left">
                        <h3><a href="<?php echo Yii::app()->createAbsoluteUrl('site/menu/view/' . $subCategory->slug); ?>"><?php echo $subCategory->title; ?></a></h3>
                        <ul>
                            <?php foreach ($level_3 as $list) { ?>
                                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('site/menu/view/' . $list->slug); ?>"><?php echo $list->title; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php
                }
            }
            ?>

        <!--</div>-->
        <?php
    }
}
