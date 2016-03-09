<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\action;

use Yii;
use frontend\models\WidgetApi;
use common\helpers\CommercialHelper;
use yii\web\NotFoundHttpException;
use yii\web\ViewAction;

/**
 * ViewAction represents an action that displays a view according to a user-specified parameter.
 *
 * By default, the view being displayed is specified via the `view` GET parameter.
 * The name of the GET parameter can be customized via [[viewParam]].
 *
 * Users specify a view in the format of `path/to/view`, which translates to the view name
 * `ViewPrefix/path/to/view` where `ViewPrefix` is given by [[viewPrefix]]. The view will then
 * be rendered by the [[\yii\base\Controller::render()|render()]] method of the currently active controller.
 *
 * Note that the user-specified view name must start with a word character and can only contain
 * word characters, forward slashes, dots and dashes.
 *
 * @author Alexander Makarov <sam@rmcreative.ru>
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MyViewAction extends ViewAction
{
    public $viewContent;
    public $isHistories = false;
    public $searchUrl = '';
    public $seoInfo = [];
    /**
     * Runs the action.
     * This method displays the view requested by the user.
     * @throws NotFoundHttpException if the view file cannot be found
     */
    public function run()
    {
        //判断当前route是否在配置项中，如不在，则渲染一个空白的框架。
            $viewName = $this->defaultView;
            //历史版本预览与发布版本预览有不同的逻辑
            if($this->isHistories === FALSE){
                $this->viewContent = $this->resolveViewContent();
            }else{
                $this->viewContent = $this->resolveViewHistoriesContent();
            }
       
        

        $controllerLayout = null;
        if ($this->layout !== null) {
            $controllerLayout = $this->controller->layout;
            $this->controller->layout = $this->layout;
        }

        try {
            $output = $this->render($viewName);

            if ($controllerLayout) {
                $this->controller->layout = $controllerLayout;
            }

        } catch (InvalidParamException $e) {

            if ($controllerLayout) {
                $this->controller->layout = $controllerLayout;
            }

            if (YII_DEBUG) {
                throw new NotFoundHttpException($e->getMessage());
            } else {
                throw new NotFoundHttpException(
                    Yii::t('yii', 'The requested view "{name}" was not found.', ['name' => $viewName])
                );
            }
        }

        return $output;
    }

    /**
     * Renders a view
     *
     * @param string $viewName view name
     * @return string result of the rendering
     */
    protected function render($viewName)
    {
        return $this->controller->render(
                $viewName ,
                [
                    'content' => $this->viewContent, 
                    'title' => $this->seoInfo['title'], 
                    'keywords' => $this->seoInfo['keywords'], 
                    'description' => $this->seoInfo['description']
                ]
            );
    }
    
    protected function resolveViewContent()
    {
        $clear_cache_view = Yii::$app->request->get('clear_cache_view');
   
        $this->viewPrefix = '';
        $viewName = parent::resolveViewName();
        //入口controller为sandbox的话，为预览模式不进行缓存直接渲染
        if($this->controller->className() != 'frontend\controllers\SandboxController'){
            $key = $this->controller->className() . '/' . $viewName;
            $obj = Yii::$app->cache->get($key);
            
            if($obj === false){
                $obj = \backend\models\Release::findOne(['view'=>$viewName, 'platform' => 1]);
                //如果在发布表中没有找到该记录，说明为未发布状态，clear_cache_view为空说明不是由CMS管理页面发起的清除缓存操作，则报错
                if(is_null($obj) === TRUE && empty($clear_cache_view)){
                    throw new NotFoundHttpException(
                        Yii::t('yii', 'The requested view "{name}" was not found.', ['name' => $viewName])
                    );
                }else if(is_null($obj) === TRUE && !empty($clear_cache_view)){//由CMS管理页面发起的清除缓存操作，但因为没有缓存，直接返回成功
                    echo "clear success";exit;
                }
            }
            
            //已设置缓存，并且没有清除缓存操作，则设置缓存
            if($obj->is_cache && $viewName != $clear_cache_view){
                Yii::$app->cache->set($key,$obj,600);//#todo this is a params neeed to be set added by hezll 1121
            }else{
                Yii::$app->cache->delete($key);
                $obj = \backend\models\Release::findOne(['view'=>$viewName, 'platform' => 1]);
            }
        }else{//预览模式，直接渲染
            $obj = \backend\models\Cms::find()->where("view = '".$viewName."' and status != -1 and platform = 1")->one();
        }
        
        if($obj !== null){
            $this->layout = $obj->layout;
            $view = $this->controller->getView();
            $view->params['search_url'] = $obj->search_url;
            //将模板中的广告位解析出来
            $html = $this->process($obj->template);
            
//            $html = CommercialHelper::parse($obj->template);
            //保存SEO信息
            $this->seoInfo = ['title' => $obj->seo_title, 'keywords' => $obj->seo_keywords, 'description' => $obj->seo_description];
        }else{
            throw new NotFoundHttpException(
                Yii::t('yii', 'The requested view "{name}" was not found.', ['name' => $viewName])
            );
        }
        
        return $html;
    }
    
    protected function resolveViewHistoriesContent(){
        $this->viewPrefix = '';
        $viewName = parent::resolveViewName();
        
        $obj = \backend\models\CmsHistory::findOne(['id'=>$viewName, 'platform' => 1]);
            
        $this->layout = $obj->layout;
        $view = $this->controller->getView();
        $view->params['search_url'] = $obj->search_url;
        //$html = $this->process($obj->template);
        $html = CommercialHelper::parse($obj->template);
        //保存SEO信息
        $this->seoInfo = ['title' => $obj->seo_title, 'keywords' => $obj->seo_keywords, 'description' => $obj->seo_description];
        
        return $html;
    }

    protected function process($html){
        preg_match_all("/\{[a-zA-Z0-9]*.ads.[0-9]*\}/i", $html, $matches);
        foreach($matches[0] as $item){
            $adWidget = $this->getWidget($item);
            $html = strtr($html, [$item => $adWidget]);
        }
        return $html;
    }
    
    protected function getWidget($item){
        $html = '';
        $widgetInfo = explode('.',rtrim(ltrim($item,'{'),'}'));
        $str = '\frontend\widgets\\'.$widgetInfo[0];
        if(class_exists($str) === TRUE){
        //获取配置信息，填入widget函数中
        $key = $widgetInfo[0].$widgetInfo[2];
        //$html = Yii::$app->cache->get($key);
        //这周是临时的，以后会删除
        $html = false;
        if($html === false){
            $model = new WidgetApi();
            //从tooling获取广告位配置信息
            $re = $model->getWidget($widgetInfo[2]);
            $html = base64_decode(stripslashes($re['widget']['emtext'][0]['textcontent']));
            //缓存接口内容
            $is_cache = true;//从接口数据中读出
            $timeout = 3600;//从接口数据中读出
            if($is_cache === true){
                Yii::$app->cache->set($key,$html,$timeout);
            }
        }
        
        /*$html = $str::widget([
            'liArray'=>[
                [
                    'url' => Url::to(['gallery/']),
                    'imgUrl' => 'http://ecomgq-images.oss.aliyuncs.com/bc/b4/f9/c9bef3662254bdfad6891c8e463c3c0a2f7.jpg?1429118642#w', 
                ],
                [
                    'url' => Url::to(['gallery/']),
                    'imgUrl' => 'http://ecomgq-images.oss.aliyuncs.com/e8/28/1a/f9e43a9f2a4434967fdb1492245e07dfce9.jpg?1431421477#w',
                ],
                [
                    'url' => Url::to(['gallery/']),
                    'imgUrl' => 'http://ecomgq-images.oss.aliyuncs.com/54/97/c9/a7def3cfef6d90fcd10f81df54d01b8c4c3.jpg?1433400681#w',
                ],
            ],
        ]);*/
        //print_r($re);exit;
        //echo stripslashes($re['widget']['emproducts'][0]['proudctscontent']);exit;
        }
        return $html;
    }
    
}
