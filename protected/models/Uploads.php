<?php

/**
 * Uploads class.
 */
class Uploads extends EMongoDocument
{
    public $size;
    public $mime;
    public $source;
    public $gallery_id;

    public $gallery_name; // not saved to db but used as a val when saving Gallery Model
    
            
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    // public function tableName() {
    //     parent::tableName();
    //     return 'uploads';
    // }

    /**
     * returns the primary key field for this model
     */
    public function primaryKey()
    {
        return '_id';
    }

    /**
    * Declares the validation rules.
    */
    public function rules()
    {
        return array(
            array('gallery_name', 'required'),
        );
    }
    
    /**
    * For massive form assignments
    */
    public function attributeNames() {
        return array(
            'size',
            'mime',
            'source',
            'gallery_id',

            'gallery_name',
        );
    }

    /**
     * This method have to be defined in every Model
     * @return string MongoDB collection name, witch will be used to store documents of this model
     */
    public function getCollectionName()
    {
        return 'uploads';
    }
    
    public function afterSave() {    
        $this->addImages();
        parent::afterSave();
    }
 
    public function addImages()
    {   
        //If we have pending images
        if ( Yii::app()->user->hasState('images') ) {
            $userImages = Yii::app()->user->getState('images');
            //Resolve the final path for our images
            $path = Yii::app()->getBasePath()."/../images/uploads/{$this->id}/";
            //Create the folder and give permissions if it doesnt exists
            if ( !is_dir($path) ) {
                mkdir($path);
                chmod($path, 0777);
            }

            //Now lets create the corresponding models and move the files
            foreach ( $userImages as $image ) {
                if ( is_file($image["path"]) ) {
                    if ( rename($image["path"], $path.$image["filename"]) ) {
                        chmod($path.$image["filename"], 0777);

                        $uploads_model = new Uploads;
                        $uploads_model->size = $image["size"];
                        $uploads_model->mime = $image["mime"];
                        $uploads_model->source = "/images/uploads/{$this->id}/".$image["filename"];
                        $uploads_model->gallery_id = Yii::app()->user->getState('gallery_id');
                        $uploads_model->gallery_name = 'blahblah';

                        if ( !$uploads_model->save() ) {
                            //Its always good to log something
                            Yii::log("Could not save Image:\n".CVarDumper::dumpAsString( 
                                $uploads_model->getErrors()), CLogger::LEVEL_ERROR);
                            //this exception will rollback the transaction
                            throw new Exception('Could not save Image');
                        }
                    }
                } else {
                    //You can also throw an execption here to rollback the transaction
                    Yii::log($image["path"]." is not a file", CLogger::LEVEL_WARNING);
                }
            }
            //Clear the user's session
            Yii::app()->user->setState('images', null);
            
        }
    }
}