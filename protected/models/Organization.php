<?php
class Organization extends EMongoDocument
{
    public $id;
    public $name;
    public $logo;

    public function init()
    {
    	parent::init();
    }

    /**
     * returns the primary key field for this model
     */
    public function primaryKey()
    {
        return '_id';
    }

    /**
     * This method have to be defined in every Model
     * @return string MongoDB collection name, witch will be used to store documents of this model
     */
    public function getCollectionName()
    {
        return 'org';
    }

    // We can define rules for fields, just like in normal CModel/CActiveRecord classes
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            '_id' => 'ID',
            'name' => 'Name',
            'logo' => 'Logo',
        );
    }

    // the same with attribute names
    /* Zayne: its a good idea to insert all the attribute names in here for all your mongo docs, as */
    /* I have found that having them in helps when doing updates */
    public function attributeNames() {
        return array(
            '_id',
            'name',
            'logo',
        );
    }

    /**
     * This method have to be defined in every model, like with normal CActiveRecord
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * This method should return simple array that will define field names for embedded
     * documents, and class to use for them
     */
    // public function embeddedDocuments()
    // {
    //     return array(
    //         // property field name => class name to use for this embedded document
    //         'event' => 'Event',
    //     );
    // }

    public function getAllOrgs()
    {	
    	/*
        $criteria = new EMongoCriteria;
		$criteria->text_html = null;    //NB: you must set the criteria to a value, as opposed to a test eg '!== null' or '< 3'
		$criteria->limit(200);
		return Organization::model()->findAll($criteria);
        */

        $criteria = new EMongoCriteria;
        // $criteria->stories->widgets->type = 'InfoBlock'; /** Our find query */
        // $criteria->event->video->path = '/patha1'; /** Our find query */
        $criteria->text_html = null;

        return Organization::model()->findAll($criteria); /** Exec the find using query params in $criteria */
    }    
}