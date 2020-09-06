<?php
class Event extends EMongoDocument
{
    public $id;
    public $orgId;
    public $name;
    public $logo;
    public $pass;

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

    // public function rules()
    // {
    //     // NOTE: you should only define rules for those attributes that
    //     // will receive user inputs.
    //     return array(
    //         array('name,,pass', 'required'),
    //         // The following rule is used by search().
    //         // Please remove those attributes that should not be searched.
    //         array('id, name', 'safe', 'on'=>'search'),
    //     );
    // }

    // public function attributeLabels()
    // {
    //     return array(
    //         '_id' => 'ID',
    //         'name' => 'Name',
    //         'name' => 'Logo',
    //         'name' => 'Pass',
    //     );
    // }

    // the same with attribute names
    /* Zayne: its a good idea to insert all the attribute names in here for all your mongo docs, as */
    /* I have found that having them in helps when doing updates */
    // public function attributeNames() {
    //     return array(
    //         '_id',
    //         'name',
    //         'logo',
    //         'pass',
    //     );
    // }

    /**
     * This method have to be defined in every Model
     * @return string MongoDB collection name, witch will be used to store documents of this model
     */
    public function getCollectionName()
    {
        return 'event';
    }

    // We can define rules for fields, just like in normal CModel/CActiveRecord classes
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('orgId,name,logo,pass', 'required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, orgId, name', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            '_id' => 'ID',
            'orgId' => 'Org ID',
            'name' => 'Name',
            'logo' => 'Logo',
            'pass' => 'Pass',
        );
    }

    /**
     * This method have to be defined in every model, like with normal CActiveRecord
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // public function embeddedDocuments()
    // {
    //     return array(
    //         // property field name => class name to use for this embedded document
    //         'video' => 'Video',
    //     );
    // }

    public function getEventsForOrg($orgId)
    {   
        // $orgId = '5f51366b8d285816bfba1d74';
        $criteria = new EMongoCriteria;
        // $criteria->text_html = null;    //NB: you must set the criteria to a value, as opposed to a test eg '!== null' or '< 3'
        // $criteria->orgId = new MongoID($orgId); /** Our find query */
        $criteria->orgId = $orgId; /** Our find query */
        // $criteria->addCond('event->name', '==', 'eva1');
        // $criteria->event->name('==', 'eva1');
        $criteria->limit(200);

        return Event::model()->findAll($criteria);
        // return Organization::model()->find();
        // return $this->findAll($criteria);

    }
   

    public function validatePass($input, $eventId)
    {
        // print_r($input);print_r($eventId);die;
        $criteria = new EMongoCriteria;
        // $criteria->text_html = null;    //NB: you must set the criteria to a value, as opposed to a test eg '!== null' or '< 3'
        // $criteria->orgId = new MongoID($orgId); /** Our find query */
        $criteria->_id = new MongoID($eventId); /** Our find query */
        // $criteria->addCond('event->name', '==', 'eva1');
        $criteria->pass('==', $input);
        $criteria->limit(200);

        return Event::model()->findAll($criteria);

    }


    
}