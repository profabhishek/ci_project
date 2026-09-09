<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
    'hostname' => getenv('CI_DB_HOST') ? getenv('CI_DB_HOST') : 'localhost',
    'username' => getenv('CI_DB_USER') ? getenv('CI_DB_USER') : 'root',
    'password' => getenv('CI_DB_PASS') ? getenv('CI_DB_PASS') : '',
    'database' => getenv('CI_DB_NAME') ? getenv('CI_DB_NAME') : 'iccr_db_new',
    'dbdriver' => 'mysqli',
	'dbprefix' => 'iccr_',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
