<?php

namespace app\modules\leave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\leave\models\LeaveRequest;
use app\models\User;

/**
 * LeaveRequestSearch represents the model behind the search form about `app\modules\leave\models\LeaveRequest`.
 */
class LeaveRequestSearch extends LeaveRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'user_id', 'start_time', 'finish_time', 'created_by', 'updated_by'], 'integer'],
            [['comment', 'response'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LeaveRequest::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'request_id' => $this->request_id,
            'user_id' => $this->user_id,
            'start_time' => $this->start_time,
            'finish_time' => $this->finish_time,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'response', $this->response]);

        return $dataProvider;
    }
}
