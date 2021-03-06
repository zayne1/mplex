<?php

class EventController extends Controller
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
				'actions'=>array('index','view','create','update','admin','delete'),
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
		$videoDataProvider=new EMongoDocumentDataProvider('Video');
		$criteria = new EMongoCriteria;
		$criteria->eventId = $id;
		$criteria->sort('label',EMongoCriteria::SORT_ASC);
		$videoDataProvider->setCriteria($criteria);
		$videoDataProvider->setPagination(false);

		$videoUploadModel=new VideoUpload;

		$uploads_model = new Uploads;
		$video = new Video;

		if(isset($_POST['form-VideoUpload']))
		{
			$vidfiles = CUploadedFile::getInstancesByName('VideoUpload');
			Yii::log("CUploadedFile vidfiles var:.........");
			Yii::log( print_r( $vidfiles,true));//die;
			
			// This block will save the vid files to server
			if(isset($vidfiles) && count($vidfiles)> 0) {
				foreach ($vidfiles as $file) {		
					Yii::log("File tempName:.........");
					Yii::log($file->getTempName());
					Yii::log("name ...........");
					Yii::log(print_r($file->getName(),true));
					Yii::log("size ...........");
					Yii::log(print_r($file->getSize(),true));

					$length = Video::model()->getLength($file->getTempName());

					if ( $file->saveAs(Yii::app()->basePath .'/../vid/'.$file->getName()) ) {
						Yii::app()->user->setFlash('videoSavedStatus','Video was successfully saved');
						Yii::log("Saving Success............");

						// Save Mongo Video model fields
						$video = new Video;
						$video->id = 'aaa';//$file->getName();
						$video->file = $file->getName();
						$video->label = 'will get set in model beforesave()'; // Set label to file name on 1st save
						$video->path = 'zz';//$file->getName();
						$video->eventId = (string)$id;
						$video->fav = 0;
						$video->downloaded = 0;
						$video->size = $file->getSize();
						$video->length = $length;

						if($x = $video->save()){
							Yii::log("Video model Saving Success............");
						} else {
							Yii::log("Video model Saving FAIL............");
							Yii::log(print_r($video->getErrors()));
						}



					} else {
						Yii::app()->user->setFlash('videoSavedStatus','Error in uploading');
						Yii::log("in UpLoad error ....");
						print_r($file->getError());
					}
				}
			}

		}

		if(isset($_POST['Video']))
		{
			$video = Video::model()->findByPk(new MongoID($_POST['Video']['videoId']));
			$thumbnailFileName = '';
		
			unset($_POST['Video']['videoId']); // remove this key as it is not in the db & will therefore cause a saving fail
		
			// This block will save the thumb image to server
	        if($video->thumb=CUploadedFile::getInstance($video,'thumb')) {
	        	
	        	$thumbnailFileName = $video->_id .'.'. $video->thumb->getExtensionName();

	            Yii::log("File tempName:.........");
	            Yii::log($video->thumb->getTempName());
	            Yii::log(print_r($video->thumb,true));

	            // if($video->validate()) {
	                Yii::log("validated ...........");
	                Yii::log("name ...........");
	                Yii::log(print_r($video->thumb->getName(),true));
	                Yii::log("size ...........");
	                Yii::log(print_r($video->thumb->getSize(),true));

	                if($video->thumb->saveAs(Yii::app()->basePath .'/../images/videothumbs/'.$thumbnailFileName )) {
	                    Yii::app()->user->setFlash('imageSavedStatus','image was successfully saved');
	                    Yii::log("Saving Success............");

	                } else {
	                    Yii::app()->user->setFlash('imageSavedStatus','Error in uploading');
	                    Yii::log("in UpLoad error ....");
	                    print_r($video->thumb->getError());
	                }
	        }
	        if ($video->thumb){
	        	Yii::log('_________vid thumb1');
	        }

	        $video->thumb=$thumbnailFileName;

			if($video->update(array('thumb'),true)) {
				// $this->redirect(array('view','id'=>$video->_id));
				Yii::app()->request->redirect( Yii::app()->request->getUrlReferrer() );
			} else {
				Yii::log('_________Error saving video thumb');
			}
		}

		//Clear the user's session
        Yii::app()->user->setState('files', null);
        Yii::app()->user->setState('eventIdForCurUpload', $id);

		Yii::import("xupload.models.XUploadForm");
		$xupload_form_model = new XUploadForm;
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'video'=> $video,
			'videoDataProvider' => $videoDataProvider,
			'videoUploadModel' => $videoUploadModel,
			'uploads_model'=>$uploads_model,
            'xupload_form_model'=>$xupload_form_model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Event;
		$OrganizationList = Organization::model()->getAllOrgs();
		
		// Convert MongoObject _id's in the List to strings for the form dropdown
		foreach ($OrganizationList as $key => $org) {
			$OrganizationList[$key]['_id'] = (string)$org->_id;
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// $model=new VideoUpload;
	
		

		// This block will save the logo image to server
		if(isset($_POST['Event']))
		{
	        if($model->logo=CUploadedFile::getInstance($model,'logo')) {
	            Yii::log("File tempName:.........");
	            Yii::log($model->logo->getTempName());
	            Yii::log(print_r($model->logo,true));

	            // if($model->validate()) {
	                Yii::log("validated ...........");
	                Yii::log("name ...........");
	                Yii::log(print_r($model->logo->getName(),true));
	                Yii::log("size ...........");
	                Yii::log(print_r($model->logo->getSize(),true));

	                if($model->logo->saveAs(Yii::app()->basePath .'/../images/'.$model->logo->getName())) {
	                    Yii::app()->user->setFlash('imageSavedStatus','image was successfully saved');
	                    Yii::log("Saving Success............");

	                } else {
	                    Yii::app()->user->setFlash('imageSavedStatus','Error in uploading');
	                    Yii::log("in UpLoad error ....");
	                    print_r($model->logo->getError());
	                }
	        }

	        // here we save the model
			$_POST['Event']['logo'] = $model->logo->getName(); // Force set the file name
			$model->attributes=$_POST['Event'];
			if($model->save()) {
				// $this->redirect(array('view','id'=>$model->_id));
				$this->redirect(array('view','id'=>$model->_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'OrganizationList' => $OrganizationList,
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
		$OrganizationList = Organization::model()->getAllOrgs();
		$videoUploadModel=new VideoUpload;

		// Convert MongoObject _id's in the List to strings for the form dropdown
		foreach ($OrganizationList as $key => $org) {
			$OrganizationList[$key]['_id'] = (string)$org->_id;
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Event']))
		{
			// This block will save the logo image to server
	        if($model->logo=CUploadedFile::getInstance($model,'logo')) {
	            Yii::log("File tempName:.........");
	            Yii::log($model->logo->getTempName());
	            Yii::log(print_r($model->logo,true));

	            // if($model->validate()) {
	                Yii::log("validated ...........");
	                Yii::log("name ...........");
	                Yii::log(print_r($model->logo->getName(),true));
	                Yii::log("size ...........");
	                Yii::log(print_r($model->logo->getSize(),true));

	                if($model->logo->saveAs(Yii::app()->basePath .'/../images/'.$model->logo->getName())) {
	                    Yii::app()->user->setFlash('imageSavedStatus','image was successfully saved');
	                    Yii::log("Saving Success............");

	                } else {
	                    Yii::app()->user->setFlash('imageSavedStatus','Error in uploading');
	                    Yii::log("in UpLoad error ....");
	                    print_r($model->logo->getError());
	                }
	        }
	        if ($model->logo)
	        	$_POST['Event']['logo'] = $model->logo->getName(); // Force set the file name

			$model->attributes=$_POST['Event'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
		}

		$this->render('update',array(
			'model'=>$model,
			'OrganizationList'=>$OrganizationList,
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
		$dataProvider=new EMongoDocumentDataProvider('Event');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Event('search');
		$model->unsetAttributes();

		if(isset($_GET['Event']))
			$model->setAttributes($_GET['Event']);

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
		$model=Event::model()->findByPk(new MongoId($id));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
