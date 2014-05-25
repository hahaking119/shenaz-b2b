<div id="shopcart">
    <div id="shopping-cart">
        <?php
        if (!Yii::app()->session['shopping_list']) {
            echo '<h3>' . CHtml::link('My Cart', array(
                '')) . '</h3>Your shopping cart is empty.';
        } else {
            ?>
            <?php
            if (Yii::app()->user->isGuest) {
                $data = CHtml::link('Check Out <i class="icon-chevron-right icon-white"></i>', array(), array('style' => 'padding: 5px; margin: 0 5px 5px 0;', 'id' => 'button', 'class' => 'btn btn-success', 'data-toggle' => 'modal',
                            'data-target' => '#myModal',));
            } else {
//                $outofstock = CommonClass::checkOutofstock();
//                if (is_array($outofstock)) {
////                    Yii::app()->user->setFlash('error', '<strong>Out of Stock!</strong> Highlighted products are out of stock.');
//                    $data = CHtml::link('Check Out <i class="icon-chevron-right icon-white"></i>', array(
//                                '//shop/shoppingCart/view'), array('style' => 'padding: 5px; margin: 0 5px 5px 0;', 'class' => 'btn btn-success')) . '';
//                } else {
//                    $data = CHtml::link('Check Out <i class="icon-chevron-right icon-white"></i>', array(
//                                '//shop/order/create'), array('style' => 'padding: 5px; margin: 0 5px 5px 0;', 'class' => 'btn btn-success')) . '';
//                }
            }
//            echo '<h3>' . CHtml::link('My Cart', array(
//                '//shop/shoppingCart/view')) . '</h3>.';
            echo CHtml::link('<i class="icon-shopping-cart icon-white"></i> View My Cart', array(
                ''), array('style' => 'padding: 5px; margin: 0 5px 5px 5px;', 'id' => 'button', 'class' => 'btn btn-warning'))
            . $data;
            ?>
            <div class="clear-fix"></div>
            <div id="shopping-cart-content">
                <?php
                $totalPrice = 0;
                if ($products) {
                    echo '<div class="cart-content">';

                    echo '<table class="table table-condensed">';
                    foreach ($products as $num => $position) {
                        $model = Product::model()->findByPk($position['product_id']);
                        printf('<tr>
				<td class="cart-left widget_amount_' . $num . '">%s</td>
				<td class="cart-middle">%s</td>
				<td class="cart-right price_' . $num . '">%s</td></tr>', $position['qty'], $model->name, CommonClass::getTotalPriceFormat($position['qty'] * $model->getPrice(@$position['product_id']))
                        );
                        $totalPrice += $position['qty'] * $model->price;
                    }

//                    if ($shippingMethod = CommonClass::getShippingMethod()) {
//                        printf('<tr>
//				<td class="cart-left">1</td>
//				<td class="cart-middle">%s</td>
//				<td class="cart-right">%s</td></tr>', 'Shipping costs', CommonClass::getPriceFormat($shippingMethod->rate)
//                        );
//                    }

//                    $packaging = Yii::app()->user->getState('packaging');
//                    if ($packaging != '') {
//                        $packaging = OrderLineItemsCompulsory::model()->findByPk(Yii::app()->user->getState('packaging'));
//                        printf('<tr>
//				<td class="cart-left">1</td>
//				<td class="cart-middle">%s</td>
//				<td class="cart-right">%s</td></tr>', 'Packaging costs', CommonClass::getPriceFormat($packaging->rate)
//                        );
//                    }
                    echo '</table>';

                    echo'</div>';
//                    printf('<strong>%s</strong>', CommonClass::getPriceTotal());
                }
                ?>
            </div>
            <strong>
                <table class="basket">
                    <tr>
                        <td class="span3">
                            Sub Total:
                        </td>
                        <td width="50px">
                            <?php echo $totalPrice; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Discount:
                        </td>
                        <td>
                            <?php $discount = 0; ?>
                            <?php echo $discount; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Total:
                        </td>
                        <td>
                            <?php $total = $totalPrice - $discount; ?>
                            <?php echo $total; ?>
                        </td>
                    </tr>
                </table>
            </strong>
            <div id="shopping-cart-footer"></div>
        <?php } ?>
    </div>
</div>