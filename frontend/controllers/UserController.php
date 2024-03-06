<?php

namespace frontend\controllers;

use frontend\App\Proto\BaseModel;
use frontend\App\Proto\Person;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\App\Proto\People;

class UserController extends Controller
{

    public function actionIndex()
    {
        $people = new People();
        $people->setPeople([
            (function () {
                $p = new Person();
                $p->setBaseModel((function () {
                    $bm = new BaseModel();
                    $bm->setId(1);

                    return $bm;
                })());
                $p->setName('Valian Masdani');
                $p->setAddress('Indonesia');

                return $p;
            })(),
            (function () {
                $p = new Person();
                $p->setBaseModel((function () {
                    $bm = new BaseModel();
                    $bm->setId(2);

                    return $bm;
                })());
                $p->setName('Shania N');
                $p->setAddress('Indonesia');

                return $p;
            })(),
        ]);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $people->serializeToJsonString();
    }
}
