<?php

class MemberController extends Controller {

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
        $model = new Member('register');
        $subscriber = new NewsletterSubscriber();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Member'])) {
            $model->attributes = $_POST['Member'];
            $model->activation_key = CommonClass::getKey();
            $model->membership_id = 1;
            $model->created_at = new CDbExpression('NOW()');
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                if (isset($_POST['NewsletterSubscriber'])) {
                    if ($_POST['NewsletterSubscriber']['id'] == 1) {
                        $subscriber = new NewsletterSubscriber();
                        $subscriber->member_id = $model->member_id;
                        $subscriber->email = $model->email;
                        $subscriber->save();
                    }
                }

                /*
                 * Creates the default member setting.
                 */
                $memberSetting = new MemberSetting();
                $memberSetting->member_id = $model->member_id;
                $memberSetting->membership_id = 1;
                $memberSetting->created_at = new CDbExpression('NOW()');
                $memberSetting->modified_at = new cdbexpression('NOW()');
                if(!$memberSetting->save()){
                    echo '<pre>';
                    print_r($memberSetting->getErrors());
                    die();
                }
                Yii::app()->user->setFlash('success', '<strong>Success!</strong> New member has been added.');
                $this->redirect(array('view', 'id' => $model->member_id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

        $this->render('create', array(
            'model' => $model,
            'subscriber' => $subscriber
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->db_password_text = $model->password_text;
        $subscriber = NewsletterSubscriber::model()->findByAttributes(array('member_id' => $id));
        if (!$subscriber) {
            $subscriber = new NewsletterSubscriber();
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Member'])) {
            $model->attributes = $_POST['Member'];
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                if (isset($_POST['NewsletterSubscriber'])) {
                    if ($_POST['NewsletterSubscriber']['id'] == 1) {
                        $subscriber = NewsletterSubscriber::model()->findByAttributes(array('member_id' => $model->member_id));
                        if (!$subscriber) {
                            $subscriber = new NewsletterSubscriber();
                            $subscriber->member_id = $model->member_id;
                            $subscriber->email = $model->email;
                            $subscriber->save();
                        }
                    } else {
                        $subscriber->delete($subscriber->id);
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Added!</strong> A member has been added.');
                $this->redirect(array('view', 'id' => $model->member_id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

        $this->render('update', array(
            'model' => $model,
            'subscriber' => $subscriber
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
        $dataProvider = new CActiveDataProvider('Member');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = "//layouts/column2";
        $model = new Member('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Member']))
            $model->attributes = $_GET['Member'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Member the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Member::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Member $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'member-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAdd_directory_company_info($id = '') {
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

            if (!empty($prev_logo) && $prev_logo !== $companyInformation->logo && !empty($companyInformation->logo)) {
                $logoPath = Yii::app()->basePath . '/../uploads/company/logo/';
                if (file_exists($logoPath . 'thumbs/' . $prev_logo))
                    unlink($logoPath . 'thumbs/' . $prev_logo);
                if (file_exists($logoPath . 'original/' . $prev_logo))
                    unlink($logoPath . 'original/' . $prev_logo);
            }
            if (!empty($prev_banner) && $prev_banner !== $companyInformation->banner_image) {
                $bannerPath = Yii::app()->basePath . '/../uploads/company/banner/';
                if (file_exists($bannerPath . 'thumbs/' . $prev_banner))
                    unlink($bannerPath . 'thumbs/' . $prev_banner);
                if (file_exists($bannerPath . 'original/' . $prev_banner))
                    unlink($bannerPath . 'original/' . $prev_banner);
            }
            if ($companyInformation->isNewRecord)
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

                    if (!empty($prev_image) && $prev_image !== $model->image) {
                        $imagePath = Yii::app()->basePath . '/../uploads/directory/image/';
                        if (file_exists($imagePath . 'thumbs/' . $prev_image))
                            unlink($imagePath . 'thumbs/' . $prev_image);
                        if (file_exists($imagePath . 'original/' . $prev_image))
                            unlink($imagePath . 'original/' . $prev_image);
                    }

                    $model->company_id = $companyInformation->company_id;

                    if ($model->isNewRecord)
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
                $this->redirect(array('admin'));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }

        $this->render('add_company_and_directory_info', array('model' => $model, 'companyInformation' => $companyInformation));
    }

    public function actionUpload($type) {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder = Yii::app()->basePath . '/../uploads/temp/original/'; // folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "gif", "png"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 2 * 1024 * 1024; // maximum file size in bytes
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

    public function actionUpdateStatus($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['status'])) {
            $model->status = $_POST['status'];
            $model->password = $model->password_text;
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save())
                echo 'success';
            Yii::app()->end();
        }
    }

    public function actiontrash($id) {
        $model = $this->loadModel($id);
        $model->trash = 1;
        $model->password = $model->password_text;
        $model->modified_at = new CDbExpression('NOW()');
        $model->trashed_at = new CDbExpression('NOW()');
        if ($model->save()) {
            Yii::app()->user->setFlash('success', '<strong>Trashed!</strong> The member information has been trashed.');
        } else {
            Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
        }
        $this->redirect(array('admin'));
    }

    public function actionSetting($id) {
        $this->layout = '//layouts/column2';
        $model = MemberSetting::model()->findByAttributes(array('member_id' => $id));
        if (!$model) {
            $model = new MemberSetting;
        }
        $membership = Membership::model()->findAllByAttributes(array('status' => 1, 'trash' => 0));
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'setting-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['MemberSetting'])) {
            $model->attributes = $_POST['MemberSetting'];
            $model->member_id = $id;
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Updated!</strong> The setting has been updated.');
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
        }
        $this->render('_setting', array('model' => $model, 'membership' => $membership));
    }

    public function actionCustom_category($id = '') {
        $model = new CustomCategory;
        $customCategory = CustomCategory::model()->findAllByAttributes(array('company_id' => $id, 'parent_id' => 0));
        if (!$customCategory) {
            $customCategory = array();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'custom-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['CustomCategory']) && !empty($_POST['CustomCategory']['title'])) {
            $model->attributes = $_POST['CustomCategory'];
            $model->company_id = $id;
            $model->slug = CommonClass::getSlug($model->title);
            $model->created_at = new CDbExpression('NOW()');
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Added!</strong> The new category has been added.');
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
            $this->redirect(Yii::app()->createAbsoluteUrl('admin/member/custom_category/id/' . $id));
        }
        $this->render('_custom_category', array('model' => $model, 'customCategory' => $customCategory));
    }

    public function actionupdate_custom_category($id) {
        $model = CustomCategory::model()->findByPk($id);
        $customCategory = CustomCategory::model()->findAll('company_id = ' . $model->company_id . ' and parent_id = 0 and id != ' . $id);
        if (!$customCategory) {
            $customCategory = array();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'custom-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['CustomCategory']) && !empty($_POST['CustomCategory']['title'])) {
            $model->attributes = $_POST['CustomCategory'];
            $model->slug = CommonClass::getSlug($model->title);
            $model->modified_at = new CDbExpression('NOW()');
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Updated!</strong> The category has been updated.');
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error!</strong> An error has occured.');
            }
            $this->redirect(Yii::app()->createAbsoluteUrl('admin/member/custom_category/id/' . $model->company_id));
        }
        $this->render('_custom_category_form', array('model' => $model, 'customCategory' => $customCategory));
    }

}
