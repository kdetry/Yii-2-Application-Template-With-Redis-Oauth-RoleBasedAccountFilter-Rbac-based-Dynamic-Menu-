<?php

namespace app\models;

use Yii;
use app\models\Cars;

/**
 * This is the model class for table "SOURCES.Device".
 *
 * @property string $DeviceID
 * @property string $DEVICETYPE
 * @property string $DEVICECODE
 * @property string $CREATEDTIME
 */
class Device extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SOURCES.Device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DeviceID'], 'required'],
            [['DeviceID'], 'unique'],
			[['CREATEDTIME'], 'safe'],
            ['CREATEDTIME', 'date', 'format' => 'php:Y-m-d'],
            [['DeviceID'], 'string', 'max' => 60],
            [['DEVICETYPE'], 'string', 'max' => 1],
            [['DEVICECODE'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DeviceID' => 'Device Numarası',
            'DEVICETYPE' => 'DEVICETYPE',
            'DEVICECODE' => 'Cihaz Kodu',
            'CREATEDTIME' => 'Kayıt Zamanı',
        ];
    }

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			$this->CREATEDTIME = Yii::$app->formatter->asDate('now', 'php:d-M-Y h:i:s a'); // 2014-10-06
			return true;
		} else {
			return false;
		}
	}
	
	public function checkByTipAndDEVICECODE(){
		if($this->DEVICETYPE == 1 && Car::find()->where(['DEVICECODE' => $this->DEVICECODE])->count()){
			return true;
		}
		\Yii::$app->getSession()->setFlash('info', $this->DEVICECODE . ' Cihaz Bulunamadı. İşlem Başarısız');
		return false;
	}

    public static function primaryKey()
    {
        return array('DeviceID');
    }
}
