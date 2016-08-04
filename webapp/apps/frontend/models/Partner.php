<?php
    /**
     * Created by PhpStorm.
     * User: User
     * Date: 8/1/2016
     * Time: 11:18 PM
     */
    namespace Webapp\Frontend\Models;
    class Partner extends BaseModel{
        /**
         *
         * @var integer
         */
        public $id;
        public $name;
        public $status;
        public $avatar;
        public $sort;


        /**
         * Initialize method for model.
         */
        public function initialize()
        {

        }

        public function beforeSave(){
            $this->status = intval($this->status);
        }

        /**
         * Returns table name mapped in the model.
         *
         * @return string
         */
        public function getSource()
        {
            return 'partner';
        }

        /**
         * Allows to query a set of records that match the specified conditions
         *
         * @param mixed $parameters
         * @return Partner[]
         */
        public static function find($parameters = null)
        {
            return parent::find($parameters);
        }

        /**
         * Allows to query the first record that match the specified conditions
         *
         * @param mixed $parameters
         * @return Partner
         */
        public static function findFirst($parameters = null)
        {
            return parent::findFirst($parameters);
        }
    }