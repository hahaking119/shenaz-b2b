<?php if ($data->status == 1) { ?>
    <li>
        <a href="<?php echo Yii::app()->createAbsoluteUrl('site/product/view/' . $data->slug); ?>">
            <div class="image">
                <?php
                $image = ProductImage::model()->findByAttributes(array('product_id' => $data->product_id));
                echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/product/thumbs/' . $image->image), '');
                ?>
            </div>
            <h3><?php echo $data->name; ?></h3>
            <div class="cost">
                From
                <span class="price"><?php echo CommonClass::getPriceFormat($data->company->member_id) . ' ' . $data->price;
                ?></span>
                / Piece
            </div>
        </a>
    </li>
<?php } ?>

