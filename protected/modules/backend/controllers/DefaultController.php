<?php

class DefaultController extends Controller
{
    public function init()
    {
        Yii::app()->user->setState('getFreeSpace',$this->getFreeSpace());
    }

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
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view','getFreeSpace'),
                // 'users'=>array('*'),
                'users'=>array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
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

    // Shows the Dashboard. Perhaps we can reame it to dashboard at some point
	public function actionIndex()
	{
        $orgDataProvider=new EMongoDocumentDataProvider('Organization');
        $eventDataProvider=new EMongoDocumentDataProvider('Event');

        $this->render('index', array(
                'orgDataProvider' => $orgDataProvider,
                'eventDataProvider' => $eventDataProvider
            )
        );		
	}

    public static function getFreeSpace() {
        $arrTrimmed = array();

        exec('df -h', $arr);
        $arrTrimmed[] = $arr[0];
        $arrTrimmed[] = $arr[1];

        $infoLine = $arr[1];
        $infoLineWithSpacesReduced = preg_replace('!\s+!', ' ', $infoLine); // reduce multiple spaces to single space
        $wordArr = explode(' ', $infoLineWithSpacesReduced);
        $val = $wordArr[3];

        // $this->lastOutput = $arrTrimmed;
        // return $this->lastOutput;
        // return $arrTrimmed;
        return $val;
    }
}