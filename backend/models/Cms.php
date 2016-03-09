<?php

namespace backend\models;

use Yii;
use yii\web\NotFoundHttpException;
use backend\models\Release;

/**
 * This is the model class for table "{{%cms}}".
 *
 * @property integer $id
 * @property string $template
 * @property string $layout
 * @property string $view
 * @property string $desc
 * @property integer $is_cache
 * @property integer $is_release
 * @property integer $is_static
 * @property string $activity
 * @property string $search_url 
 * @property integer $time
 * @property integer $platform
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 */
class Cms extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template', 'desc', 'activity', 'view', 'platform'], 'required'],
            [['template'], 'string'],
            [['view'], 'string', 'max' => 50],
            [['view'], 'match', 'pattern' => '/^[a-zA-Z0-9_]{1,}$/', 'message' => \yii::t('app', '模板名称只能使用字母、数字、下划线的组合，不区分大小写')],
            [['view'], '\backend\validators\ViewValidator'],
            [['is_cache', 'is_release', 'is_static', 'time'], 'integer'],
            [['layout', 'view', 'activity'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 18],
            [['title'], 'string', 'max' => 18],
            [['search_url'], 'string', 'max' => 200],
            [['seo_title'], 'string', 'max' => 200],
            [['seo_keywords'], 'string', 'max' => 200],
            [['seo_description'], 'string', 'max' => 200]
        ];
    }

//    public function scenarios()
//    {
//        return [
//            'index' => ['desc', 'is_cache', 'is_release', 'activity', 'view', 'search_url'],
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template' => 'Content',
            'layout' => 'Layout',
            'view' => Yii::t('app','页面名称'),
            'desc' => Yii::t('app','描述'),
            'is_cache' => Yii::t('app','是否缓存'),
            'is_release' => Yii::t('app','是否发布'),
            'is_static' => Yii::t('app','是否静态化'),
            'activity' => Yii::t('app','所属模板'),
            'search_url' => 'Search Url',
            'time' => 'Time',
            'platform' => '平台',
            'seo_title' => 'title',
            'seo_keywords' => 'keywords',
            'seo_description' => 'description',
        ];
    }

    public function findModel($id)
    {
        if (($model = Cms::findOne($id)) !== null)
        {
            return $model;
        } else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 发布操作
     * @return type
     */
    public function release()
    {
        if (($releaseModel = Release::findOne($this->id)) === null)
        {
            $releaseModel = new Release();
        }
        $releaseModel->id = $this->id;
        $releaseModel->template = $this->template;
        $releaseModel->view = $this->view;
        $releaseModel->layout = $this->layout;
        $releaseModel->is_cache = $this->is_cache;
        $releaseModel->search_url = $this->search_url;
        $releaseModel->platform = $this->platform;
        $releaseModel->seo_title = $this->seo_title;
        $releaseModel->seo_keywords = $this->seo_keywords;
        $releaseModel->seo_description = $this->seo_description;
        
        if($releaseModel->save()){
            $this->is_release = 1;
            $this->status = 1;
            $status = $this->save();
        }else{
            $errors = $releaseModel->getErrors();
            $key = key($errors);
            Yii::$app->session->setFlash('error', $errors[$key][0]);
            return false;
        }
        return $status;
    }

    public function switchStatus($attribute)
    {
        // 切换状态
        $this->$attribute = $this->$attribute ? 0 : 1;
        return $this->save();
    }

}
