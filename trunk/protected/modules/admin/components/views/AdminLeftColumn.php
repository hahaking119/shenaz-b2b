<?php
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
$this->widget('zii.widgets.CMenu', array(
    'htmlOptions' => array('class' => 'parent'),
    'activateParents' => true,
    'submenuHtmlOptions' => array('class' => 'child'),
    'items' => $arr,
));
?>
<script type='text/javascript'>
    $(window).load(function() {
        //        $('.child').hide(); //Hide children by default
        $('.<?php echo $controller; ?> .child').addClass('active');
        $('.parent').children().click(function() {
            $(this).children('.child').slideToggle('fast');
        }).children('.child').click(function() {
            event.stopPropagation();
        });
    });
    $(document).ready(function(){
        $('a').each(function(index, value) { 
            if ($(this).prop("href") === window.location.href) {
                $(this).addClass("current-page");
            } 
        });
    });

</script>