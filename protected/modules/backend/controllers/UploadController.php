<?php
/**
 * Upload controller
 * used by xupload forms (they call this as an endpoint eg 'site/upload') 
 */

class UploadController extends Controller
{
    public function actionIndex() 
    {
        Yii::import("xupload.models.XUploadForm");
        //    Here we define the paths where the files will be stored temporarily
        $path = realpath(Yii::app()->getBasePath()."/../videos/uploads/tmp/")."/";
        $publicPath = Yii::app()->getBaseUrl()."/videos/uploads/tmp/";

        //This is for IE which doens't handle 'Content-type: application/json' correctly
        header('Vary: Accept' );
        if ( isset($_SERVER['HTTP_ACCEPT']) 
            && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }

        //Here we check if we are deleting and uploaded file
        if ( isset($_GET["_method"]) ) {
            if ( $_GET["_method"] == "delete" ) {
                if ( $_GET["file"][0] !== '.' ) {
                    $file = $path.$_GET["file"];
                    if ( is_file($file) ) {
                        unlink($file);
                    }
                }
                echo json_encode(true);
            }
        } else {
            $model = new XUploadForm;
            $model->file = CUploadedFile::getInstance($model, 'file');
            //We check that the file was successfully uploaded
            if ( $model->file !== null ) {
                //Grab some data
                $model->mime_type = $model->file->getType();
                $model->size = $model->file->getSize();
                $extension = $model->file->getExtensionName();

                $filenameNoExt = str_replace('.'.$extension, '',$model->file->getName()); // rem extension so that we can correctly slugify the filename
                $filenameSlug = Yii::app()->zutils->slugify($filenameNoExt);
                $filename = $filenameSlug.".".$extension;
                if ( $model->validate() ) {
                    //Move our file to our temporary dir
                    $model->file->saveAs($path.$filename);
                    chmod($path.$filename, 0777);
                    //here you can also generate the image versions you need 
                    //using something like PHPThumb


                    //Now we need to save this path to the user's session
                    if ( Yii::app()->user->hasState('files') ) {
                        $userFiles = Yii::app()->user->getState('files');
                    } else {
                        $userFiles = array();
                    }
                     $userFiles[] = array(
                        "path" => $path.$filename,
                        //the same file or a thumb version that you generated
                        "thumb" => $path.$filename,
                        "filename" => $filename,
                        'size' => $model->size,
                        'mime' => $model->mime_type,
                        'name' => $model->name,
                    );
                    Yii::app()->user->setState('files', $userFiles);

                    //Now we need to tell our widget that the upload was succesfull
                    //We do so, using the json structure defined in
                    // https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
                    echo json_encode(array(array(
                            "name" => $model->name,
                            "type" => $model->mime_type,
                            "size" => $model->size,
                            "url" => $publicPath.$filename,
    //                        "thumbnail_url" => $publicPath."thumbs/$filename",
                            "thumbnail_url" => $publicPath.$filename,
                            "delete_url" => $this->createUrl("upload", array(
                                "_method" => "delete",
                                "file" => $filename
                            )),
                            "delete_type" => "POST"
                        ) ) );
                        
                        // setup for Model saving
                        $video = new Video;
                        $video->id = 'aaa';//$file->getName();
                        // $video->file = $model->file->getName();
                        $video->file = $filename;
                        $video->extension = ".".$extension;
                        $video->label = $model->file->getName();
                        $video->slug = $filenameSlug;
                        $video->path = $path;//$file->getName();
                        // $video->eventId = (string)$id;
                        $video->eventId = Yii::app()->user->getState('eventIdForCurUpload');
                        $video->fav = 0;
                        $video->downloaded = 0;
                        $video->sizeNum = $model->file->getSize();
                        $video->length = Video::model()->getLength($path.$filename);

                        if($x = $video->save()){
                            Yii::log("Video model Saving Success............");
                        } else {
                            Yii::log("Video model Saving FAIL............");
                            Yii::log(print_r($video->getErrors()));
                        }

                } else {
                    //If the upload failed for some reason we log some data and let the widget know
                    echo json_encode(array(
                        array("error" => $model->getErrors('file'),
                    )));
                    Yii::log("XUploadAction: ".CVarDumper::dumpAsString($model->getErrors()),
                        CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction" 
                    );
                }
            } else {
                throw new CHttpException(500, "Could not upload file");
            }
        }
    }
}