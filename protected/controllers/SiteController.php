<?php

class SiteController extends Controller
{
	public function init() {
        parent::init();
    }
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		$OrganizationList = Organization::model()->getAllOrgs();

		$this->render('index', array(
                'introText' => 'Welcome',
                'introSubText' => 'Please select your organization',
                'OrgList' => $OrganizationList
            )
        );
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionEvent()
	{
		// $u=Yii::app()->request->getParam('u', null);
		$orgId=Yii::app()->request->getParam('org', null);

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		/*if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				// $this->redirect(Yii::app()->user->returnUrl);
				$this->redirect(Yii::app()->baseUrl . '/video?u='.$u);
		}*/

		if(isset($_POST['LoginForm']))
		{
			$eventId = Yii::app()->request->getParam('eventId', null);

			// print_r(Event::model()->validatePass($_POST['LoginForm']['password'], $eventId));die;

			if (Event::model()->validatePass($_POST['LoginForm']['password'], $eventId)) {
				Yii::app()->user->setState('userEvent', $eventId);
				$this->redirect(Yii::app()->baseUrl . '/video');
			}
			else
				$this->redirect(Yii::app()->baseUrl . '/');
		}

		
		// display the login form
		//$this->render('login',array('model'=>$model));

		$EventList = Event::model()->getEventsForOrg($orgId);
		// print_r($EventList);die;
		// ->test2[0]->property1;


		$this->render('event', array(
                'introText' => 'Events',
                'introSubText' => 'Please select your show',
                'model'=>$model,
                'EventList'=>$EventList,                
            )
        );
	}

	public function actionVideo()
	{
		$eventId = Yii::app()->user->getState('userEvent');
		$newFavVidId = Yii::app()->request->getParam('addFav', null);
		$newRemVidId = Yii::app()->request->getParam('remFav', null);

		if(isset($newFavVidId)) {
			if (Video::model()->addFav($newFavVidId)){
				$this->redirect(Yii::app()->baseUrl . '/video');
			}
		} elseif (isset($newRemVidId)) {
			if (Video::model()->remFav($newRemVidId)){
				$this->redirect(Yii::app()->baseUrl . '/video');
			}
		}

		$vidList = Video::model()->getVidsForEvent($eventId);
		// print_r($vidList);die;

		$this->render('video', array(
                'introText' => 'Watch Video',
                'introSubText' => '',
                'vidList' => $vidList,
            )
        );
	}

	public function actionDownloads()
	{
		$eventId = Yii::app()->user->getState('userEvent');

		$this->render('downloads', array(
                'introText' => 'Download',
                'introSubText' => 'Download videos to share',
                // 'username' => Yii::app()->user->username,
            )
        );
	}

	public function actionFavourites()
	{
		$newRemVidId = Yii::app()->request->getParam('remFav', null);
		$eventId = Yii::app()->user->getState('userEvent');

		$vidList = Video::model()->getFavVidsForEvent($eventId);

		if (isset($newRemVidId)) {
			if (Video::model()->remFav($newRemVidId)){
				$this->redirect(Yii::app()->baseUrl . '/favourites');
			}
		}

		$this->render('favourites', array(
                'introText' => 'Favourites',
                'introSubText' => '',
                'vidList' => $vidList
            )
        );
	}

	public function actionContactfaq()
	{
		$eventId = Yii::app()->user->getState('userEvent');

		$this->render('contactfaq', array(
                'introText' => 'Contact/Faq',
                'introSubText' => '',
            )
        );
	}

	// remove after demo
	public function actionMultidownloadtest()
	{

		$eventId = Yii::app()->user->getState('userEvent');

		//remove after demo
		$favVidList = Video::model()->getFavVidsForEvent($eventId);

		

		$zipname = 'enter_any_name_for_the_zipped_file.zip';
		$zip = new ZipArchive;

		if ($zip->open($zipname, ZipArchive::CREATE) === TRUE) {
			// $counter = 0;
			foreach ($favVidList as $vid) {
			  $zip->addFile(getcwd() .'/vid/'. $vid->file, $vid->file);
			  // $zip->setCompressionIndex($counter, ZipArchive::CM_STORE);
			  // $counter++;
			}
			// print_r($zip);
			$zip->close();

			$size=filesize($zipname);

		} else {
			echo 'failed to open zip file';
		}

		// die('gg');
		
		$this->renderPartial('multidownloaddemoview', array(
                'zipname' => $zipname,
                'size' => $size
                
            )
        );
	}
}