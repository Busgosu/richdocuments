<?php
/**
 * ownCloud - Richdocuments App
 *
 * @author Frank Karlitschek
 * @author Lukas REschke
 * @copyright 2013-2014 Frank Karlitschek karlitschek@kde.org
 * @copyright 2016 Lukas Reschke lukas@statuscode.ch
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Richdocuments\AppInfo;

\OCP\App::registerAdmin('richdocuments', 'admin');

//Script for registering file actions
$eventDispatcher = \OC::$server->getEventDispatcher();
$eventDispatcher->addListener(
	'OCA\Files::loadAdditionalScripts',
	function() {
		\OCP\Util::addScript('richdocuments', 'viewer/viewer');
		\OCP\Util::addStyle('richdocuments', 'viewer/odfviewer');
	}
);
