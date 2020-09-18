<?php
class Video extends EMongoDocument
{
    public $id;
    public $path;
    public $file;
    public $label;
    public $eventId;
    public $fav;
    public $downloaded;
    public $length;
    public $size;
    public $date;

    public function init()
    {
    	parent::init();
    }

    public function beforeSave() {
        if ( $this->getIsNewRecord() ) {

            $this->label = $this->file; // set to file name initiallly
            $this->label = substr($this->label, 0, -4); // remove file extension
            $this->date = date("Y-m-d", time());
            $this->size = $this->_formatBytes($this->size);        
        }
        return parent::beforeSave();
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
            array('id, path, label', 'safe', 'on'=>'search'),//label to go here
        );
    }

    public function attributeLabels()
    {
        return array(
            '_id' => 'ID',
            'eventId' => 'Event ID',
            'path' => 'Path',
            'file' => 'File',
            'label' => 'File Custom name',
            'fav' => 'Favorite',
            'downloaded' => 'Downloaded',
            'size' => 'Size',
            'date' => 'Date',
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
            'label',
            'fav',
            'downloaded',
            'size',
            'date',
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

    public function addDownloads($downloadArray)
    {
        // prepare modifiers
        $modifier = new EMongoModifier();

        // replace field1 value with 'new value'
        $modifier->addModifier('downloaded', 'set', 1);
        // $modifier->addModifier('Dept', 'set', 'IT');

        // prepare search to find documents
        $criteria = new EMongoCriteria();
        
        // $criteria->addCond('_id','==', new MongoID('5f516e038d285816bfba1da6'));

        // update all matched documents using the modifiers
        // $status = Video::model()->updateAll($modifier, $criteria);
        // die(print_r($status));


        //Array ( [VidDownloadForm] => Array ( [video] => video1 ) ) 
        // print_r($downloadArray);die;
        $status = 0;
        foreach ($downloadArray as $vidId) {
            $criteria->addCond('_id','==', new MongoID($vidId));
            $status=Video::model()->updateAll($modifier, $criteria);

            if (!$status) {
                Yii::log('error saving mongo add download field in Video.php');
                die('failed to save download statusto database');
            }
        }
        return $status;
       
    }

    public function saveMetaData($id, $fileName, $path)
    {
        // prepare modifiers
        $modifier = new EMongoModifier();

        // replace field1 value with 'new value'
        $modifier->addModifier('file', 'set', $fileName);
        $modifier->addModifier('path', 'set', $path);
        // $modifier->addModifier('Dept', 'set', 'IT');

        // prepare search to find documents
        $criteria = new EMongoCriteria();
        
        // $criteria->addCond('_id','==', new MongoID('5f516e038d285816bfba1da6'));

        // update all matched documents using the modifiers
        // $status = Video::model()->updateAll($modifier, $criteria);
        // die(print_r($status));


        //Array ( [VidDownloadForm] => Array ( [video] => video1 ) ) 
        // print_r($downloadArray);die;
        $status = 0;
        
        $criteria->addCond('_id','==', new MongoID($id));
        $status=Video::model()->updateAll($modifier, $criteria);

        if (!$status) {
            Yii::log('error saving mongo saveMetaData in Video.php');
            die('error saving mongo saveMetaData in Video.php');
        }
    
        return $status;
       
    }

    public function getAllVideos()
    {   
        // $orgId = '5f51366b8d285816bfba1d74';
        $criteria = new EMongoCriteria;
        // $criteria->text_html = null;    //NB: you must set the criteria to a value, as opposed to a test eg '!== null' or '< 3'
        // $criteria->orgId = new MongoID($orgId); /** Our find query */
        $criteria->eventId !== null; /** Our find query */
        // $criteria->addCond('event->name', '==', 'eva1');
        // $criteria->event->name('==', 'eva1');
        $criteria->limit(200);

        return Video::model()->findAll($criteria);
        // return Organization::model()->find();
        // return $this->findAll($criteria);

    }

    /* Get human readable size of bytes in mb
        eg echo formatBytes2(24962496); // 23.81 M
    */
    function _formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'MB', 'G', 'T');   

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
}