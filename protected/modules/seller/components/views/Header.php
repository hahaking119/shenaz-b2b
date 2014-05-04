<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="span2">
                <div class="logo"><?php echo CHtml::image(Yii::app()->theme->baseUrl . '/images/logo.png', CHtml::encode(Yii::app()->name), array('onerror' => '')); ?></div>
            </div>
            <div class="span10">
                <div class="date pull-right"><?php if (!Yii::app()->user->isGuest) echo CommonClass::getDateFormat(date('Y-m-d')); ?></div>
            </div>
        </div>
    </div>
</div>
