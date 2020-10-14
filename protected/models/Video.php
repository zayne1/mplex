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
    public $thumb;

    public function init()
    {
    	parent::init();
    }

    public function beforeSave() {
        if ( $this->getIsNewRecord() ) {

            // $this->label = $this->file; // set to file name initiallly
            $this->label = substr($this->label, 0, -4); // remove file extension
            $this->size = $this->_formatBytes($this->size);        
            $this->date = date("Y-m-d", time());
            $this->thumb = 'videodefaultthumb.png';
        }

        $this->moveFiles();

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
            'length' => 'Length',
            'size' => 'Size',
            'date' => 'Date',
            'thumb' => 'Thumb',
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
            'length',
            'size',
            'date',
            'thumb',
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

    public function getMultipleVids($vidArray)
    {   
        // $orgId = '5f51366b8d285816bfba1d74';
        $newVidArr = array();
        foreach ($vidArray as $vidId) {
            $newVidArr[]= Video::model()->findByPk(new MongoID($vidId));
        }

        return $newVidArr;
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

    public function saveMetaData($id, $fileName, $path, $length)
    {
        // prepare modifiers
        $modifier = new EMongoModifier();

        // replace field1 value with 'new value'
        $modifier->addModifier('file', 'set', $fileName);
        $modifier->addModifier('path', 'set', $path);
        $modifier->addModifier('length', 'set', $length);
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

    /*
    Takes a video file path
    returns length string
    */
    public function getLength($filepath)
    {
        exec('mediainfo --Inform="Video;%Duration/String%" "'.$filepath.'"', $arr);
        return $arr[0];
    }

    /*
    Final work before saving record
    */
    public function moveFiles()
    {
        
        //Resolve the final path for our files
        $finalPath = Yii::app()->getBasePath()."/../videos/uploads/{$this->eventId}/";
        //Create the folder and give permissions if it doesnt exists
        if ( !is_dir($finalPath) ) {
            mkdir($finalPath);
            chmod($finalPath, 0777);
        }

        //Now lets create the corresponding models and move the files
        
        if ( is_file($this->path.$this->file) ) {
            if ( rename($this->path.$this->file, $finalPath.$this->file) ) {
                chmod($finalPath.$this->file, 0777);

                $this->path = $finalPath; // Just setting the final path for the save that comes later
            }
        } else {
            //You can also throw an execption here to rollback the transaction
            Yii::log($this->path.$this->file ." is not a file", CLogger::LEVEL_WARNING);
        }
        
        //Clear the user's session
        Yii::app()->user->setState('files', null);
    }
}