<?php

class CustomCategoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin', 'updateStatus', 'trash', 'showSubCategory', 'listSubCategories'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CustomCategory;
                $id = Yii::app()->user->getId();
                $company = CompanyInformation::model()->findByAttributes(array('member_id' => $id));
                $model->company_id = $company->company_id;
                
                $parentCategories = Category::model()->findAll('parent_id = 0',array('order'=>'title ASC'));
                if (!$parentCategories) {
                    $parentCategories = array();
                }

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
                 if(Yii::app()->request->isAjaxRequest)
                     Yii::app()->end();

		if(isset($_POST['CustomCategory']))
		{
			$model->attributes=$_POST['CustomCategory'];
                        $model->slug = CommonClass::getSlug($model->title);
                        $model->parent_id = $_POST['CustomCategory']['subcategory_id'];
                        $model->created_at = new CDbExpression('NOW()');
                        $model->modified_at = new CDbExpression('NOW()');
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
                        'parentCategories' => $parentCategories,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                
                $id = Yii::app()->user->getId();
                $company = CompanyInformation::model()->findByAttributes(array('member_id' => $id));
                $model->company_id = $company->company_id;
                
                $parentCategories = Category::model()->findAll('parent_id = 0',array('order'=>'title ASC'));
                if (!$parentCategories) {
                    $parentCategories = array();
                }

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
                 if(Yii::app()->request->isAjaxRequest)
                     Yii::app()->end();

		if(isset($_POST['CustomCategory']))
		{
			$model->attributes=$_POST['CustomCategory'];
                        $model->slug = CommonClass::getSlug($model->title);
                        $model->parent_id = $_POST['CustomCategory']['subcategory_id'];
                        $model->modified_at = new CDbExpression('NOW()');
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
                        'parentCategories' => $parentCategories,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CustomCategory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            $this->layout = '//layouts/column3';
		$model=new CustomCategory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CustomCategory']))
			$model->attributes=$_GET['CustomCategory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CustomCategory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CustomCategory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CustomCategory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='custom-category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionUpdateStatus($id) {
            $model = $this->loadModel($id);
            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
                $model->modified_at = new CDbExpression('NOW()');
                if ($model->save())
                    echo 'success';
                Yii::app()->end();
            }
        }
    
        public function actionTrash($id) {
            $model = $this->loadModel($id);
            $model->trash = 1;
            $model->modified_at = new CDbExpression('NOW()');
            $model->trashed_at = new CDbExpression('NOW()');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Trashed!</strong> The category has been trashed.');
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
            $this->redirect(array('admin'));
        }
        
        public function actionListSubCategories() {
        if (isset($_POST['id'])) {
            echo "<option value=''>--- Select Sub Category ---</option>";
            if ($_POST['id'] != 0) {
                $data = CHtml::listData(Category::model()->findAllByAttributes(array('parent_id' => (int) $_POST['id'])), 'category_id', 'title');
                foreach ($data as $value => $name)
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
    }
}
