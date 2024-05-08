<?php
namespace SyncDataCms\Constants;
class Url{
	const REGISTER_PERMISTION_HARAVAN = 'register-permistion-haravan';
	const CALLBACK_PERMISTION_HARAVAN = 'callback-haravan';
	const URL_CONNECT_AUTHORIZE = 'https://accounts.haravan.com/connect/authorize?response_mode= %s &response_type= %s &scope= %s &client_id= %s &redirect_uri= %s ';

	const URL_SYNC_DATA_HARAVAN = 'sync-data-haravan';
}