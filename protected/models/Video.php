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
        $criteria->sort('label',EMongoCriteria::SORT_ASC); // do an initial sort using name field
        $criteria->limit(200);

        return Video::model()->findAll($criteria);
        // return Organization::model()->find();
        // return $this->findAll($criteria);

    }

    public function getFavVidsForEvent()
    {   
        if (isset(Yii::app()->request->cookies['cookie_vidFavs'])) {
            $serialized_vidFavs_arr = Yii::app()->request->cookies['cookie_vidFavs']->value;
            return json_decode($serialized_vidFavs_arr);
        } else {
            return null;
        }
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
        $newFavVidArr = array($newFavVidId); //turn input into an array so that we can easily work with it

        if ($currVidFavListArr = $this->getFavVidsForEvent()) {
            foreach ($newFavVidArr as $vidId) {
                if ( !in_array($vidId, $currVidFavListArr) )
                    array_push($currVidFavListArr, $vidId);        
            }
            $serialized_arr = json_encode($currVidFavListArr);
        } else {
            $serialized_arr = json_encode($newFavVidArr);
        }

        // Create new or overwrite existing cookie with new vals
        $cookie = new CHttpCookie('cookie_vidFavs',$serialized_arr, array(
                'domain' => $_SERVER['SERVER_NAME'],
                'expire' => time()+60*60*24*180, // 180 days from this moment
            )
        );
        Yii::app()->request->cookies['cookie_vidFavs'] = $cookie; // load it for later reading
        
        if ($cookie)
            return 1;
    }

    public function remFav($newRemVidId)
    {
        if ($currVidFavListArr = $this->getFavVidsForEvent()) {
            
            $reducedArr = array_merge(array_diff($currVidFavListArr, array($newRemVidId))); // remove a known string ( $newRemVidId in this case) from an array, and reset the index as to not possibly confuse other array looping code

            $serialized_arr = json_encode($reducedArr);
        }

        // Create new or overwrite existing cookie with new vals
        $cookie = new CHttpCookie('cookie_vidFavs',$serialized_arr, array(
                'domain' => $_SERVER['SERVER_NAME'],
                'expire' => time()+60*60*24*180, // 180 days from this moment
            )
        );
        Yii::app()->request->cookies['cookie_vidFavs'] = $cookie; // load it for later reading
        
        if ($cookie)
            return 1;
    }

    public function addDownloads($downloadArray)
    {
        if ($currVidDownloadListArr = $this->getDownloadedVids()) {

            foreach ($downloadArray as $vidId) {
                if ( !in_array($vidId, $currVidDownloadListArr) )
                    array_push($currVidDownloadListArr, $vidId);
            }
            
            $serialized_arr = json_encode($currVidDownloadListArr);
        } else {
            $serialized_arr = json_encode($downloadArray);
        }

        // Create new or overwrite existing cookie with new vals
        $cookie = new CHttpCookie('cookie_viddownloads',$serialized_arr, array(
                'domain' => $_SERVER['SERVER_NAME'],
                'expire' => time()+60*60*24*180, // 180 days from this moment
            )
        );
        Yii::app()->request->cookies['cookie_viddownloads'] = $cookie; // load it for later reading
        
        if ($cookie)
            return 1;
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
        
        Yii::app()->user->setState('getDirSizeVideo',Video::model()->getDirSize( Yii::app()->getBasePath()."/../videos" ));

        //Clear the user's session
        Yii::app()->user->setState('files', null);
    }

    public static function getDirSize($directory) {
        $arrTrimmed = array();

        exec('du -sh '.$directory, $arr);
        $arrTrimmed[] = $arr[0];

        $infoLine = $arr[0];
        $infoLineWithSpacesReduced = preg_replace('!\s+!', ' ', $infoLine); // reduce multiple spaces to single space
        $wordArr = explode(' ', $infoLineWithSpacesReduced);
        $val = $wordArr[0];

        // $this->lastOutput = $arrTrimmed;
        // return $this->lastOutput;
        // return $arrTrimmed;
        return $val;
    }

    public function getDownloadedVids()
    {
        if (isset(Yii::app()->request->cookies['cookie_viddownloads'])) {
            $serialized_viddownloads_arr = Yii::app()->request->cookies['cookie_viddownloads']->value;
            return json_decode($serialized_viddownloads_arr);
        } else {
            return null;
        }
    }
}