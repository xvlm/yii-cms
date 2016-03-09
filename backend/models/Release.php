<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%release}}".
 *
 * @property integer $id
 * @property integer $catid
 * @property integer $typeid
 * @property string $title
 * @property string $style
 * @property string $thumb
 * @property string $keywords
 * @property string $template
 * @property string $layout
 * @property string $view
 * @property string $desc
 * @property string $url
 * @property integer $is_cache
 * @property integer $is_release
 * @property string $activity
 * @property string $search_url
 * @property integer $is_static
 * @property integer $time
 * @property string $username
 * @property integer $userid
 * @property integer $created
 * @property integer $updated
 * @property integer $status
 */
class Release extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%release}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'template', 'layout', 'view'], 'required'],
            [['id', 'catid', 'typeid', 'is_cache', 'is_release', 'is_static', 'time', 'userid', 'created', 'updated', 'status'], 'integer'],
            [['template'], 'string'],
            [['title', 'keywords'], 'string', 'max' => 80],
            [['style'], 'string', 'max' => 256],
            [['thumb', 'url'], 'string', 'max' => 100],
            [['layout', 'view', 'activity'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 500],
            [['search_url'], 'string', 'max' => 200],
            [['username'], 'string', 'max' => 20],
            [['view'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catid' => 'Catid',
            'typeid' => 'Typeid',
            'title' => 'Title',
            'style' => 'Style',
            'thumb' => 'Thumb',
            'keywords' => 'Keywords',
            'template' => 'Template',
            'layout' => 'Layout',
            'view' => 'View',
            'desc' => 'Desc',
            'url' => 'Url',
            'is_cache' => 'Is Cache',
            'is_release' => 'Is Release',
            'activity' => 'Activity',
            'search_url' => 'Search Url',
            'is_static' => 'Is Static',
            'time' => 'Time',
            'username' => 'Username',
            'userid' => 'Userid',
            'created' => 'Created',
            'updated' => 'Updated',
            'status' => 'Status',
        ];
    }
}
