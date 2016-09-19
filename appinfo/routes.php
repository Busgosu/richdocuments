<?php
/**
 * ownCloud - Richdocuments App
 *
 * @author Victor Dubiniuk
 * @copyright 2013-2014 Victor Dubiniuk victor.dubiniuk@gmail.com
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 */

namespace OCA\Richdocuments;

use OCP\AppFramework\App;

$application = new App('richdocuments');
$application->registerRoutes($this, [
	'routes' => [
		//documents
		['name' => 'document#index', 'url' => 'index', 'verb' => 'GET'],
		['name' => 'document#create', 'url' => 'ajax/documents/create', 'verb' => 'POST'],
		['name' => 'document#rename', 'url' => 'ajax/documents/rename/{fileId}', 'verb' => 'POST'],
		['name' => 'document#get', 'url' => 'ajax/documents/get/{fileId}', 'verb' => 'GET'],
		['name' => 'document#listAll', 'url' => 'ajax/documents/list', 'verb' => 'GET'],
		//documents - for WOPI access
		['name' => 'document#wopiGetToken', 'url' => 'wopi/token/{fileId}', 'verb' => 'GET'],
		['name' => 'document#wopiCheckFileInfo', 'url' => 'wopi/files/{fileId}', 'verb' => 'GET'],
		['name' => 'document#wopiGetFile', 'url' => 'wopi/files/{fileId}/contents', 'verb' => 'GET'],
		['name' => 'document#wopiPutFile', 'url' => 'wopi/files/{fileId}/contents', 'verb' => 'POST'],
		//settings
		['name' => 'settings#setSettings', 'url' => 'ajax/admin.php', 'verb' => 'POST'],
		['name' => 'settings#getSupportedMimes', 'url' => 'ajax/mimes.php', 'verb' => 'GET'],
	]
]);
