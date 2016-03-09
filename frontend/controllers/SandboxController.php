<?php

namespace frontend\controllers;

use yii\web\Controller;
/**
 * Site controller
 */
class SandboxController extends Controller 
{
    public function actions()
    {
        return [
            'page' => [
                'class' => 'frontend\action\MyViewAction',
                'layout' => 'article',
                'viewPrefix' => '/article/pages',
            ],
            'Histories' => [
                'class' => 'frontend\action\MyViewAction',
                'isHistories' => true,
            ],
        ];            
    }
}



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

