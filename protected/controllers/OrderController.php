<?php

class OrderController extends CController {

    public function init() {

        parent::init();
        if (Yii::app()->user->isGuest)
            Yii::app()->theme = 'default';
        else {
//            Yii::app()->theme = 'classic';
            Yii::app()->theme = 'default';
        }
    }

    public $layout = '//layouts/column2';

    public function beforeAction() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createAbsoluteUrl('site/login'));
            Yii::app()->end();
        } else {
            return true;
        }
    }

    public function actionCreate($billingInfo = '', $shippingInfo = '', $shippingMethod = '', $paymentMethod = '') {
        $order = new Order;
        $companyInformation = CompanyInformation::model()->findByAttributes(array('member_id' => Yii::app()->user->getId()));
        $billingInformation = new BillingInformation();
        $shippingInformation = new ShippingInformation();
        if (isset(Yii::app()->session['billingInfo'])) {
            $billingInfo = Yii::app()->session['billingInfo'];
            $billingInformation = $billingInfo;
        }
        if (isset(Yii::app()->session['ShippingInfo'])) {
            $shippingInfo = Yii::app()->session['ShippingInfo'];
            $shippingInformation = $shippingInfo;
        }
        if (isset(Yii::app()->session['shippingMethod'])) {
            $shippingMethod = Yii::app()->session['shippingMethod'];
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            if (isset($_POST['BillingInformation']) && !empty($billingInfo)) {
                echo CActiveForm::validate(array($billingInformation));
            }
            if (isset($_POST['ShippingInformation'])) {
                echo CActiveForm::validate(array($shippingInformation));
            }
//            echo CActiveForm::validate(array($order, $billingInformation, $shippingInformation));
            Yii::app()->end();
        }

        if (isset($_POST['BillingInformation'])) {
            $billingInformation->attributes = $_POST['BillingInformation'];
            if (!$billingInformation->validate()) {
                if (isset(Yii::app()->session['billingInfo'])) {
                    unset(Yii::app()->session['billingInfo']);
                }
            } else {
                Yii::app()->session['billingInfo'] = $billingInformation;
            }
        }
        if (isset($_POST['ShippingInformation'])) {
            $shippingInformation->attributes = $_POST['ShippingInformation'];
            if (!$shippingInformation->validate()) {
                if (isset(Yii::app()->session['ShippingInfo'])) {
                    unset(Yii::app()->session['ShippingInfo']);
                }
            } else {
                Yii::app()->session['shippingInfo'] = $shippingInformation;
            }
        }
        if (isset($_POST['Order']['shipping_method'])) {
            Yii::app()->session['shippingMethod'] = $_POST['Order']['shipping_method'];
        }
        if (isset($_POST['Order']['payment_method'])) {
            Yii::app()->session['paymentMethod'] = $_POST['Order']['payment_method'];
        }
        $this->render('_form', array(
            'order' => $order,
            'billingInformation' => $billingInformation,
            'shippingInformation' => $shippingInformation,
            'companyInformation' => $companyInformation,
            'billingInfo' => $billingInfo,
            'paymentInfo' => $paymentInfo,
            'shippingMethod' => $shippingMethod,
            'paymentMethod' => $paymentMethod,
        ));
    }

}
