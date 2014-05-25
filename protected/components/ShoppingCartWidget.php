
<?php
Yii::import('zii.widgets.CPortlet');
//Yii::app()->getModule('shop');

class ShoppingCartWidget extends CPortlet {

    public function init() {
        return parent::init();
    }

    public function run() {
        $this->render('shopping_cart', array(
            'products' => Yii::app()->session['shopping_list']));

        return parent::run();
    }

}
?>

<script type="text/javascript">
    $(document).ready(function() {
        var s = $("#shopping-cart");
        var pos = s.position();					   
        $(window).scroll(function() {
            var windowpos = $(window).scrollTop();
            //s.html("Distance from top:" + pos.top + "<br />Scroll position: " + windowpos);
            if (windowpos >= pos.top) {
                s.addClass("stick");
            } else {
                s.removeClass("stick");	
            }
        });
    });
</script>