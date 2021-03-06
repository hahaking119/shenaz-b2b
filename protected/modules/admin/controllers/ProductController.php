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
                'actions' => array('admin', 'delete', 'listLevel2Categories'),
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
        $categories = Category::model()->findAllByAttributes(array('parent_id' => 0, 'status' => 1, 'trash' => 0));
        $productImages = new ProductImage();
        $productCategory = new ProductCategory();
        $productCustomCategory = new ProductCustomCategory();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Product'])) {
//            echo '<pre>';
//            print_r($_POST);
//            die();
            $model->attributes = $_POST['Product'];
            $model->slug = CommonClass::getSlug($model->name);
            $model->category_id = null;
            $model->custom_category_id = null;
            $model->created_at = new CDbExpression('NOW()');
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                if(!empty($_POST['ProductCategory']['category_id'])){
                            $productCategory->product_id = $model->product_id;
                            $productCategory->category_id = $_POST['ProductCategory']['category_id'];
                            if (!$productCategory->save()) {
                                echo '<pre>';
                                print_r($productCategory->getErrors());
                            }
                        
                        if(!empty($_POST['ProductCategory']['subcategory_id'])){
                            $productCategory->product_id = $model->product_id;
                            $productCategory->category_id = $_POST['ProductCategory']['subcategory_id'];
                            if (!$productCategory->save()) {
                                echo '<pre>';
                                print_r($productCategory->getErrors());
                            }
                        }
                    if (!empty($_POST['ProductCategory']['level2'])) {
                            $productCategory->product_id = $model->product_id;
                            $productCategory->category_id = $_POST['ProductCategory']['level2'];
                            if (!$productCategory->save()) {
                                echo '<pre>';
                                print_r($productCategory->getErrors());
                            }
                        }
                }
                else{
                    $productCategory->product_id = $model->product_id;
                    $productCategory->category_id = "";
                    $productCategory->save();
                }
                
                if (!empty($_POST['ProductCustomCategory']['custom_category_id'])) {
                            $productCustomCategory->product_id = $model->product_id;
                            $productCustomCategory->custom_category_id = $_POST['ProductCustomCategory']['custom_category_id'];
                            if (!$productCustomCategory->save()) {
                                echo '<pre>';
                                print_r($productCustomCategory->getErrors());
                            }
                                        
                    if (!empty($_POST['ProductCustomCategory']['level1'])) {
                            $productCustomCategory->product_id = $model->product_id;
                            $productCustomCategory->custom_category_id = $_POST['ProductCustomCategory']['level1'];
                            if (!$productCustomCategory->save()) {
                                echo '<pre>';
                                print_r($productCustomCategory->getErrors());
                            }
                    }
                    
                    if (!empty($_POST['ProductCustomCategory']['level2'])) {
                            $productCustomCategory->product_id = $model->product_id;
                            $productCustomCategory->custom_category_id = $_POST['ProductCustomCategory']['level2'];
                            if (!$productCustomCategory->save()) {
                                echo '<pre>';
                                print_r($productCustomCategory->getErrors());
                            }
                    }
                }
                else{
                    $productCustomCategory->product_id = $model->product_id;
                    $productCustomCategory->custom_category_id = "";
                    $productCustomCategory->save();
                }
                
                if (isset($_POST['ProductImages']['image'])) {
                    foreach ($_POST['ProductImages']['image'] as $key => $value) {
                        $productImage = new ProductImage();
                        $productImage->product_id = $model->product_id;
                        $productImage->image = $value;
                        $productImage->save();

                        $tempdir = Yii::app()->basePath . '/../uploads/temp/';
                        $realdir = Yii::app()->basePath . '/../uploads/product/';
                        $image = $value;

                        @copy($tempdir . 'original/' . $image, $realdir . 'original/' . $image);
                        @copy($tempdir . 'thumbs/' . $image, $realdir . 'thumbs/' . $image);
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
        $companies = CompanyInformation::model()->findAllByAttributes(array('status' => 1, 'trash' => 0, 'company_id' => $model->company_id));
        $categories = Category::model()->findAllByAttributes(array('parent_id' => 0, 'status' => 1, 'trash' => 0));
        $productImages = new ProductImage();
        $productCategory = ProductCategory::model()->findByAttributes(array('product_id' => $id));
        $productCustomCategory = ProductCustomCategory::model()->findByAttributes(array('product_id' => $id));
        $productCategoryList = ProductCategory::model()->findByAttributes(array('product_id' => $id));
        $productCustomCategoryList = ProductCustomCategory::model()->findAllByAttributes(array('product_id' => $id));
        $productImageLists = ProductImage::model()->findAllByAttributes(array('product_id' => $id));

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Product'])) {
//            echo '<pre>';
//            print_r($_POST);
//            die();
            $model->attributes = $_POST['Product'];
            $model->slug = CommonClass::getSlug($model->name);
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                if(!empty($_POST['ProductCategory']['category_id'])){
                            $productCategory->product_id = $model->product_id;
                            $productCategory->category_id = $_POST['ProductCategory']['category_id'];
                            if (!$productCategory->save()) {
                                echo '<pre>';
                                print_r($productCategory->getErrors());
                            }
                        
                        if(!empty($_POST['ProductCategory']['subcategory_id'])){
                            $productCategory->product_id = $model->product_id;
                            $productCategory->category_id = $_POST['ProductCategory']['subcategory_id'];
                            if (!$productCategory->save()) {
                                echo '<pre>';
                                print_r($productCategory->getErrors());
                            }
                        }
                    if (!empty($_POST['ProductCategory']['level2'])) {
                            $productCategory->product_id = $model->product_id;
                            $productCategory->category_id = $_POST['ProductCategory']['level2'];
                            if (!$productCategory->save()) {
                                echo '<pre>';
                                print_r($productCategory->getErrors());
                            }
                        }
                }
                else
                {
                    $productCategory->product_id = $model->product_id;
                    $productCategory->category_id = "";
                    $productCategory->save();
                }
                
                if (!empty($_POST['ProductCustomCategory']['custom_category_id'])) {
                            $productCustomCategory->product_id = $model->product_id;
                            $productCustomCategory->custom_category_id = $_POST['ProductCustomCategory']['custom_category_id'];
                            if (!$productCustomCategory->save()) {
                                echo '<pre>';
                                print_r($productCustomCategory->getErrors());
                            }
                    
                    
                    if (!empty($_POST['ProductCustomCategory']['level1'])) {
                            $productCustomCategory->product_id = $model->product_id;
                            $productCustomCategory->custom_category_id = $_POST['ProductCustomCategory']['level1'];
                            if (!$productCustomCategory->save()) {
                                echo '<pre>';
                                print_r($productCustomCategory->getErrors());
                            }
                    }
                    
                    if (!empty($_POST['ProductCustomCategory']['level2'])) {
                            $productCustomCategory->product_id = $model->product_id;
                            $productCustomCategory->custom_category_id = $_POST['ProductCustomCategory']['level2'];
                            if (!$productCustomCategory->save()) {
                                echo '<pre>';
                                print_r($productCustomCategory->getErrors());
                            }
                    }
                }
                else{
                    $productCustomCategory->product_id = $model->product_id;
                    $productCustomCategory->custom_category_id = "";
                    $productCustomCategory->save();
                }
                if (isset($_POST['ProductImages']['image'])) {
                    foreach ($productImageLists as $image) {

                        if (!in_array($image->image, $_POST['ProductImages']['image'])) {
                            $image->delete($image->id);
                        }
                    }
                    foreach ($_POST['ProductImages']['image'] as $key => $value) {
                        $productImage = ProductImage::model()->findByAttributes(array('image' => $value));
                        if (!$productImage) {
                            $productImage = new ProductImage();
                            $productImage->product_id = $model->product_id;
                            $productImage->image = $value;
                            $productImage->save();

                            $tempdir = Yii::app()->basePath . '/../uploads/temp/';
                            $realdir = Yii::app()->basePath . '/../uploads/product/';
                            $image = $value;

                            @copy($tempdir . 'original/' . $image, $realdir . 'original/' . $image);
                            @copy($tempdir . 'thumbs/' . $image, $realdir . 'thumbs/' . $image);
                            @unlink($tempdir . 'original/' . $image);
                            @unlink($tempdir . 'thumbs/' . $image);
                        }
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Updated!</strong> The product has been updated.');
                $this->redirect(array('view', 'id' => $model->product_id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

        $this->render('update', array(
            'model' => $model,
            'companies' => $companies,
            'categories' => $categories,
            'productImages' => $productImages,
            'productCategory' => $productCategory,
            'productCustomCategory' => $productCustomCategory,
            'productCategoryList' => $productCategoryList,
            'productCustomCategoryList' => $productCustomCategoryList,
            'productImageLists' => $productImageLists
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

    public function actionTrash($id) {
        $model = $this->loadModel($id);
        $model->trash = 1;
        $model->modified_at = new CDbExpression('NOW()');
        $model->trashed_at = new CDbExpression('NOW()');
        if ($model->save()) {
            Yii::app()->user->setFlash('success', '<strong>Trashed!</strong> The product has been trashed.');
        } else {
            Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
        }
        $this->redirect(array('admin'));
    }
    
    public function actioncustomCategory() {
        $parents = CustomCategory::model()->findAll('company_id = ' . $_POST['company_id'] . ' and parent_id = 0 and status = 1 AND trash = 0');
        echo "<option value=''>--- Select Custom Category ---</option>";
        foreach ($parents as $parent) {
            echo CHtml::tag('option', array('value' => $parent->id), CHtml::encode($parent->title), true);
        }
    }

    public function actionsubCategoryList() {
        if (isset($_POST['parent_id']) && !empty($_POST['parent_id'])) {
            echo "<option value=''>--- Select Sub Category ---</option>";
            if ($_POST['parent_id'] != 0) {
                $data = CHtml::listData(Category::model()->findAllByAttributes(array('parent_id' => (int) $_POST['parent_id'])), 'category_id', 'title');
                foreach ($data as $value => $name)
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
        else{
            echo "<option value=''>--- Select Sub Category ---</option>";
        }
    }
    
    public function actionListLevel2Categories(){
        if(isset($_POST['id']) && !empty($_POST['id'])){
            echo "<option value=''>--- Select Level 2 Category ---</option>";
            $data = CHtml::listData(Category::model()->findAllByAttributes(array('parent_id' => $_POST['id'], 'status' => 1, 'trash' => 0)), 'category_id', 'title');
            foreach ($data as $value => $name)
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        else{
            echo "<option value=''>--- Select Level 2 Category ---</option>";
        }
    }
    
    public function actionListLevel1CustomCategories(){
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            echo "<option value=''>Select Level 1 Custom Category</option>";
            $data = CHtml::listData(CustomCategory::model()->findAllByAttributes(array('parent_id' => $_POST['id'], 'status' => 1, 'trash' => 0)), 'id', 'title');
            foreach ($data as $value => $name)
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        else{
            echo "<option value=''>Select Level 1 Custom Category</option>";
        }
    }
    
    public function actionListLevel2CustomCategories(){
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            echo "<option value=''>Select Level 2 Custom Category</option>";
            $data = CHtml::listData(CustomCategory::model()->findAllByAttributes(array('parent_id' => $_POST['id'], 'status' => 1, 'trash' => 0)), 'id', 'title');
            foreach ($data as $value => $name)
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        else{
            echo "<option value=''>Select Level 2 Custom Category</option>";
        }
    }
}
