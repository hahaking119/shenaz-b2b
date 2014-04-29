<?php
$this->widget('zii.widgets.CMenu', array(
    'htmlOptions' => array('class' => 'parent'),
    'activeCssClass' => 'active',
    'activateParents' => true,
    'submenuHtmlOptions' => array('class' => 'child'),
    'items' => $arr,
    'activeCssClass' => 'active',
));
?>
<script type='text/javascript'>
    $(window).load(function() {
        $('.child').hide(); //Hide children by default

        $('.parent').children().click(function() {
            $(this).children('.child').slideToggle('fast');
        }).children('.child').click(function() {
            event.stopPropagation();
        });
    });
</script>