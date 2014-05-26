    <div id="shopping-cart">
        <?php
        if (!isset(Yii::app()->session['shopping_list'])) {
            echo '<h3>' . CHtml::link('My Cart', array(
                ''),array('id' => 'my-cart-link-text')) . '</h3><p>Your shopping cart is empty.</p>';
        } else {
            if (isset(Yii::app()->session['shopping_list']) && !empty(Yii::app()->session['shopping_list'])) {
                static $price = 0;
                foreach ($products as $product) {
                    $item = Product::model()->findByAttributes(array('product_id' => $product['product_id']));
                    $price = $price + ($item->price * $product['qty']);
                    ?>
                    <div class="">
                        <div class="span1"><?php echo $product['qty']; ?></div>
                        <div class="span2"><?php echo $item->name; ?></div>
                        <div class="span1"><?php echo ($item->price * $product['qty']); ?></div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="basket">
                <div class="span1">&nbsp;</div>
                <div class="span2">Total Price:</div>
                <div class="span1">
                    <?php
                    if (isset($price)) {
                        echo $price;
                    }
                    ?>
                </div>
            </div>
            <div class="cart-buttons">
                <div class="span2"><?php echo CHtml::link('<i class="icon-shopping-cart icon-white"></i>View Cart', Yii::app()->createAbsoluteUrl('shoppingCart/view'), array('id' => 'button', 'class' => 'btn btn-warning')); ?></div>
                <div class=""><?php echo CHtml::link('Check Out <i class="icon-chevron-right icon-white"></i>', Yii::app()->createAbsoluteUrl('shoppingCart/checkout'), array('id' => 'button', 'class' => 'btn btn-success')); ?></div>
            </div>
        <div class="clearfix"></div>
        <?php } ?>
    </div>