<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<link rel="text/javascript" href="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/jquery.cycle.lite.js'); ?>">

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<div class="new-arrivals">
    <h2>New Arrivals</h2>
    <ul>

        <?php
        $i = 1;
        foreach ($recentProducts as $product) {
            $productImage = ProductImage::model()->findByAttributes(array('product_id' => $product->product_id));
            ?>

            <li>
                <div class="item">
                    <div class="item-info">
                        <div class="item-index"><?php echo $i; ?></div>
                        <div class="item-order">3567 Orders</div>
                    </div>
                    <?php echo CHtml::image(Yii::app()->createAbsoluteUrl('uploads/product/thumbs/' . $productImage->image)); ?>
                    <h3>Accessories fashion all-match personality cutout leaves multi-layer </h3>
                    <div class="cost">From <span class="price">US $<?php echo $product->price; ?></span> / Piece</div>
                    <div class="feedback">
                        <div class="rating">
                            <span class="stars">
                                <span class="rate-percent" style="width:95.2%"></span>
                            </span>
                        </div>
                        <span class="feedback-num">Feedback (2451)</span>
                    </div>
                </div>
            </li>
                <?php
                $i++;
            }
            ?>
    </ul>
    <div class="clearfix"></div>
</div>
