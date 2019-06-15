<?php

namespace app\modules\leave\models;

use Yii;

/**
 * This is the model class for table "leave_members".
 *
 * @property integer $member_id
 * @property integer $user_id
 * @property string $email
 * @property string $level
 */
class LeaveMembers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_members';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['level, assign'], 'string'],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'user_id' => 'User ID',
            'email' => 'Email',
            'level' => 'Level',
            'assign' => 'Assign',
        ];
    }
    
    public static function getLevel()
    {
	return (new LeaveMembers)->find()->where(['user_id' => Yii::$app->user->id])->one()->level;
    }

    public static function getAssign()
    {
	return (new LeaveMembers)->find()->where(['user_id' => Yii::$app->user->id])->one()->assign;
    }
    
    public static function getDepartment()
    {
	return (new LeaveMembers)->find()->where(['user_id' => Yii::$app->user->id])->one()->department;
    }
    
}
