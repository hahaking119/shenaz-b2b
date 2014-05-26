<?php if (isset($banners) && !empty($banners)) { ?>
    <div class="banner">
        <?php foreach ($banners as $banner) { ?>
            <img src="<?php echo Yii::app()->createAbsoluteUrl('uploads/category/banner/original/' . $banner->banner); ?>" alt="">
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