<?php

class User extends EMongoDocument
{
    /**
     * A public variable should be defined for each key=>value you want in the
     * model. Just like if it were a column in a SQL database
     */
    public $id;
    public $username;
    public $password;

    public function init()
    {
        parent::init();
    }

    /**
     * If we override this method to return something different than '_id',
     * internal methods as findByPk etc. will be using returned field name as a primary key
     * @return string|array field name of primary key, or array for composited key.
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
            'username',
            'password',
        );
    }

    /**
     * Similar to the get tableName() method.
     * @return string The name of the document for this class.
     */
    public function getCollectionName()
    {
        // Should be in all lowercase.
        return 'user';
    }



    /**
     * This is defined as normal. Nothing has changed here.
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('username, password', 'required'),
            array('_id, username, password',
                   'safe'
            ),
        );
    }

    /**
     * Returns attribute labels for each public variable that will be stored
     * as key in the database. It is defined just as normal with SQL models.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            '_id' => 'ID',
            'username' => 'UserName',
            'password' => 'Password'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className class name
     * @return User the static model class.
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    

    

    

}
