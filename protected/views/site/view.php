<!-- Important Owl stylesheet -->
<link rel="stylesheet" href="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/owl_carousel/owl-carousel/owl.carousel.css'); ?>">
 
<!-- Default Theme -->
<link rel="stylesheet" href="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/owl_carousel/owl-carousel/owl.theme.css')?>">
 
<!--  jQuery 1.7+  -->
<script src="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/owl_carousel/assets/js/jquery-1.9.1.min.js')?>"></script>
 
<!-- Include js plugin -->
<script src="<?php echo Yii::app()->createAbsoluteUrl('themes/default/scripts/owl_carousel/owl-carousel/owl.carousel.js')?>"></script>

<?php if (isset($banners) && !empty($banners)) { ?>
    <div id="owl-carousel" class="">
        <?php foreach ($banners as $banner) { ?>
        <div class="item"><img src="<?php echo Yii::app()->createAbsoluteUrl('uploads/category/banner/original/' . $banner->banner); ?>" alt=""></div>
        <?php } ?>
    </div>
<?php } ?>
<?php
$this->widget('bootstrap.widgets.TbThumbnails', array(
    'dataProvider' => $dataProvider,
    'ajaxUpdate' => false,
    'itemView' => '_gridview',
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
<script>
    $(document).ready(function() {
 
      $("#owl-carousel").owlCarousel({
          navigation : false, // Show next and prev buttons
          slideSpeed : 300,
          paginationSpeed : 400,
          singleItem:true,
          autoPlay: true,
          stopOnHover: true
      });

    });
</script>