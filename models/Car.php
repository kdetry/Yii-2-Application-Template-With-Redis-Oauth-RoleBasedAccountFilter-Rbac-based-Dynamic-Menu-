<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SOURCES.Cars".
 *
 * @property string $DEVICECODE
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SOURCES.Car';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DEVICECODE'], 'string']
        ];
    }


}
