<?php
/**
 * ownCloud - Richdocuments App
 *
 * @author Ashod Nakashian
 * @author Lukas Reschke
 * @copyright 2016 Ashod Nakashian ashod.nakashian@collabora.co.uk
 * @copyright 2016 Lukas Reschke lukas@statuscode.ch
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 */

namespace OCA\Richdocuments;

use OCP\AppFramework\Utility\ITimeFactory;
use OCP\Files\FileInfo;
use OCP\Files\IRootFolder;
use OCP\IDBConnection;
use OCP\Security\ISecureRandom;

class Wopi {
	// Tokens expire after this many seconds (not defined by WOPI specs).
	const TOKEN_LIFETIME_SECONDS = 1800;

	/** @var IDBConnection */
	private $connection;
	/** @var ISecureRandom */
	private $secureRandom;
	/** @var ITimeFactory */
	private $timeFactory;
	/** @var IRootFolder */
	private $rootFolder;
	/** @var string */
	private $UserId;

	/**
	 * @param IDBConnection $connection
	 * @param ISecureRandom $secureRandom
	 * @param ITimeFactory $timeFactory
	 * @param IRootFolder $rootFolder
	 * @param string $UserId
	 */
	public function __construct(IDBConnection $connection,
								ISecureRandom $secureRandom,
								ITimeFactory $timeFactory,
								IRootFolder $rootFolder,
								$UserId) {
		$this->connection = $connection;
		$this->secureRandom = $secureRandom;
		$this->timeFactory = $timeFactory;
		$this->rootFolder = $rootFolder;
		$this->UserId = $UserId;
	}

	/**
	 * Given a fileId and version, generates a token
	 * and stores in the database.
	 *
	 * version is 0 if current version of fileId is requested, otherwise
	 * its the version number as stored by files_version app
	 *
	 * @param int $fileId
	 * @param string $version
	 * @return string Token
	 * @throws \Exception
	 */
	public function generateFileToken($fileId, $version) {
		$view = $this->rootFolder->getUserFolder($this->UserId);
		$file = $view->getById($fileId)[0];

		if ($file->getType() !== FileInfo::TYPE_FILE || !$file->isUpdateable()) {
			throw new \Exception('Invalid fileId.');
		}

		$token = $this->secureRandom->generate(
			32,
			ISecureRandom::CHAR_LOWER .
			ISecureRandom::CHAR_UPPER .
			ISecureRandom::CHAR_DIGITS
		);

		$qb = $this->connection->getQueryBuilder();
		$qb
			->insert('richdocuments_wopi')
			->values(
				[
					'uid' => $this->UserId,
					'fileid' => $fileId,
					'version' => $version,
					'token' => $token,
					'expiry' => $this->timeFactory->getTime() + self::TOKEN_LIFETIME_SECONDS,
				]
			)
			->execute();

		return $token;
	}

	/**
	 * TODO
	 * Given a token, validates it and
	 * constructs and validates the path.
	 * Returns the path, if valid, else false.
	 */
	public function getPathForToken($fileId, $version, $token){

		$wopi = new Wopi();
		$row = $wopi->loadBy('token', $token)->getData();
		\OC::$server->getLogger()->debug('Loaded WOPI Token record: {row}.', [ 'row' => $row ]);
		if (count($row) == 0)
		{
			// Invalid token.
			http_response_code(401);
			return false;
		}

		//TODO: validate.
		if ($row['expiry'] > time()){
			// Expired token!
			//http_response_code(404);
			//$wopi->deleteBy('id', $row['id']);
			//return false;
		}
		if ($row['fileid'] != $fileId || $row['version'] != $version){
			// File unknown / user unauthorized (for the requested file).
			http_response_code(404);
			return false;
		}

		return array('owner' => $row['owner_uid'], 'editor' => $row['editor_uid'], 'path' => $row['path']);
	}
}
