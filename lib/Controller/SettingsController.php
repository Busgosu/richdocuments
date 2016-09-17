<?php
/**
 * ownCloud - Richdocuments App
 *
 * @author Victor Dubiniuk
 * @author Lukas Reschke
 * @copyright 2014 Victor Dubiniuk victor.dubiniuk@gmail.com
 * @copyright 2016 Lukas Reschke lukas@statuscode.ch
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 */

namespace OCA\Richdocuments\Controller;

use \OCP\AppFramework\Controller;
use OCP\IConfig;
use \OCP\IRequest;
use \OCP\IL10N;
use OCP\AppFramework\Http\TemplateResponse;

class SettingsController extends Controller {
	/** @var IL10N */
	private $l10n;
	/** @var IConfig */
	private $config;
	/** @var string */
	private $userId;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param IL10N $l10n
	 * @param IConfig $config
	 * @param string $UserId
	 */
	public function __construct($appName,
								IRequest $request,
								IL10N $l10n,
								IConfig $config,
								$UserId) {
		parent::__construct($appName, $request);
		$this->l10n = $l10n;
		$this->config = $config;
		$this->userId = $UserId;
	}

	/**
	 * @NoCSRFRequired
	 */
	public function adminIndex() {
		return new TemplateResponse(
			$this->appName,
			'admin',
			[
				'wopi_url' => $this->config->getAppValue($this->appName, 'wopi_url'),
			],
			'blank'
		);
	}
}
