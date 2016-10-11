<?php

include_once('chenliujin/mysql/Model.class.php');
include_once('chenliujin/mysql/Page.php');

if (empty(Model::$dbo)) {
	Model::$host = '192.168.145.129';
	Model::$dbName = 'zzrig';
	Model::$dbUser = 'zzrig';
	Model::$dbPwd   = 'zzrig';
	Model::$dbo = new Model;
}

