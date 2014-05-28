<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<!-- Important Owl stylesheet -->
<link rel="stylesheet" href="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/owl_carousel/owl-carousel/owl.carousel.css'); ?>">
 
<!-- Default Theme -->
<link rel="stylesheet" href="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/owl_carousel/owl-carousel/owl.theme.css')?>">
 
<!--  jQuery 1.7+  -->
<!--<script src="<?php // echo Yii::app()->createAbsoluteUrl('themes/default/scripts/owl_carousel/assets/js/jquery-1.9.1.min.js')?>"></script>-->
 
<!-- Include js plugin -->
<script src="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/owl_carousel/owl-carousel/owl.carousel.js')?>"></script>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<div class="new-arrivals">
    <h2>New Arrivals</h2>
    <ul id="products-slider">
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
                            <?php 
                                $form=$this->beginWidget('CActiveForm', array(
                                    'id'=>'product-rating-form',
                                    'enableAjaxValidation'=>false,
                                ));
                            ?>
                                    <?php
                                        $totalRating = Rating::model()->findAll();
                                        $rating = Rating::model()->findAll('product_id = '.$product->product_id);
                                        if(!empty($totalRating)){
                                            $sum = 0;
                                            $vote_sum = 0;
                                            foreach($totalRating as $rate)
                                            {
                                                $sum = $sum + $rate->rating;
                                            }
                                            foreach($rating as $vote){
                                                $vote_sum = $vote_sum + $vote->rating;
                                            }
                                            $ratingPercentage = ($vote_sum/$sum)*100;
                                            $value = ($ratingPercentage/100)*5;
                                        }
                                            $this->widget('CStarRating',array(
                                                      'name'=>'star-rating',
                                                      'value'=>  round($value),
                                                      'minRating'=>1,
                                                      'maxRating'=>5,
                                                      'starCount'=>5,
                                                      'allowEmpty'=>FALSE,
                                                      'readOnly'=>true
                                                    ));
                                     ?>

                                <?php $this->endWidget(); ?>
                        </div>
                        <span class="feedback-num">
                            <?php
                                $feedbacks = Feedback::model()->findAll('product_id ='.$product->product_id.' and status = 1 and trash = 0');
                                $count = 0;
                                foreach($feedbacks as $feedback){
                                    $count++;
                                }
                                echo "Feedback (".$count.")";
                            ?>
                        </span>
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

<div class="all-products">
    <?php
$this->widget('bootstrap.widgets.TbThumbnails', array(
    'dataProvider' => $dataProvider,
    'ajaxUpdate' => false,
    'itemView' => '_allproducts',
    'summaryText' => '',
    'template' => '{items}{pager}',
    'pagerCssClass' => 'pagination',
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

<script>
    $(document).ready(function() {
 
      $("#products-slider").owlCarousel({
          navigation : false, // Show next and prev buttons
          slideSpeed : 300,
          paginationSpeed : 400,
          items:5,
          autoPlay: true,
          stopOnHover: true
      });

    });
</script>