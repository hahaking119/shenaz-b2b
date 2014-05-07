<?php

class CustomCategoryController extends Controller {

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
    public function actionCreate($id = '') {
        $model = new CustomCategory;
        $parentCategories = CustomCategory::model()->findAllByAttributes(array('company_id' => $id, 'parent_id' => 0));
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomCategory'])) {
            $model->attributes = $_POST['CustomCategory'];
            $model->slug = CommonClass::getSlug($model->title);
            if (!empty($_POST['CustomCategory']['subcategory_id'])) {
                $model->parent_id = $_POST['CustomCategory']['subcategory_id'];
            }
            $model->company_id = $id;
            $model->created_at = new CDbExpression('NOW()');
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Added!</strong> The custom category has been added.');
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

        $this->render('create', array(
            'model' => $model,
            'parentCategories' => $parentCategories,
            'id' => $id
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $parentCategories = CustomCategory::model()->findAllByAttributes(array('company_id' => $model->company_id, 'parent_id' => 0));
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomCategory'])) {
            $model->attributes = $_POST['CustomCategory'];
            if (!empty($_POST['CustomCategory']['subcategory_id'])) {
                $model->parent_id = $_POST['CustomCategory']['subcategory_id'];
            }
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Updated!</strong> The custom category has been updated.');
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }
        

        $this->render('update', array(
            'model' => $model,
            'parentCategories' => $parentCategories
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
        $dataProvider = new CActiveDataProvider('CustomCategory');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin($id) {
        $model = new CustomCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomCategory']))
            $model->attributes = $_GET['CustomCategory'];

        $this->render('admin', array(
            'model' => $model,
            'id' => $id
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CustomCategory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CustomCategory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CustomCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'custom-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionlistSubCategories() {
        if (isset($_POST['id'])) {
            echo "<option value=''>--- Select Sub Category ---</option>";
            if ($_POST['id'] != 0) {
                $data = CHtml::listData(CustomCategory::model()->findAllByAttributes(array('parent_id' => (int) $_POST['id'])), 'id', 'title');
                foreach ($data as $value => $name)
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
    }

}
