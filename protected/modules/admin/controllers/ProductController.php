<?php

class ProductController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column3';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Product;
        $companies = CompanyInformation::model()->findAllByAttributes(array('status' => 1, 'trash' => 0));
        $categories = Category::model()->findAllByAttributes(array('status' => 1, 'trash' => 0));
        $productImages = new ProductImage();
        $productCategory = new ProductCategory();
        $productCustomCategory = new ProductCustomCategory();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Product'])) {
            echo '<pre>';
            print_r($_POST);
            die();
            $model->attributes = $_POST['Product'];
            $model->slug = CommonClass::getSlug($model->title);
            $model->created_at = new CDbExpression('NOW()');
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                if (isset($_POST['ProductCategory']['category_id'])) {
                    foreach ($_POST['ProductCategory']['category_id'] as $key => $value) {
                        $productCategory = new ProductCategory();
                        $productCategory->product_id = $model->product_id;
                        $productCategory->category_id = $value;
                        $productCategory->save();
                    }
                }
                if (isset($_POST['ProductCustomCategory']['custom_category_id'])) {
                    foreach ($_POST['ProductCustomCategory']['custom_category_id'] as $key => $value) {
                        $productCustomCategory = new ProductCustomCategory();
                        $productCustomCategory->product_id = $model->product_id;
                        $productCustomCategory->custom_category_id = $value;
                    }
                }
                if (isset($_POST['ProductImages']['image'])) {
                    foreach ($_POST['ProductImages']['image'] as $key => $value) {
                        $productImage = new ProductImage();
                        $productImage->product_id = $model->id;
                        $productImage->image = $value;
                        $productImage->save();
                        
                        $tempdir = Yii::app()->basePath . '/../uploads/temp/';
                        $realdir = Yii::app()->basePath . '/../uploads/product/';
                        $image = $value;

                        @copy($tempdir . 'original/' . $image, $realdir . 'banner/original/' . $image);
                        @copy($tempdir . 'thumbs/' . $image, $realdir . 'banner/thumbs/' . $image);
                        @unlink($tempdir . 'original/' . $image);
                        @unlink($tempdir . 'thumbs/' . $image);
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Added!</strong> The new product has been added.');
                $this->redirect(array('view', 'id' => $model->product_id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

        $this->render('create', array(
            'model' => $model,
            'companies' => $companies,
            'categories' => $categories,
            'productImages' => $productImages,
            'productCategory' => $productCategory,
            'productCustomCategory' => $productCustomCategory
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->product_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Product');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Product the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Product $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actioncustomCategory() {
        $parents = CustomCategory::model()->findAll('company_id = ' . $_POST['company_id'] . ' and parent_id = 0 and status = 1');
        echo "<option value=''>--- Select Custom Category ---</option>";
        foreach ($parents as $parent) {
            $children = CustomCategory::model()->findAll('company_id =' . $_POST['company_id'] . ' and parent_id = ' . $parent->id . ' and status = 1');
            echo CHtml::tag('option', array('value' => $parent->id), CHtml::encode($parent->title), true);
            foreach ($children as $child) {
                echo CHtml::tag('option', array('value' => $child->id), CHtml::encode('- ' . $child->title), true);
            }
        }
    }

    public function actionUpload() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder = Yii::app()->basePath . '/../uploads/temp/original/'; // folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "gif", "png"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        if ($result['success']) {
            $img = Yii::app()->simpleImage->load($folder . $result['filename']);
            $uploadDetail = CommonClass::getImageResizeDetails('products');
            $function = $uploadDetail["thumbs"]["function"];
            $img->$function($uploadDetail["thumbs"]["width"], $uploadDetail["thumbs"]["height"]);
            $img->save(Yii::app()->basePath . "/../uploads/temp/thumbs/" . $result['filename'], NULL);
            $result['imageThumb'] = Yii::app()->baseUrl . '/uploads/temp/thumbs/' . $result['filename'];
        }

        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        echo $return; // it's array
    }

    public function actionRemove_image() {
        if (Yii::app()->request->isAjaxRequest) {
            $image = $_POST['image'];
            $tempdir = Yii::app()->basePath . '/../uploads/temp/';
            $realdir = Yii::app()->basePath . '/../uploads/product/';
            if (file_exists($tempdir . 'original/' . $image))
                @unlink($tempdir . 'original/' . $image);
            if (file_exists($tempdir . 'thumb/' . $image))
                @unlink($tempdir . 'thumb/' . $image);
            if (file_exists($realdir . 'original/' . $image))
                @unlink($realdir . 'original/' . $image);
            if (file_exists($realdir . 'thumbs/' . $image))
                @unlink($realdir . 'thumbs/' . $image);
            echo 'success';
        }
    }

}
