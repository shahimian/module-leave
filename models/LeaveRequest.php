<?php

namespace app\modules\leave\models;

use Yii;

/**
 * This is the model class for table "leave_request".
 *
 * @property integer $request_id
 * @property integer $user_id
 * @property string $comment
 * @property string $date
 * @property integer $over_time
 * @property string $start_time
 * @property string $finish_time
 * @property string $response
 * @property integer $becoming
 * @property integer $created_by
 * @property integer $updated_by
 * @property boolean $delay
 */
class LeaveRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment', 'date'], 'required'],
            [['user_id', 'over_time', 'becoming', 'created_by', 'updated_by', 'delay'], 'integer'],
            [['comment', 'response'], 'string'],
            [['date'], 'string', 'max' => 10],
            [['start_time', 'finish_time'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'request_id' => 'Request ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'date' => 'Date',
            'over_time' => 'Over Time',
            'start_time' => 'Start Time',
            'finish_time' => 'Finish Time',
            'delay' => 'Delay',
            'response' => 'Response',
            'becoming' => 'Becoming',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
