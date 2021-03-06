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
			if($model->validate() && $model->login()) {
				// $this->redirect(Yii::app()->user->returnUrl);
				$this->redirect('backend/index');
			}
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
				$this->updateUserEventCookie();
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
		$eventId = null;

		if (isset( Yii::app()->request->cookies['cookie_userEvent']->value ))
			$eventId = Yii::app()->request->cookies['cookie_userEvent']->value;
		$newFavVidId = Yii::app()->request->getParam('addFav', null);
		$newRemVidId = Yii::app()->request->getParam('remFav', null);
		$vidDownloadedList = (array)Video::model()->getDownloadedVids();
		$favVidList = Video::model()->getFavVidsForEvent();

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

		$this->updateSiteLoginCookie();
		
		if ($eventId)
			$this->updateUserEventCookie();

		$this->render('video', array(
                'introText' => 'Watch Video',
                'introSubText' => '',
                'vidList' => $vidList,
                'vidDownloadedList' => $vidDownloadedList,
                'favVidList' => $favVidList,
            )
        );
	}

	public function actionDownloads()
	{
		$eventId = Yii::app()->request->cookies['cookie_userEvent']->value;
		// $newAddDownloadVidId = Yii::app()->request->getParam('addDownload', null);

		$vidList = Video::model()->getVidsForEvent($eventId);

		// if(isset($newAddDownloadVidId)) {
		// 	if (Video::model()->addDownload($newAddDownloadVidId)){
		// 		$this->redirect(Yii::app()->baseUrl . '/download');
		// 	}
		// }

		// if it is ajax validation request
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['VidDownloadForm']))
		{
			$vidArray = $_POST['VidDownloadForm'];
			Yii::app()->user->setState('vidArray', $vidArray);

			if (Video::model()->addDownloads($vidArray)) {
				$this->redirect(Yii::app()->baseUrl . '/multidownloadtest');	// will download vids
			}
		}

		if ( null !== Yii::app()->user->getState('zipName') ) {
			$zipName = Yii::app()->user->getState('zipName');
			$zipSize = Yii::app()->user->getState('zipSize');
			
			Yii::app()->user->setState('zipName', null);
			Yii::app()->user->setState('zipSize', null);
			$this->redirect(Yii::app()->baseUrl . $zipName);
			die();
			// $this->renderPartial('multidownloaddemoview', array(
	  //               'zipname' => $zipName,
	  //               'size' => $zipSize
	  //           )
	  //       );
		}

		$this->render('downloads', array(
                'introText' => 'Download',
                'introSubText' => 'Download videos to share',
                'vidList' => $vidList,
            )
        );
	}

	public function actionFavorites()
	{
		$newRemVidId = Yii::app()->request->getParam('remFav', null);
		$eventId = Yii::app()->request->cookies['cookie_userEvent']->value;

		$vidList = Video::model()->getVidsForEvent($eventId);
		$favVidList = Video::model()->getFavVidsForEvent();
		$vidDownloadedList = Video::model()->getDownloadedVids();

		if (isset($newRemVidId)) {
			if (Video::model()->remFav($newRemVidId)){
				$this->redirect(Yii::app()->baseUrl . '/favorites');
			}
		}

		$this->render('favorites', array(
                'introText' => 'Favorites',
                'introSubText' => '',
                'vidList' => $vidList,
                'favVidList' => $favVidList,
                'vidDownloadedList' => $vidDownloadedList,
            )
        );
	}

	public function actionContactfaq()
	{
		$this->render('contactfaq', array(
                'introText' => 'Contact/Faq',
                'introSubText' => '',
            )
        );
	}

	// remove after demo
	public function actionMultidownloadtest()
	{

		$dlVidList = Yii::app()->user->getState('vidArray');//print_r($dlVidList);die;
		Yii::app()->user->setState('vidArray',null);
		$dlVidObjList = Video::model()->getMultipleVids($dlVidList);//print_r($favVidList);die;

		$currEventId = Yii::app()->request->cookies['cookie_userEvent']->value;
		$currOrgId = Event::model()->findByPk(new MongoID($currEventId))->orgId;
		$currEventNameSlug = Event::model()->findByPk(new MongoID($currEventId))->slug;
		$currOrgNameSlug = Organization::model()->findByPk(new MongoID($currOrgId))->slug;
		$currEventYear = substr( Event::model()->findByPk(new MongoID($currEventId))->date, -4);
		
		$zipname = $currOrgNameSlug . '_' . $currEventYear . '.zip';
		exec('rm  ' . getcwd() . "/" . $zipname); // remove any existing zips with the same name, or ZipArchive will just keep adding files to the existing zip

		$zip = new ZipArchive;

		if ($zip->open($zipname, ZipArchive::CREATE) === TRUE) {
			// $counter = 0;
			foreach ($dlVidObjList as $vidObj) {
			  $zip->addFile(getcwd() .'/videos/uploads/'. $vidObj->eventId .'/'. $vidObj->file, $vidObj->file);
			  // $zip->setCompressionIndex($counter, ZipArchive::CM_STORE);
			  // $counter++;
			}
			$this->actionSetZippingStatus(0);
			// print_r($zip);
			$zip->close();

			$size=filesize($zipname);

		} else {
			echo 'failed to open zip file';
		}

		Yii::app()->user->setState('zipSize', $size);
		Yii::app()->user->setState('zipName', $zipname);
		$this->redirect(Yii::app()->baseUrl . '/downloads?multi=1');	
	}

	/* Overriding base Controller getPageTitle to not show Module name:
		it was showing <sitename> <page> <module>
		but we want <sitename> <page>
		*/
	public function getPageTitle()
	{
		if($this->getAction()!==null && strcasecmp($this->getAction()->getId(),$this->defaultAction))
			return $this->pageTitle=Yii::app()->name.' - '.ucfirst($this->getAction()->getId());
	}

	/* Get status of wether we are still zipping our files */
	public function actionGetZippingStatus()
	{
        $this->layout=false;
        header('Content-type: application/json');
		echo CJSON::encode( (int)Yii::app()->user->getState('isBusyZipping') );
        Yii::app()->end();
        return true;
	}

	/* Set status of wether we are still zipping our files . Must be 1 or 0 */
	public function actionSetZippingStatus($status=0)
	{
		if ( Yii::app()->request->getQuery('status') !==null) {
			Yii::app()->user->setState('isBusyZipping', Yii::app()->request->getQuery('status'));
		} else {
			Yii::app()->user->setState('isBusyZipping', $status);
		}
	}

	/* 
	Here we attempt to Hijack (overwrite) the SiteAccess cookie (which we set to handle the PHP session in main config) we set in the config, so that we can force our super long time expires time, to keep it alive for ages */
	public function updateSiteLoginCookie()
	{
		$cookie = new CHttpCookie('SiteAccess',session_id(), array(
        'domain' => $_SERVER['SERVER_NAME'],
        'expire' => time()+60*60*24*180, // 180 days from this moment
            )
        );
        Yii::app()->request->cookies['cookie_siteAccess'] = $cookie; // load it for later reading
	}

	public function updateUserEventCookie() {
		$eventId = null;

		if ($e = Yii::app()->user->getState('userEvent') ) {
			$eventId = $e;
			
		} else {
			$e = Yii::app()->request->cookies['cookie_userEvent']->value;
			$eventId = $e;
		}

		// Create new or overwrite existing cookie with new vals
		$cookie = new CHttpCookie('cookie_userEvent',$eventId, array(
		        'domain' => $_SERVER['SERVER_NAME'],
		        'expire' => time()+60*60*24*180, // 180 days from this moment
		    )
		);

		Yii::app()->request->cookies['cookie_userEvent'] = $cookie; // load it for later reading

		if ($cookie)
		    return 1;
	}

	public function actionSetSingleDownloadCookie($videoID=0) {
		if ( Yii::app()->request->getQuery('videoID') !==null) {

			$vidArray[] = Yii::app()->request->getQuery('videoID');

			if (Video::model()->addDownloads($vidArray)) {
				return 1;
			}
		} else {
			Yii::app()->user->setState('isBusyZipping', $status);
		}
	}

	/*
	When called as a url, this controller action will run updates on the db
	*/
	public function actionRunUpdateScript() {
		$EventList = Event::model()->getAllEvents();
		$OrgList = Organization::model()->getAllOrgs();
		$VidList = Video::model()->getAllVideos();
		$currEventId = Yii::app()->request->cookies['cookie_userEvent']->value;
		$currEventFolder = getcwd() .'/videos/uploads/'. $currEventId .'/';

		// Give current events a slug
        foreach ($EventList as $event) {
  			$event->slug = Yii::app()->zutils->slugify($event->name);
  			$event->save();
        }

        // Give orgs events a slug
        foreach ($OrgList as $org) {
  			$org->slug = Yii::app()->zutils->slugify($org->name);
  			$org->save();
        }

        // Give current vids a slug
        foreach ($VidList as $vid) {
  			$vid->slug = Yii::app()->zutils->slugify($vid->label);
			$vid->extension = Yii::app()->zutils->getFileExtension($vid->file);
  			$vid->save();

  			// From here on we mod the db file field to use a slug filename, then change the names of the actual files on disk
  			usleep(100000);
  			$vid->file = $vid->slug . $vid->extension;
  			$vid->save();
  			usleep(100000);
			exec('mv  '.getcwd().'/videos/uploads/'.$vid->eventId.'/'.$vid->file.' ' .getcwd().'/videos/uploads/'.$vid->eventId.'/'.$vid->slug.$vid->extension);
        }
	}
}