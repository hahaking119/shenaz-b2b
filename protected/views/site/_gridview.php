<li>
    <a href="<?php echo Yii::app()->createAbsoluteUrl('site/product/view/' . $data->product->slug); ?>">
        <div class="image">
            <?php
            $image = ProductImage::model()->findByAttributes(array('product_id' => $data->product_id));
            echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/product/thumbs/' . $image->image), '');
            ?>
        </div>
        <h3><?php echo $data->product->name; ?></h3>
        <div class="cost">
            From
            <span class="price"><?php echo $data->product->price; ?></span>
            / Piece
        </div>
    </a>
</li>

