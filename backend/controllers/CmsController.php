<?php

namespace backend\controllers;

use Yii;
use backend\models\Cms;
use backend\models\CmsSearch;
use backend\models\CmsHistory;
use backend\models\Release;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use common\helpers\Tools;

/**
 * CmsController implements the CRUD actions for Cms model.
 */
class CmsController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                //'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $userId = Yii::$app->user->getId();
        $errorMsg ="test";
//        Tools::error('99031', $errorMsg);

        return parent::beforeAction($action);
    }

    /**
     * Lists all Cms models.
     * @return mixed
     */
    public function actionIndex($pagesize = 10) {


        $searchModel = new CmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /**
         * 这里是处理搜索与每页显示条数的参数，是GridView使用js的必须参数
         */
        $filterSelector = "#DataTables_Table_0_filter input, #DataTables_Table_0_length select";
        $options = [
            'filterUrl' => Url::to(['cms/index']),
            'filterSelector' => $filterSelector,
        ];

        $en_options = Json::htmlEncode($options);

        /**
         * 处理分页，设置每页显示的条数
         */
        $dataProvider->pagination->pageSizeLimit = [1, 100];
        $dataProvider->pagination->setPageSize($pagesize, true);

        //记录当前页面URL，以便操作之后返回
        Url::remember();

        $platform = isset($_COOKIE['platform']) ? $_COOKIE['platform'] : setcookie('platform', 1, time() + 3600 * 24 * 30, '/');

        return $this->render('index_new', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'options' => $en_options, //Json::htmlEncode($options),// ??
                    'pagesize' => $pagesize,
                    'platform' => $platform,
        ]);
    }

    /**
     * Displays a single Cms model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Cms();

        /**
         * 注意此处为ajax验证，需要在html中的$form->field($model, 'identityNumber',['enableAjaxValidation'=>true])...
         * 多用于验证规则复杂或者需要调用后端接口的时候
         */
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) ) {
//            Tools::checkRepeatSubmit();

            $model->time = time();
            $model->layout = Yii::$app->params['activityConf'][$model->platform][$model->activity]['layout'];

            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                throw new NotFoundHttpException('create error');
            }
        } else {
            $platform = isset($_COOKIE['platform']) ? $_COOKIE['platform'] : setcookie('platform', 1, time() + 3600 * 24 * 30, '/');
            foreach (Yii::$app->params['activityConf'][$platform] as $key => $val) {
                $activity[$key] = Yii::t('app', $val['name']);
            }
            $model->platform = $platform;
            return $this->render('create', [
                        'model' => $model,
                        'activity' => $activity,
                        'platform' => $platform,
            ]);
        }
    }

    /**
     * Updates an existing Cms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $model = $this->findModel($id);

        /**
         * 注意此处为ajax验证，需要在html中的$form->field($model, 'identityNumber',['enableAjaxValidation'=>true])...
         * 多用于验证规则复杂或者需要调用后端接口的时候
         */
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            Tools::checkRepeatSubmit();

            $model->time = time();
            $model->status = $model->status == 0 ? 0 : 2;
            $model->layout = Yii::$app->params['activityConf'][$model->platform][$model->activity]['layout'];

            if ($model->save()) {
                if (Url::previous() == '/') {
                    return $this->redirect(['index']);
                } else {
                    return $this->goBack();
                }
            } else {
                $error = $model->getErrors();
                print_r($error);
                exit;
            }
        } else {
            $history = new CmsHistory();
            $dataProvider = $history->getCmsHistoryById($id);
            foreach (Yii::$app->params['activityConf'][$model->platform] as $key => $val) {
                $activity[$key] = Yii::t('app', $val['name']);
            }
            return $this->render('update', [
                        'model' => $model,
                        'activity' => $activity,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * 复制模板
     * @param type $id
     * @return type
     * @throws NotFoundHttpException
     */
    public function actionCopy($id) {

        $model = new Cms();

        /**
         * 注意此处为ajax验证，需要在html中的$form->field($model, 'identityNumber',['enableAjaxValidation'=>true])...
         * 多用于验证规则复杂或者需要调用后端接口的时候
         */
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            Tools::checkRepeatSubmit();

            $model->time = time();
            $model->layout = Yii::$app->params['activityConf'][$model->platform][$model->activity]['layout'];

            if ($model->save()) {
                if (Url::previous() == '/') {
                    return $this->redirect(['index']);
                } else {
                    return $this->goBack();
                }
            } else {
                throw new NotFoundHttpException('create error');
            }
        } else {
            $viewModel = $this->findModel($id);
            foreach (Yii::$app->params['activityConf'][$viewModel->platform] as $key => $val) {
                $activity[$key] = Yii::t('app', $val['name']);
            }
            return $this->render('create', [
                        'model' => $viewModel,
                        'activity' => $activity,
            ]);
        }
    }

    /**
     * Deletes an existing Cms model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model->status > 0) {
            Release::findOne($id)->delete();
            if ($model->is_cache == 1) {
                $this->actionUncache($model->id);
            }
            if ($model->is_static == 1) {
                $this->actionStatic($model->id, $model->view, false);
            }
        }
        $model->status = -1;
        if (!$model->save()) {
            Tools::error('99007', '', 'alert');
        }

        if (Url::previous() == '/') {
            return $this->redirect(['index']);
        } else {
            return $this->goBack();
        }
    }

    /**
     * 设置历史记录回滚
     * @param type $id
     * @param type $historyId
     * @return type
     * @throws NotFoundHttpException
     */
    public function actionSet($id, $historyId) {
        $model = $this->findModel($id);
        $history_model = new CmsHistory();
        $history = $history_model->findOne($historyId);

        $model->template = $history->template;
        $model->status = $model->status == 0 ? 0 : 2;

        if (CmsHistory::createHistory($id) && $model->save()) {
            if (Url::previous() == '/') {
                return $this->redirect(['index']);
            } else {
                return $this->goBack();
            }
        } else {
            throw new NotFoundHttpException('version set error');
        }
    }

    /**
     * 预览
     * @param type $view
     */
    public function actionPreview($view, $platform) {
        if ($platform == 1) {
            $url = Yii::getAlias('@frontendUrl') . Url::to(['sandbox/page', 'view' => $view]);
        } else {
            $url = Yii::getAlias('@mobileUrl') . Url::to(['sandbox/page', 'view' => $view]);
        }
        $this->redirect($url, 301);
    }

    /**
     * 预览
     * @param type $view
     */
    public function actionOnlinepreview($activity, $view, $platform) {
        $route = Yii::$app->params['activityConf'][$platform][$activity]['controller'] . '/page';
        if ($platform == 1) {
            $url = Yii::getAlias('@frontendUrl') . Url::to([$route, 'view' => $view]);
        } else {
            $url = Yii::getAlias('@mobileUrl') . Url::to([$route, 'view' => $view]);
        }
        $this->redirect($url, 301);
    }

    /**
     * 发布/撤销模版
     * @param integer $id
     * @return type
     */
    public function actionRelease($id, $is_jump = true) {
        $model = $this->findModel($id);
        //复制信息进入发布表
        $status = $model->status;

        if ($model->release()) {
            //判断是否为第一次发布，如果为更新发布则根据状态进行更新静态化和更新缓存操作
            if ($status == '2' && $model->is_cache) {
                #todo 此处有url bug added by hezll 1121
                //如果需要更新缓存则删除当前缓存，再次进入发布页时，就会重新生成缓存
                $route = Yii::$app->params['activityConf'][$model->platform][$model->activity]['controller'] . '/page';
                $url = Yii::getAlias('@frontendUrl') . Url::to([$route, 'view' => $model->view, 'clear_cache_view' => $model->view]);
                file_get_contents($url);
            }
            if ($status == '2' && $model->is_static) {
                $this->actionUpdatestatic($model->view, $model->activity, false);
            }
        } else {
            Tools::error('99007', '', 'alert');
        }
        if ($is_jump === TRUE) {
            if (Url::previous() == '/') {
                return $this->redirect(['index']);
            } else {
                return $this->goBack();
            }
        }
    }

    public function actionUnrelease($id, $is_jump = true) {
        $model = $this->findModel($id);
        if (Release::findOne($id)->delete()) {
            $model->status = 0;
            $model->save();
            if ($model->is_static != 0) {
                $this->actionStatic($id, $model->view, false);
            }
            if ($model->is_cache != 0) {
                $this->actionUncache($id, false);
            }
        } else {
            Tools::error('99007', '', 'alert');
        }

        if ($is_jump) {
            if (Url::previous() == '/') {
                return $this->redirect(['index']);
            } else {
                return $this->goBack();
            }
        }
    }

    /**
     * 模板静态化
     * @param type $id
     * @return type
     */
    public function actionStatic($id, $view, $is_jump = true) {
        $model = $this->findModel($id);
        if ($model->is_static === 0) {
            $route = Yii::$app->params['activityConf'][$model->platform][$model->activity]['controller'] . '/page';
            $url = Yii::getAlias('@frontendUrl') . Url::to([$route, 'view' => $view]);

            if ($this->_createStaticFile($url, $view) === TRUE) {
                $model->switchStatus('is_static');
                Yii::$app->session->setFlash('success', '操作成功');
            } else {
                Tools::error('99007', '', 'alert');
            }
        } else {
            if (file_exists("../../s/" . $view . ".html")) {
                unlink("../../s/" . $view . ".html");
            }
            $model->switchStatus('is_static');
        }
        if ($is_jump === TRUE) {
            if (Url::previous() == '/') {
                return $this->redirect(['index']);
            } else {
                return $this->goBack();
            }
        }
    }

    public function actionUpdatestatic($platform, $view, $activity, $is_jump = true) {
        $route = Yii::$app->params['activityConf'][$platform][$activity]['controller'] . '/page';
        $url = Yii::getAlias('@frontendUrl') . Url::to([$route, 'view' => $view]);
        if ($this->_createStaticFile($url, $view) === TRUE) {
            Yii::$app->session->setFlash('success', '操作成功');
        } else {
            Tools::error('99007', '', 'alert');
        }

        if ($is_jump === TRUE) {
            if (Url::previous() == '/') {
                return $this->redirect(['index']);
            } else {
                return $this->goBack();
            }
        }
    }

    public function actionCache($id, $is_jump = true) {
        $model = $this->findModel($id);
        $model->is_cache = 1;
        $model->save();
        $releaseModel = Release::findOne($id);
        if (!is_null($releaseModel)) {
            $releaseModel->is_cache = 1;
            $releaseModel->save();
        }

        if ($is_jump === TRUE) {
            if (Url::previous() == '/') {
                return $this->redirect(['index']);
            } else {
                return $this->goBack();
            }
        }
    }

    public function actionUncache($id, $is_jump = true) {
        $model = $this->findModel($id);
        $model->is_cache = 0;
        $model->save();
        $releaseModel = Release::findOne($id);
        if (!is_null($releaseModel)) {
            $releaseModel->is_cache = 0;
            $releaseModel->save();
        }

        $route = Yii::$app->params['activityConf'][$model->platform][$model->activity]['controller'] . '/page';
        $url = Yii::getAlias('@frontendUrl') . Url::to([$route, 'view' => $model->view, 'clear_cache_view' => $model->view]);
        file_get_contents($url);

        if ($is_jump) {
            if (Url::previous() == '/') {
                return $this->redirect(['index']);
            } else {
                return $this->goBack();
            }
        }
    }

    /**
     * 设定语言： 1) 设置cookie，2) 跳转回原来的页面
     * 访问网址 - http://.../site/language?locale=zh-CN
     * @return [type] [description]
     */
    public function actionLanguage() {
        $locale = Yii::$app->request->get('locale');
        if ($locale) {
            #use cookie to store language
            $localeCookie = new yii\web\Cookie(['name' => 'locale', 'value' => $locale, 'expire' => 3600 * 24 * 30,]);
            $localeCookie->expire = time() + 3600 * 24 * 30;
            Yii::$app->response->cookies->add($localeCookie);
        }
        $this->goBack(Yii::$app->request->headers['Referer']);
    }

    public function actionPlatform() {
        $platform = Yii::$app->request->get('platform');
        if ($platform) {
            setcookie('platform', $platform, time() + 3600 * 24 * 30, '/');
        }
        $this->goBack(Yii::$app->request->headers['Referer']);
    }

    private function _createFolder() {
        try {
            $folderName = date('Ymd');
            if (is_dir('../../s/' . $folderName) === FALSE) {
                mkdir('../../s/' . $folderName, 0777, true);
            }
            return true;
        } catch (Exception $ex) {
            Yii::error('生成静态化目录失败');
            return false;
        }
    }

    private function _createStaticFile($url, $view) {
        try {
            if ($this->_createFolder() === TRUE) {
                ob_start();
                echo file_get_contents($url);
                $content = ob_get_contents();
                $content .= '<!-- This static page was created at ' . date('YmdHis') . '-->';
                //$fp = fopen("../../s/" .  date('Ymd').'/'. $view . ".html", "wb");
                $fp = fopen("../../s/" . $view . ".html", "wb");
                fwrite($fp, $content);
                fclose($fp);
                ob_get_clean();
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            Yii::error('静态化文件处理失败');
            return false;
        }
    }

    /**
     * Finds the Cms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Cms::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
