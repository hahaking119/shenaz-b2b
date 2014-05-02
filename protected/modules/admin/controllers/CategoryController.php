<?php

class CategoryController extends Controller {

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
                'actions' => array('create', 'update', 'upload', 'remove', 'admin'),
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
        $model = new Category;
        $parentCategories = Category::model()->findAll('parent_id = 0',array('order'=>'title ASC'));
        if (!$parentCategories) {
            $parentCategories = new Category;
        }
        $categoryBanner = new CategoryBanner;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Category'])) {
//            echo '<pre>';
//            print_r($_POST);
//            die();
            $model->attributes = $_POST['Category'];
            $model->slug = CommonClass::getSlug($model->title);
            $model->created_at = new CDbExpression('NOW()');
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                if (isset($model->image) && !empty($model->image)) {
                    $tempdir = Yii::app()->basePath . '/../uploads/temp/';
                    $realdir = Yii::app()->basePath . '/../uploads/category/';
                    $image = $model->image;

                    @copy($tempdir . 'original/' . $image, $realdir . 'image/original/' . $image);
                    @copy($tempdir . 'thumbs/' . $image, $realdir . 'image/thumbs/' . $image);
                    @unlink($tempdir . 'original/' . $image);
                    @unlink($tempdir . 'thumbs/' . $image);
                }
                if (isset($_POST['ProductImages'])) {
                    foreach ($_POST['ProductImages']['image'] as $key => $value) {
                        $banner = new CategoryBanner();
                        $banner->category_id = $model->category_id;
                        $banner->banner = $value;
                        $banner->save();

                        $tempdir = Yii::app()->basePath . '/../uploads/temp/';
                        $realdir = Yii::app()->basePath . '/../uploads/category/';
                        $image = $value;

                        @copy($tempdir . 'original/' . $image, $realdir . 'banner/original/' . $image);
                        @copy($tempdir . 'thumbs/' . $image, $realdir . 'banner/thumbs/' . $image);
                        @unlink($tempdir . 'original/' . $image);
                        @unlink($tempdir . 'thumbs/' . $image);
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Created!</strong> New category has been created.');
                $this->redirect(array('view', 'id' => $model->category_id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

        $this->render('create', array(
            'model' => $model,
            'parentCategories' => $parentCategories,
            'categoryBanner' => $categoryBanner
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
//        $parentCategories = Category::model()->findAllByAttributes(array('parent_id' => '0', 'title'!=>$model->title),array('order'=>'title ASC'));
        $parentCategories = Category::model()->findAll(array('condition'=>'parent_id = 0'));
        if (!$parentCategories) {
            $parentCategories = new Category;
        }
        
        $categoryBanner = new CategoryBanner;
        $banners = CategoryBanner::model()->findAllByAttributes(array('category_id'=>$id));

        // Uncomment the following line if AJAX validation is needed
         $this->performAjaxValidation($model);

        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            $model->slug = CommonClass::getSlug($model->title);
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                if (isset($model->image) && !empty($model->image)) {
                    $tempdir = Yii::app()->basePath . '/../uploads/temp/';
                    $realdir = Yii::app()->basePath . '/../uploads/category/';
                    $image = $model->image;

                    @copy($tempdir . 'original/' . $image, $realdir . 'image/original/' . $image);
                    @copy($tempdir . 'thumbs/' . $image, $realdir . 'image/thumbs/' . $image);
                    @unlink($tempdir . 'original/' . $image);
                    @unlink($tempdir . 'thumbs/' . $image);
                }
                if (isset($_POST['ProductImages'])) {
                    foreach ($_POST['ProductImages']['image'] as $key => $value) {
                        $banner = new CategoryBanner();
                        $banner->category_id = $model->category_id;
                        $banner->banner = $value;
                        $banner->save();

                        $tempdir = Yii::app()->basePath . '/../uploads/temp/';
                        $realdir = Yii::app()->basePath . '/../uploads/category/';
                        $image = $value;

                        @copy($tempdir . 'original/' . $image, $realdir . 'banner/original/' . $image);
                        @copy($tempdir . 'thumbs/' . $image, $realdir . 'banner/thumbs/' . $image);
                        @unlink($tempdir . 'original/' . $image);
                        @unlink($tempdir . 'thumbs/' . $image);
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Updated!</strong> Category has been updated.');
                $this->redirect(array('view', 'id' => $model->category_id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

        $this->render('update', array(
            'model' => $model,
            'parentCategories' => $parentCategories,
            'categoryBanner' => $categoryBanner,
            'banners'=>$banners,
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
        $dataProvider = new CActiveDataProvider('Category');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Category('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Category']))
            $model->attributes = $_GET['Category'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Category the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Category::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Category $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpload($type) {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder = Yii::app()->basePath . '/../uploads/temp/original/'; // folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "gif", "png"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        if ($result['success']) {
            $img = Yii::app()->simpleImage->load($folder . $result['filename']);
            $uploadDetail = CommonClass::getImageResizeDetails($type);
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
            $realdir = Yii::app()->basePath . '/../uploads/category/';
            if (file_exists($tempdir . 'original/' . $image))
                @unlink($tempdir . 'original/' . $image);
            if (file_exists($tempdir . 'thumb/' . $image))
                @unlink($tempdir . 'thumb/' . $image);
            if (file_exists($realdir . 'image/original/' . $image))
                @unlink($realdir . 'image/original/' . $image);
            if (file_exists($realdir . 'image/thumbs/' . $image))
                @unlink($realdir . 'image/thumbs/' . $image);
            if (file_exists($realdir . 'banner/original/' . $image))
                @unlink($realdir . 'banner/original/' . $image);
            if (file_exists($realdir . 'banner/thumbs/' . $image))
                @unlink($realdir . 'banner/thumbs/' . $image);
            echo 'success';
        }
    }

}
