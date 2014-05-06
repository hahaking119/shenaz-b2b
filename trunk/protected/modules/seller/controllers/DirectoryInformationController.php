<?php

class DirectoryInformationController extends Controller
{
    public $layout = "//layouts/column2";
    
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'admin', 'update', 'add_directory_company_info', 'upload', 'remove_image', 'updatestatus'),
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
    
    public function actionIndex()
    {
            $this->render('index');
    }

    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
            // return the filter configuration for this controller, e.g.:
            return array(
                    'inlineFilterName',
                    array(
                            'class'=>'path.to.FilterClass',
                            'propertyName'=>'propertyValue',
                    ),
            );
    }

    public function actions()
    {
            // return external action classes, e.g.:
            return array(
                    'action1'=>'path.to.ActionClass',
                    'action2'=>array(
                            'class'=>'path.to.AnotherActionClass',
                            'propertyName'=>'propertyValue',
                    ),
            );
    }
    */
    
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'member-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAdd_directory_company_info($id = '') {
        $id = Yii::app()->user->getId();

        $companyInformation = CompanyInformation::model()->findByAttributes(array('member_id' => $id));
        if (!isset($companyInformation)) {
            $companyInformation = new CompanyInformation;
            $companyInformation->member_id = $id;
        }

        $model = DirectoryInformation::model()->findByAttributes(array('company_id' => $companyInformation->company_id));
        if (empty($model))
            $model = new DirectoryInformation;

        $this->performAjaxValidation(array($model, $companyInformation));

        if (isset($_POST['CompanyInformation'])) {
            if (Yii::app()->request->isAjaxRequest)
                Yii::app()->end();

            $prev_logo = $companyInformation->logo;
            $prev_banner = $companyInformation->banner_image;

            $companyInformation->attributes = $_POST['CompanyInformation'];

            if(!empty($prev_logo) && $prev_logo !== $companyInformation->logo && !empty($companyInformation->logo)){
                $logoPath = Yii::app()->basePath.'/../uploads/company/logo/';
                if(file_exists($logoPath.'thumbs/'.$prev_logo))
                    unlink ($logoPath.'thumbs/'.$prev_logo);
                if(file_exists($logoPath.'original/'.$prev_logo))
                    unlink ($logoPath.'original/'.$prev_logo);
            }
            if(!empty($prev_banner) && $prev_banner !== $companyInformation->banner_image){
                $bannerPath = Yii::app()->basePath.'/../uploads/company/banner/';
                if(file_exists($bannerPath.'thumbs/'.$prev_banner))
                    unlink ($bannerPath.'thumbs/'.$prev_banner);
                if(file_exists($bannerPath.'original/'.$prev_banner))
                    unlink ($bannerPath.'original/'.$prev_banner);
            }
            if($companyInformation->isNewRecord)
                $companyInformation->created_at = new CDbExpression('NOW()');

            $companyInformation->modified_at = new CDbExpression('NOW()');
            if ($companyInformation->save()) {
                $tempdir = Yii::app()->basePath . '/../uploads/temp/';
                $realdir = Yii::app()->basePath . '/../uploads/company/';
                $image = $companyInformation->logo;

                @copy($tempdir . 'original/' . $image, $realdir . 'logo/original/' . $image);
                @copy($tempdir . 'thumbs/' . $image, $realdir . 'logo/thumbs/' . $image);
                @unlink($tempdir . 'original/' . $image);
                @unlink($tempdir . 'thumbs/' . $image);
                $banner = $companyInformation->banner_image;

                @copy($tempdir . 'original/' . $banner, $realdir . 'banner/original/' . $banner);
                @copy($tempdir . 'thumbs/' . $banner, $realdir . 'banner/thumbs/' . $banner);
                @unlink($tempdir . 'original/' . $banner);
                @unlink($tempdir . 'thumbs/' . $banner);

                if (isset($_POST['DirectoryInformation'])) {
                    $prev_image = $model->image;

                    $model->attributes = $_POST['DirectoryInformation'];

                    if(!empty($prev_image) && $prev_image !== $model->image){
                        $imagePath = Yii::app()->basePath.'/../uploads/directory/image/';
                        if(file_exists($imagePath.'thumbs/'.$prev_image))
                            unlink ($imagePath.'thumbs/'.$prev_image);
                        if(file_exists($imagePath.'original/'.$prev_image))
                            unlink ($imagePath.'original/'.$prev_image);
                    }

                    $model->company_id = $companyInformation->company_id;

                    if($model->isNewRecord)
                        $model->created_at = new CDbExpression('NOW()');

                    $model->modified_at = new CDbExpression('NOW()');

                    if ($model->save()) {
                        $tempdir = Yii::app()->basePath . '/../uploads/temp/';
                        $realdir = Yii::app()->basePath . '/../uploads/directory/';
                        $image = $model->image;

                        @copy($tempdir . 'original/' . $image, $realdir . 'image/original/' . $image);
                        @copy($tempdir . 'thumbs/' . $image, $realdir . 'image/thumbs/' . $image);
                        @unlink($tempdir . 'original/' . $image);
                        @unlink($tempdir . 'thumbs/' . $image);
                    } else {
                        print_r($model->getErrors());
                        die();
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Updated!</strong> The directory informaton has been updated.');
                $this->redirect(array('login/dashboard'));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

            $this->render('add_company_and_directory_info', array('model' => $model, 'companyInformation' => $companyInformation));
    }
    
    public function actionRemove_image() {
        if (Yii::app()->request->isAjaxRequest) {
            $image = $_POST['image'];
            $id = $_POST['id'];

            $tempdir = Yii::app()->basePath . '/../uploads/temp/';
            $realdir = Yii::app()->basePath . '/../uploads/company/';

            $realdir2 = Yii::app()->basePath . '/../uploads/category/';

            $directory_dir = Yii::app()->basePath . '/../uploads/directory/';

            if (file_exists($tempdir . 'original/' . $image))
                @unlink($tempdir . 'original/' . $image);
            if (file_exists($tempdir . 'thumbs/' . $image))
                @unlink($tempdir . 'thumbs/' . $image);
            if (file_exists($realdir . 'logo/original/' . $image))
                @unlink($realdir . 'logo/original/' . $image);
            if (file_exists($realdir . 'logo/thumbs/' . $image)) {
                $company = CompanyInformation::model()->findByPk($id);
                $company->logo = "";
                $company->modified_at = new CDbExpression('NOW()');
                if ($company->update())
                    @unlink($realdir . 'thumbs/' . $image);
            }
            if (file_exists($realdir . 'banner/original/' . $image))
                @unlink($realdir . 'banner/original/' . $image);
            if (file_exists($realdir . 'banner/thumbs/' . $image)) {
                $company = CompanyInformation::model()->findByPk($id);
                $company->banner_image = "";
                $company->modified_at = new CDbExpression('NOW()');
                if ($company->save())
                    @unlink($realdir . 'banner/thumbs/' . $image);
            }
            if (file_exists($realdir2 . 'banner/thumbs/' . $image)) {
                $banner = CategoryBanner::model()->findByAttributes(array('id' => $id));
                if ($banner->delete())
                    @unlink($realdir2 . 'banner/thumbs/' . $image);
            }
            if (file_exists($realdir2 . 'banner/original/' . $image))
                @unlink($realdir2 . 'banner/original/' . $image);

            if (file_exists($realdir2 . 'image/thumbs/' . $image)) {
                $category = Category::model()->findByAttributes(array('category_id' => $id));
                $category->image = "";
                $category->modified_at = new CDbExpression('NOW()');
                if ($category->save())
                    @unlink($realdir2 . 'image/thumbs/' . $image);
            }
            if (file_exists($realdir2 . 'image/original/' . $image))
                @unlink($realdir2 . 'image/original/' . $image);
            if (file_exists($directory_dir . 'image/original/' . $image))
                @unlink($directory_dir . 'image/original/' . $image);
            if (file_exists($directory_dir . 'image/thumbs/' . $image)) {
                $directory = DirectoryInformation::model()->model()->findByPk($id);
                $directory->image = "";
                $directory->modified_at = new CDbExpression('NOW()');
                if ($directory->save())
                    @unlink($directory_dir . 'image/thumbs/' . $image);
            }
            echo 'success';
        }
    }
}