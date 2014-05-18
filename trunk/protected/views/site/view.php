<?php
$this->widget('bootstrap.widgets.TbThumbnails', array(
    'dataProvider' => $dataProvider,
    'ajaxUpdate' => false,
    'itemView' => '_gridview',
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