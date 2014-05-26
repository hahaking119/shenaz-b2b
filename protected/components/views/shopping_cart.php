<div id="shopcart">
    <div id="shopping-cart">
        <?php
        if (!isset(Yii::app()->session['shopping_list'])) {
            echo '<h3>' . CHtml::link('My Cart', array(
                '')) . '</h3>Your shopping cart is empty.';
        } else {
            if (isset(Yii::app()->session['shopping_list']) && !empty(Yii::app()->session['shopping_list'])) {
                foreach ($products as $product) {
                    $item = Product::model()->findByAttributes(array('product_id' => $product['product_id']));
                    ?>
                    <div class="row">
                        <div class="span1"><?php echo $product['qty']; ?></div>
                        <div class="span1"><?php echo $item->name; ?></div>
                        <div class="span1"><?php echo ($item->price * $product['qty']); ?></div>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
</div>