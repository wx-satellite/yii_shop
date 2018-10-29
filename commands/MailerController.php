<?php


namespace app\commands;

use yii\console\Controller;


class MailerController extends Controller{


    public function actionSend(){
        return \Yii::$app->mailer->sendMailFromRedis();
    }
}