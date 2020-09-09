<?php

/**
 * VideoUpload class.
 * VideoUpload is the data structure for keeping
 * user VideoUpload form data. It is used by the 'create' action of 'VideoController'.
 */
// class VideoUpload extends CActiveForm
class VideoUpload extends CFormModel
{
    public $file;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // array('file', 'file', 'types'=>'mp4, mov, mpg, avi', 'safe' => true),
            array('file', 'file', 'types'=>'OGG, MPEG, MP4, mp4, mov, mpg, avi, MOV, MPEG', 'safe' => true),
            // array('image', 'file', 'types'=>'jpg, gif, png, pdf', 'safe' => true),
            // array('image', 'file', 'types'=>'jpg, gif, png, pdf',),
        );
    }

    /**
     * Declares attribute labels.
     */
    // public function attributeLabels()
    // {
    //     return array(
    //         'rememberMe'=>'Remember me next time',
    //     );
    // }
}
