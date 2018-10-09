<p>尊敬的用户，您好：</p>

<p>您的账号激活链接如下：</p>

<?php $url = \Yii::$app->urlManager->createAbsoluteUrl(['login/active', 'token' => $token]); ?>
<p><a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>


<p>该邮件为系统自动发送，请勿回复！</p>
