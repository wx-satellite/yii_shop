<p>尊敬的用户，您好：</p>

<p>您的找回密码链接如下：</p>

<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['admin/password/change-password', 'token' => $token]); ?>
<p><a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>

<p>该链接10分钟内有效，请勿传递给别人！</p>

<p>该邮件为系统自动发送，请勿回复！</p>
