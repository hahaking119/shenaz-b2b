<?php

class InquiryController extends CController {

    public $layout = '//layouts/column2';

    public function init() {

        parent::init();
        if (Yii::app()->user->isGuest)
            Yii::app()->theme = 'default';
        else {
//            Yii::app()->theme = 'classic';
            Yii::app()->theme = 'default';
        }
    }

    public function beforeAction() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createAbsoluteUrl('site/login'));
            Yii::app()->end();
        } else {
            return true;
        }
    }

    public function actionIndex() {
        if (isset(Yii::app()->session['shopping_list'])) {
            $company_id = array();
            $cart = Yii::app()->session['shopping_list'];
            $order = new Order;
            $order->member_id = Yii::app()->user->getId();
            $order->order_type = 0;
            $order->total = CartComponent::getCartTotal();
            $order->created_at = new CDbExpression('NOW()');
            $order->modified_at = new CDbExpression('NOW()');
            if ($order->save()) {
                foreach ($cart as $item) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->order_id;
                    $orderItem->product_id = $item['product_id'];
                    $orderItem->quantity = $item['qty'];
                    $orderItem->save();
                }
                foreach ($cart as $item) {
                    $company = Product::model()->findByPk($item['product_id']);
                    $company_id[$company->company_id][$item['product_id']] = $item['qty'];
                }
            }
            foreach ($company_id as $company => $products) {
                $member_id = CompanyInformation::model()->findByPk($company)->member_id;
                $email = new Email;
                $email->from = Yii::app()->user->getId();
                $email->to = $member_id;
                $email->subject = 'B2B : INQUIRY FOR THE PRODUCT';
                $message = 'Hi There<br><br>';
                $message .= 'You have inquir(y/ies) from ' . Member::model()->getName(Yii::app()->user->getId()) . ' for the following products.<br><br>';
                foreach ($products as $key => $value) {
                    $product = Product::model()->findByPk($key);
                    $message .= $product->name . ':' . $value . '<br>';
                }
                $message .= '<br>Thank You<br> B2B Team';
                $email->message = $message;
                $email->created_at = new CDbExpression('NOW()');
                $email->modified_at = new CDbExpression('NOW()');
                $email->save();
            }
            unset(Yii::app()->session['shopping_list']);
            Yii::app()->user->setFlash('success', '<strong>Success!</strong> Your inquiry has been successfully placed.');
        } else {
            Yii::app()->user->setFlash('error', '<strong>Oops!</strong> You have no items to inquiry.');
        }
        $this->redirect(Yii::app()->createAbsoluteUrl('site/index'));
    }

}
