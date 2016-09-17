<?php
/**
 * ownCloud - Richdocuments App
 *
 * @author Victor Dubiniuk
 * @author Lukas Reschke
 *
 * @copyright 2014 Victor Dubiniuk victor.dubiniuk@gmail.com
 * @copyright 2016 Lukas Reschke lukas@statuscode.ch
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 */
namespace OCA\Richdocuments;

use OCP\AppFramework\App;
use OCP\AppFramework\Http\TemplateResponse;

$app = new App('richdocuments');
/** @var TemplateResponse $response */
$response = $app->getContainer()->query('\OCA\Richdocuments\Controller\SettingsController')->adminIndex();
return $response->render();

