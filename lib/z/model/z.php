<?php

include_once('chenliujin/mysql/Model.class.php');

if (empty(Model::$dbo)) {
	Model::$host = '192.168.145.129';
	Model::$dbName = 'zzrig';
	Model::$dbUser = 'zzrig';
	Model::$dbPwd   = 'zzrig';
	Model::$dbo = new Model;
}

