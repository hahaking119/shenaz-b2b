<div id="shopcart">
    <div id="shopping-cart">
        <?php
        if (!isset(Yii::app()->session['shopping_list'])) {
            echo '<h3>' . CHtml::link('My Cart', array(
                '')) . '</h3>Your shopping cart is empty.';
        } else {
            if (isset(Yii::app()->session['shopping_list']) && !empty(Yii::app()->session['shopping_list'])) {
                static $price = 0;
                foreach ($products as $product) {
                    $item = Product::model()->findByAttributes(array('product_id' => $product['product_id']));
                    $price = $price + ($item->price * $product['qty']);
                    ?>
                    <div class="row">
                        <div class="span1"><?php echo $product['qty']; ?></div>
                        <div class="span2"><?php echo $item->name; ?></div>
                        <div class="span1"><?php echo ($item->price * $product['qty']); ?></div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="row">
                <div class="span1"></div>
                <div class="span2">Total Price:</div>
                <div class="span1">
                    <?php
                    if (isset($price)) {
                        echo $price;
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="span1"><a href="<?php echo Yii::app()->createAbsoluteUrl('shoppingCart/view'); ?>">View Cart</a></div>
                <div class="span1"><a href="<?php echo Yii::app()->createAbsoluteUrl('shoppingCart/checkout'); ?>">Check Out</a></div>
            </div>
        <?php } ?>
    </div>
</div>