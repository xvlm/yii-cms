<?php

namespace backend\validators;

use Yii;
use yii\validators\Validator;

class ViewValidator extends Validator
{

    public $message;
    
     public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('app', 'view已存在');
        }
    }
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        $where = '';
        if(!empty($model->id)){
            $where = ' and id != '.$model->id;
        }
        
        $count = \backend\models\Cms::find()->where("view = '".$value."' and status != -1 and platform = '".$model->platform."'".$where)->count();
        
        if ($count >= 1)
        {
            $this->addError($model, $attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {


//        $message = json_encode($this->message);
//
//        return <<<JS
//
//    	var re = $this->postcodePattern;
//    	if(re.test(value)==false){
//    		 messages.push($message);
//    	}
//
//JS;
    }

}

?>
