<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionDashboard()
	{
		$this->render('dashboard');
	}
	public function actionOrg()
	{
		$this->render('org');
	}
	public function actionEvent()
	{
		$this->render('event');
	}
}