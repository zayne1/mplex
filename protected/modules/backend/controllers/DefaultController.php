<?php

class DefaultController extends Controller
{
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
                'actions'=>array('index','view'),
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
        $OrganizationList = Organization::model()->getAllOrgs();
        $eventDataProvider=new EMongoDocumentDataProvider('Event');

        $this->render('index', array(
                'OrgList' => $OrganizationList,
                'eventDataProvider' => $eventDataProvider
            )
        );		
	}
}