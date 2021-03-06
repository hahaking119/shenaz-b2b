<div class="left-nav">
    <ul>
        <li class="all-categories">All Categories</li>
    </ul>
    <ul class ="categories_list">
        <?php
        foreach ($categories as $category) {
            ?>
            <li>
                <?php
                echo CHtml::link($category->title, Yii::app()->createAbsoluteUrl('site/menu/view/' . $category->slug));
                $subCategories = Category::model()->findAllByAttributes(array('parent_id' => $category->category_id, 'trash' => 0, 'status' => 1), array('order' => 'title ASC'));
                if (!empty($subCategories)) {
                    ?>
                    <span class = 'pull-right'><i class="icon-chevron-right"></i></span>
                    <div class = "subcategory">
                        <?php
                        foreach ($subCategories as $subCategory) {
                            ?>
                            <dl>
                                <?php echo "<dt>" . CHtml::link($subCategory->title, Yii::app()->createAbsoluteUrl('site/menu/view/' . $subCategory->slug)) . "</dt>"; ?>
                                <?php
                                $level_2_categories = Category::model()->findAllByAttributes(array('parent_id' => $subCategory->category_id, 'trash' => 0, 'status' => 1), array('order' => 'title ASC'));
                                if (!empty($level_2_categories)) {
                                    echo "<dd class = 'level_2_category'>";
                                    foreach ($level_2_categories as $level_2_category) {
                                        echo CHtml::link($level_2_category->title, Yii::app()->createAbsoluteUrl('site/menu/view/' . $level_2_category->slug));
                                    }
                                    echo "</dd>";
                                    ?>
                                </dl>
                                <?php
                            } else {
                                echo "<dd class = 'level_2_category'></dd></dl>";
                            }
                        }
                        ?>
                        <?php if (!empty($category->image)) { ?>
                            <div class="category-image">
                                <img src="<?php echo Yii::app()->createAbsoluteUrl('uploads/category/image/thumbs/' . $category->image); ?>" alt="">
                            </div>
                        <?php } ?>
                    </div>
                </li>
                <?php
            }
        }
        ?>
        <li><a href="<?php echo Yii::app()->createAbsoluteUrl('site/view_all'); ?>">View All Categories</a></li>
    </ul>
</div>
