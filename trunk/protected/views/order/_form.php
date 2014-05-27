<div class="row">
    <div class="span9">


        <div class="form">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'order-form',
                'type' => 'horizontal',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation' => false,
                'clientOptions' => array('validateOnSubmit' => true),
                    ));
            ?>
            <div id="checkout-form" class="billing-information index-0" style="display: <?php echo (Yii::app()->session['billingInfo'] != '') ? 'none' : 'block'; ?>;">
                <div class="row">
                    <div class="span9"><h3>Billing Information</h3></div>
                </div>
                <div class="row">
                    <div class="span9">
                        <?php // echo $form->errorSummary($billingInformation); ?>
                        <?php echo $form->textFieldRow($billingInformation, 'first_name', array('placeholder' => 'First Name')); ?>
                        <?php echo $form->textFieldRow($billingInformation, 'last_name', array('placeholder' => 'Last Name')); ?>
                        <?php echo $form->textFieldRow($billingInformation, 'email', array('placeholder' => 'Email')); ?>
                        <?php echo $form->textFieldRow($billingInformation, 'company', array('placeholder' => 'Company')); ?>
                        <?php echo $form->textFieldRow($billingInformation, 'phone', array('placeholder' => 'Phone')); ?>
                        <?php echo $form->textFieldRow($billingInformation, 'area_code', array('placeholder' => 'Area Code/Zip Code')); ?>
                        <?php echo $form->textFieldRow($billingInformation, 'area', array('placeholder' => 'Area')); ?>
                        <?php echo $form->textFieldRow($billingInformation, 'province', array('placeholder' => 'Province')); ?>
                        <?php echo $form->textFieldRow($billingInformation, 'country', array('placeholder' => 'Country')); ?>
                        <!--                        <a href="javascript:void(0);" id="" onclick="validateForm('billing-information')">Next</a>    -->
                        <?php echo CHtml::submitButton('Next'); ?>
                    </div>
                </div>
            </div>
            <?php
            if ((isset(Yii::app()->session['billingInfo'])) && (!isset(Yii::app()->session['shippingInfo']))) {
                $shippingBlock = 'block';
            } else {
                $shippingBlock = 'none';
            }
            ?>
            <div id="checkout-form" class="shipping-information index-1" style="display:<?php echo $shippingBlock; ?>">
                <div class="row">
                    <div class="span9"><h3>Shipping Information</h3></div>
                </div>
                <div class="row">
                    <div class="span9">
                        <?php // echo $form->errorSummary(array($shippingInformation)); ?>
                        <?php echo $form->textFieldRow($shippingInformation, 'first_name', array('placeholder' => 'First Name')); ?>
                        <?php echo $form->textFieldRow($shippingInformation, 'last_name', array('placeholder' => 'Last Name')); ?>
                        <?php echo $form->textFieldRow($shippingInformation, 'email', array('placeholder' => 'Email')); ?>
                        <?php echo $form->textFieldRow($shippingInformation, 'company', array('placeholder' => 'Company')); ?>
                        <?php echo $form->textFieldRow($shippingInformation, 'phone', array('placeholder' => 'Phone')); ?>
                        <?php echo $form->textFieldRow($shippingInformation, 'area_code', array('placeholder' => 'Area Code/Zip Code')); ?>
                        <?php echo $form->textFieldRow($shippingInformation, 'area', array('placeholder' => 'Area')); ?>
                        <?php echo $form->textFieldRow($shippingInformation, 'province', array('placeholder' => 'Province')); ?>
                        <?php echo $form->textFieldRow($shippingInformation, 'country', array('placeholder' => 'Country')); ?>
                        <!--<a href="javascript:void(0);" id="">Next</a>-->
                        <?php echo CHtml::submitButton('Next'); ?>
                    </div>
                </div>
            </div>
            <?php
            if (isset(Yii::app()->session['billingInfo']) && isset(Yii::app()->session['shippingInfo']) && !isset(Yii::app()->session['shippingMethod'])) {
                $shippingMethodBlock = 'block';
            } else {
                $shippingMethodBlock = 'none';
            }
            ?>
            <div id="checkout-form" class="shipping-method index-2" style="display: <?php echo $shippingMethodBlock; ?>;">
                <div class="row">
                    <div class="span9"><h3>Shipping Method</h3></div>
                </div>
                <div class="row">
                    <div class="span9">
                        <?php echo $form->radioButtonListRow($order, 'shipping_method', array(1 => 'Consumer Pick Up')); ?>
                        <!--<a href="javascript:void(0);" id="">Next</a>-->
                        <?php echo CHtml::submitButton('Next'); ?>
                    </div>
                </div>
            </div>
            <?php
            if (isset(Yii::app()->session['billingInfo']) && isset(Yii::app()->session['shippingInfo']) && isset(Yii::app()->session['shippingMethod']) && !isset(Yii::app()->session['paymentMethod'])) {
                $paymentMethodBlock = 'block';
            } else {
                $paymentMethodBlock = 'none';
            }
            ?>
            <div id="checkout-form" class="payment-method index-3" style="display: <?php echo $paymentMethodBlock; ?>;">
                <div class="row">
                    <div class="span9"><h3>Payment Method</h3></div>
                </div>
                <div class="row">
                    <div class="span9">
                        <?php echo $form->radioButtonListRow($order, 'payment_method', array(1 => 'Cash')); ?>
                        <?php echo CHtml::submitButton('Next'); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script>
</script>