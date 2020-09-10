<?php

class VideoController extends Controller
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
			// array('allow',  // allow all users to perform 'index' and 'view' actions
			// 	'actions'=>array('index','view'),
			// 	'users'=>array('*'),
			// ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','upload'),
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
		$model=new Video;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Video']))
		{
			$model->attributes=$_POST['Video'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		Yii::app()->user->setState('userEvent', Yii::app()->request->getParam('id', null));

		$model=$this->loadModel($id);
		$videoUploadModel=new VideoUpload;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Video']))
		{
			$model->attributes=$_POST['Video'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
		}

		$this->render('update',array(
			'model'=>$model,
			'videoUploadModel'=>$videoUploadModel,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new EMongoDocumentDataProvider('Video');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Video('search');
		$model->unsetAttributes();

		if(isset($_GET['Video']))
			$model->setAttributes($_GET['Video']);

		$this->render('admin', array(
			'model'=>$model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Video::model()->findByPk(new MongoId($id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='video-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
/*
	public function actionUpload()
	{
		$model=new VideoUpload;
	// Yii::log( print_r( $_POST,true));
	Yii::log("_FILES var:.........");
	Yii::log( print_r( $_FILES,true));

	Yii::log("CUploadedFile files var:.........");
	$files = CUploadedFile::getInstancesByName('VideoUpload');
	Yii::log( print_r( $files,true));die;

		if(isset($_POST['VideoUpload'])) {
			$model->attributes=$_POST['VideoUpload'];

			if($model->file=CUploadedFile::getInstance($model,'file')) {
				Yii::log("File tempName:.........");
				Yii::log($model->file->getTempName());
				Yii::log(print_r($model->file,true));

				if($model->validate()) {
					Yii::log("validated ...........");
					Yii::log("name ...........");
					Yii::log(print_r($model->file->getName(),true));
					Yii::log("size ...........");
					Yii::log(print_r($model->file->getSize(),true));

					if($model->file->saveAs(Yii::app()->basePath .'/../vid/'.$model->file->getName())) {
						Yii::app()->user->setFlash('videoSavedStatus','Video was successfully saved');
						Yii::log("Saving Success............");

					} else {
						Yii::app()->user->setFlash('videoSavedStatus','Error in uploading');
						Yii::log("in UpLoad error ....");
						print_r($model->file->getError());
					}
				} else {
					Yii::app()->user->setFlash('videoSavedStatus','Validation Error in uploading');
					Yii::log("Did not validate...............");
					Yii::log(print_r($model->getErrors(),true));
				}
			}
		}
		Yii::app()->request->redirect( Yii::app()->request->getUrlReferrer() );
	}*/

	public function actionUpload()
	{
	$model=new VideoUpload;
	
	$files = CUploadedFile::getInstancesByName('VideoUpload');
	Yii::log("CUploadedFile files var:.........");
	Yii::log( print_r( $files,true));//die;
	
	if(isset($files) && count($files)> 0) {
		foreach ($files as $file) {		
			Yii::log("File tempName:.........");
			Yii::log($file->getTempName());
			Yii::log("name ...........");
			Yii::log(print_r($file->getName(),true));
			Yii::log("size ...........");
			Yii::log(print_r($file->getSize(),true));

			if ( $file->saveAs(Yii::app()->basePath .'/../vid/'.$file->getName()) ) {
				Yii::app()->user->setFlash('videoSavedStatus','Video was successfully saved');
				Yii::log("Saving Success............");

				// Save Mongo Video model fields
				Video::model()->saveMetaData(
					Yii::app()->user->getState('userEvent'),
					$file->getName(),
					'new path'
				);

			} else {
				Yii::app()->user->setFlash('videoSavedStatus','Error in uploading');
				Yii::log("in UpLoad error ....");
				print_r($file->getError());
			}
		}
	}
	Yii::app()->request->redirect( Yii::app()->request->getUrlReferrer() );
	}
}
