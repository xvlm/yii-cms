<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cms;

/**
 * CmsSearch represents the model behind the search form about `backend\models\Cms`.
 */
class CmsSearch extends Cms
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_cache', 'is_release', 'time'], 'integer'],
            [['template', 'layout', 'view', 'desc', 'activity'], 'safe'],
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
        $query = Cms::find()->select(['id','desc', 'is_cache', 'is_release','is_static', 'activity', 'view', 'search_url', 'time', 'status', 'platform', 'seo_title', 'seo_keywords', 'seo_description']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('status != -1');
            return $dataProvider;
        }
//        $query->where('status != -1');
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'is_cache' => $this->is_cache,
//            'is_release' => $this->is_release,
//            'time' => $this->time,
//        ]);

      //  var_dump($this->view);
        $platform = isset($_COOKIE['platform']) ? $_COOKIE['platform'] : setcookie('platform',1 , time() + 3600 * 24 * 30, '/');
        $query->orFilterWhere(['like', 'template', $this->view])
            ->orFilterWhere(['like', 'layout', $this->view])
            ->orFilterWhere(['like', 'view', $this->view])
            ->orFilterWhere(['like', 'desc', $this->view])
            ->orFilterWhere(['like', 'activity', $this->view])
            ->andWhere('status != -1')
            ->andWhere("platform = ".$platform);
        $query->orderBy('time desc');
        return $dataProvider;
    }
}
