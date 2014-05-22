<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<!-- jQuery library (served from Google) -->
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->
<!-- bxSlider Javascript file -->
<script src="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/jquery.bxslider/jquery.bxslider.min.js'); ?>"></script>
<!-- bxSlider CSS file -->
<link href="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/jquery.bxslider/jquery.bxslider.css'); ?>" rel="stylesheet" />

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<div class="new-arrivals">
    <h2>New Arrivals</h2>
    <ul class="bxslider">

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
                    <div class="image">
                        <?php echo CHtml::link(CHtml::image(Yii::app()->createAbsoluteUrl('uploads/product/thumbs/' . $productImage->image)),array('/site/product/', 'view' => $product->slug)); ?>
                    </div>
                    <h3><?php echo $product->description; ?></h3>
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

<div class="all_products">
    <?php
$this->widget('bootstrap.widgets.TbThumbnails', array(
    'dataProvider' => $dataProvider,
    'ajaxUpdate' => false,
    'itemView' => '_allproducts',
    'summaryText' => '',
    'template' => '{items}<br />{pager}',
    'pagerCssClass' => 'pro-pagination',
    'pager' => array(
        'cssFile' => FALSE,
        'header' => '',
        'firstPageLabel' => '<<',
        'prevPageLabel' => '<',
        'nextPageLabel' => '>',
        'lastPageLabel' => '>>',
    ),
));
?>    
</div>

<script type="text/javascript">

$(document).ready(function(){
     $('.bxslider').bxSlider({
      minSlides: 5,
      maxSlides: 5,
      slideWidth: 163,
      slideMargin: 10,
      ticker: true,
      speed: 50000,
      autoDelay: 2000,
      });
});

</script>
