<?php
class Organization extends EMongoDocument
{
    public $id;
    public $name;
    public $slug;
    public $co_type;
    public $contact_person;
    public $phone;
    public $email;
    public $website;
    public $logo;

    public function init()
    {
    	parent::init();
    }

    public function beforeSave() {
        if ( !$this->getIsNewRecord() ) {
            
            // Handle for updates where no new logo was added (ie we will keep the old one)
            if( empty($this->logo) ) {
                $oldmodel = Organization::model()->findByPk(new MongoID($this->_id));
                $this->logo = $oldmodel->logo;
            }
        }

        $this->slug = Yii::app()->zutils->slugify($this->name);
        
        return parent::beforeSave();
    }

    public function beforeDelete() {
        $EventList = Event::model()->getEventsForOrg((string)$this->_id);
        
        foreach ($EventList as $event) {
            $event->deleteByPk($event->getPrimaryKey());
        }
        return parent::beforeDelete();
    }

    /**
     * returns the primary key field for this model
     */
    public function primaryKey()
    {
        return '_id';
    }

    // the same with attribute names
    /* Zayne: its a good idea to insert all the attribute names in here for all your mongo docs, as */
    /* I have found that having them in helps when doing updates */
    public function attributeNames() {
        return array(
            '_id',
            'name',
            'slug',
            'co_type',
            'contact_person',
            'phone',
            'email',
            'website',
            'logo',
        );
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
            array('_id, name, co_type, contact_person, phone, email, website, logo',
                   'safe'
            ),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name', 'safe', 'on'=>'search'),
            array('logo', 'file', 'types'=>'jpg, jpeg, gif, png, webp, bmp', 'safe' => true, 'on'=>'insert', 'allowEmpty'=>false),
            array('logo', 'file', 'types'=>'jpg, jpeg, gif, png, webp, bmp', 'safe' => true, 'on'=>'update', 'allowEmpty'=>true),
        );
    }

    public function attributeLabels()
    {
        return array(
            '_id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'co_type' => 'Company Type',
            'contact_person' => 'Contact Person',
            'phone' => 'Phone',
            'email' => 'Email',
            'website' => 'Website',
            'logo' => 'Logo',
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