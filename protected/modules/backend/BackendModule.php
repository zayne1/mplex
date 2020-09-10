<?php

class BackendModule extends CWebModule
{
	public $is_backend = true;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'backend.models.*',
			'backend.components.*',
		));

		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile('/css/metroplex-backend.css');
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
