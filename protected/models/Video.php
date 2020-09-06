<?php
class Video extends EMongoDocument
{
    public $id;
    public $path;
    public $file;
    public $eventId;
    public $fav;

    public function init()
    {
    	parent::init();
    }

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
        return 'video';
    }

    // We can define rules for fields, just like in normal CModel/CActiveRecord classes
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('path,file,fav', 'required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, path', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            '_id' => 'ID',
            'eventId' => 'Event ID',
            'path' => 'Path',
            'file' => 'File',
            'fav' => 'Favorite',
        );
    }

    // the same with attribute names
    /* Zayne: its a good idea to insert all the attribute names in here for all your mongo docs, as */
    /* I have found that having them in helps when doing updates */
    public function attributeNames() {
        return array(
            '_id',
            'eventId',
            'path',
            'file',
            'fav',
        );
    }

    /**
     * This method have to be defined in every model, like with normal CActiveRecord
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getVidsForEvent($eventId)
    {   
        // $orgId = '5f51366b8d285816bfba1d74';
        $criteria = new EMongoCriteria;
        // $criteria->text_html = null;    //NB: you must set the criteria to a value, as opposed to a test eg '!== null' or '< 3'
        // $criteria->orgId = new MongoID($orgId); /** Our find query */
        $criteria->eventId = $eventId; /** Our find query */
        // $criteria->addCond('event->name', '==', 'eva1');
        // $criteria->event->name('==', 'eva1');
        $criteria->limit(200);

        return Video::model()->findAll($criteria);
        // return Organization::model()->find();
        // return $this->findAll($criteria);

    }

    public function getFavVidsForEvent($eventId)
    {   
        // $orgId = '5f51366b8d285816bfba1d74';
        $criteria = new EMongoCriteria;
        // $criteria->text_html = null;    //NB: you must set the criteria to a value, as opposed to a test eg '!== null' or '< 3'
        // $criteria->orgId = new MongoID($orgId); /** Our find query */
        $criteria->eventId = $eventId; /** Our find query */
        // $criteria->addCond('event->name', '==', 'eva1');
        $criteria->fav('==', 1);
        $criteria->limit(200);

        return Video::model()->findAll($criteria);
    }


    public function addFav($newFavVidId)
    {
        $vid = Video::model()->findByPk(new MongoID($newFavVidId));

        $vid->fav = 1;
        if ($vid->save())
            return 1;
    }

    public function remFav($newRemVidId)
    {
        $vid = Video::model()->findByPk(new MongoID($newRemVidId));

        $vid->fav = 0;
        if ($vid->save())
            return 1;
    }

}