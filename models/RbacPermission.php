<?php

namespace app\models;

class RbacPermission extends \yii\base\Object
{
    public $code;
    public $name;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}
