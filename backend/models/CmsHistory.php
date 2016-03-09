<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%cms_history}}".
 *
 * @property integer $id
 * @property integer $cms_id
 * @property string $template
 * @property string $layout
 * @property string $view
 * @property string $activity
 * @property string $desc
 * @property string $search_url
 * @property integer $time
 * @property integer $platform
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 */
class CmsHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cms_id', 'template', 'layout', 'view', 'activity', 'desc', 'time', 'platform'], 'required'],
            [['cms_id', 'time'], 'integer'],
            [['template'], 'string'],
            [['layout', 'view', 'activity'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 500],
            [['seo_title'], 'string', 'max' => 200],
            [['seo_keywords'], 'string', 'max' => 200],
            [['seo_description'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cms_id' => 'Cms ID',
            'template' => 'Template',
            'layout' => 'Layout',
            'view' => 'View',
            'activity' => Yii::t('app','活动'),
            'desc' => Yii::t('app','描述'),
            'time' => Yii::t('app','日期'),
            'search_url' => 'search_url',
            'seo_title' => 'seo_title',
            'seo_keywords' => 'seo_keywords',
            'seo_description' => 'seo_description',
        ];
    }
    
    public function getCmsHistoryById($id){
        $query = $this->find()->where(['cms_id' => $id])->orderBy('time desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
    
    public static function createHistory($id)
    {
        $cms_old = Cms::findOne($id);
        
        $cmsHistoryModel = new CmsHistory();
        
        $cmsHistoryModel->cms_id = $id;
        $cmsHistoryModel->template = $cms_old->template;
        $cmsHistoryModel->layout = $cms_old->layout;
        $cmsHistoryModel->view = $cms_old->view;
        $cmsHistoryModel->activity = $cms_old->activity;
        $cmsHistoryModel->search_url = $cms_old->search_url;
        $cmsHistoryModel->desc = $cms_old->desc;
        $cmsHistoryModel->time = time();
        $cmsHistoryModel->platform = $cms_old->platform;
        $cmsHistoryModel->seo_title = $cms_old->seo_title;
        $cmsHistoryModel->seo_keywords = $cms_old->seo_keywords;
        $cmsHistoryModel->seo_description = $cms_old->seo_description;
        
        return $cmsHistoryModel->save();
    }
}
