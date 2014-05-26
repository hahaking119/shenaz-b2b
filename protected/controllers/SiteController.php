<?php

class SiteController extends Controller {

    public $_id;

    public function init() {

        parent::init();
        if (Yii::app()->user->isGuest)
            Yii::app()->theme = 'default';
        else {
//            Yii::app()->theme = 'classic';
            Yii::app()->theme = 'default';
        }
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public $layout = '//layouts/column2';

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $recentProducts = Product::model()->findAll(array('order' => 'product_id DESC', 'limit' => 5));
//        $allProducts = Product::model()->findAll('status = 1 and trash = 0', array('order' => 'name ASC'));
        $dataProvider = new CActiveDataProvider('Product', array(
                    'criteria' => array(
                        'condition' => 'status=1 and trash=0',
//                        'condition' => 'category_id=' . $category->category_id,
                        'order' => 'product_id DESC'
                    ),
                    'pagination' => array(
                        'pageSize' => 12,
                    ),
                ));
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index', array(
            'recentProducts' => $recentProducts,
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout(false);
        unset(Yii::app()->session['shopping_list']);
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionmenu($view) {
        $category = Category::model()->findByAttributes(array('slug' => $view));
        if ($category->parent_id == 0) {
            $child_categories = Category::model()->findAllByAttributes(array('parent_id' => $category->category_id, 'status' => 1, 'trash' => 0));
            if (!$child_categories) {
                $category_id[] = $category->category_id;
            } else {
                foreach ($child_categories as $child_category) {
                    $category_id[] = $child_category->category_id;
                    $sub_categories = Category::model()->findAllByAttributes(array('parent_id' => $child_category->category_id, 'status' => 1, 'trash' => 0));
                    if (is_array($sub_categories)) {
                        foreach ($sub_categories as $sub_category) {
                            $category_id[] = $sub_category->category_id;
                        }
                    }
                }
            }
            $banners = CategoryBanner::model()->findAllByAttributes(array('category_id' => $category->category_id));
        } else {
            $category_id[] = $category->category_id;
            $child_categories = Category::model()->findAllByAttributes(array('parent_id' => $category->category_id, 'status' => 1, 'trash' => 0));
            foreach ($child_categories as $child_category) {
                $category_id[] = $child_category->category_id;
            }
            $banners = array();
        }
        $crietria = new CDbCriteria();
        $crietria->addInCondition('category_id', $category_id);
        $crietria->order = 'product_id DESC';
        $products = ProductCategory::model()->findAll($crietria);
        $dataProvider = new CArrayDataProvider($products, array(
                    'pagination' => array(
                        'pageSize' => 12,
                    ),
                ));
        $this->render('view', array('dataProvider' => $dataProvider, 'banners' => $banners));
    }

    public function actionproduct($view) {
        $product = Product::model()->findByAttributes(array('slug' => $view));
        $companyInformation = CompanyInformation::model()->findByPk($product->company_id);
        $directoryInformation = DirectoryInformation::model()->findByAttributes(array('company_id' => $companyInformation->company_id));
        $images = ProductImage::model()->findAllByAttributes(array('product_id' => $product->product_id));
        $allFeedbacks = Feedback::model()->findAll('product_id =' . $product->product_id . ' and status = 1 and trash = 0', array('id ASC'));
        $feedback = new Feedback;
        $feedback->product_id = $product->product_id;
        $feedback->company_id = $companyInformation->company_id;
        if (!Yii::app()->user->isGuest) {
            $member_id = UserIdentity::getId();
            $rating = Rating::model()->findAllByAttributes(array('product_id' => $product->product_id));
            if (empty($rating))
                $rating = new Rating;
        }
        else {
            $rating = Rating::model()->findAllByAttributes(array('product_id' => $product->product_id));
            if (empty($rating))
                $rating = new Rating;
        }
        $totalRating = Rating::model()->findAll();
        $this->render('_viewproduct', array(
            'product' => $product,
            'images' => $images,
            'companyInformation' => $companyInformation,
            'directoryInformation' => $directoryInformation,
            'feedback' => $feedback,
            'allFeedbacks' => $allFeedbacks,
            'rating' => $rating,
            'totalRating' => $totalRating
        ));
    }

    public function actionFeedback() {
        $feedback = new Feedback;
        $user_id = UserIdentity::getMemberId();
        if (isset($_POST['Feedback'])) {
            $feedback->attributes = $_POST['Feedback'];
            $feedback->member_id = $user_id;
            $feedback->created_at = new CDbExpression('NOW()');
            $feedback->modified_at = new CDbExpression('NOW()');
            if ($feedback->save()) {
                $result['feedback'] = $feedback->feedback;
                if (!empty($feedback->member->middle_name)) {
                    $full_name = $feedback->member->first_name . " " . $feedback->member->middle_name . " " . $feedback->member->last_name;
                } else {
                    $full_name = $feedback->member->first_name . " " . $feedback->member->last_name;
                }
                $result['member'] = $full_name;
//                $result['created_at'] = $feedback->created_at;
                $result['status'] = "success";
                $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
                echo $return;
            }
        }
    }

    public function actionQuot() {
        $captcha = Yii::app()->getController()->createAction("captcha");
        $code = $captcha->verifyCode;
        if ($code === $_REQUEST['verifyCode']) {
            $model = new Email;
            $model->from = $_POST['email'];
            $model->to = $_POST['to'];
            $model->subject = $_POST['subject'];
            $model->message = $_POST['message'];
            $model->sent = 0;
            if ($model->save()) {
                $result['result'] = 'success';
                $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
                echo $return;
                Yii::app()->end();
            }
        } else {
            $result['result'] = 'incorrectCaptcha';
            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return;
            Yii::app()->end();
        }
    }

    public function actionRate() {
        $product_id = $_POST['product_id'];
        $company_id = $_POST['company_id'];
        $rating = $_POST['rating'];
        $member_id = UserIdentity::getMemberId();
        $rating = Rating::model()->findByAttributes(array('member_id' => $member_id, 'product_id' => $product_id, 'company_id' => $company_id));
        if (empty($rating)) {
            $rating = new Rating;
        }
        $rating->product_id = $_POST['product_id'];
        $rating->company_id = $_POST['company_id'];
        $rating->rating = $_POST['rating'];
        $rating->member_id = UserIdentity::getMemberId();
        if ($rating->save())
            echo 'rated';
    }

    public function actionView_all() {
        $categories = Category::model()->findAll('parent_id = 0 AND status = 1 AND trash = 0');
        $this->render('_listcategories', array('categories' => $categories));
    }

        
        public function actionAdd_to_cart(){
            $cart = Yii::app()->session['shopping_list'];
            if (!is_numeric($_POST['qty']) || $_POST['qty'] <= 0) {
                Yii::app()->user->setFlash('error', '<strong>Illegal quantity given.</strong>');
                echo 'illegal';
                Yii::app()->end();
            }
                foreach ($cart as $key => $value) {
                    if ($value['product_id'] == $_POST['product_id']) {
                        $cart_index = $key;
                    }
                }
                if (isset($cart_index)) {
                    $cart[$cart_index]['qty'] += $_POST['qty'];
                }
                else{
                    $cart[] = $_POST;                    
                }
                Yii::app()->session['shopping_list'] = $cart;
        }
        
        public function actionGetcart(){
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['bootstrap-transition.js'] = false;
            Yii::app()->clientScript->scriptMap['bootstrap-tooltip.js'] = false;
            Yii::app()->clientScript->scriptMap['bootstrap-popover.js'] = false;
            Yii::app()->clientScript->scriptMap['bootstrap-modal.js'] = false;
            Yii::app()->clientScript->scriptMap['bootstrap-alert.js'] = false;
            $this->renderPartial('cart', '', false, true);
        }
}