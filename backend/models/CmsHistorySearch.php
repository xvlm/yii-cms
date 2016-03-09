<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CmsHistory;

/**
 * CmsHistorySearch represents the model behind the search form about `backend\models\CmsHistory`.
 */
class CmsHistorySearch extends CmsHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cms_id'], 'integer'],
            [['template', 'layout', 'view', 'desc'], 'safe'],
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
        $query = CmsHistory::find()->select(['id','desc', 'cms_id', 'layout', 'activity', 'view', 'search_url', 'time', 'platform', 'seo_title', 'seo_keywords', 'seo_description']);

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
            'id' => $this->id,
            'cms_id' => $this->cms_id,
        ]);

        $query->andFilterWhere(['like', 'template', $this->template])
            ->andFilterWhere(['like', 'layout', $this->layout])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'view', $this->view]);
        
        return $dataProvider;
    }
}
