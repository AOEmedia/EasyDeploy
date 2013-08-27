<?php
/**
 * Copyright notice
 *
 * (c) 2011 AOE media GmbH <dev@aoemedia.de>
 * All rights reserved
 *
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

require_once(dirname(__FILE__) . '/AbstractServer.php');

/**
 * Represents a local server
 *
 * @author Daniel Pötzinger
 */
class EasyDeploy_LocalServer extends EasyDeploy_AbstractServer {

	/**
	 * Runs the given command local
	 *
	 * @param string $command
	 * @param boolean $withInteraction set to true if the command should stay open and wait for STDIN
	 * @param boolean $returnOutput set to true if you need the result - otherwise its directed to STDOUT
	 * @param string $appendOutputToFile set to a valid existing file (on current OS context) to write the output directly to a file
	 * @throws EasyDeploy_Exception_CommandFailedException
	 * @return string"null
	 */
	public function run($command, $withInteraction = false, $returnOutput = false, $appendOutputToFile = null) {
		$result = $this->executeCommand($command, $returnOutput,
			$this->getStreamDescriptor($returnOutput, $appendOutputToFile)
		);
		if ($result['returncode'] != 0) {
			throw new EasyDeploy_Exception_CommandFailedException('"' . $command . '" failed: ' . $result['error']);
		}
		if ($returnOutput) {
			return $result['out'];
		}

		return null;
	}

	/**
	 * @param string $from
	 * @param string $to
	 */
	public function copyLocalFile($from, $to) {
		$this->executeCommand('cp ' . escapeshellarg($from) . ' ' . escapeshellarg($to));
	}

	/**
	 * @param string $from
	 * @param string $to
	 */
	public function copyLocalDir($from, $to) {
		$this->executeCommand('cp -r ' . escapeshellarg($from) . ' ' . escapeshellarg($to));
	}

	/**
	 * @param string $path
	 * @return bool
	 */
	public function isLink($path) {
		return is_link(rtrim($path, '/'));
	}

	/**
	 * @param string $dir
	 * @return boolean
	 */
	public function isDir($dir) {
		return is_dir($dir);
	}

	/**
	 * @param string $dir
	 * @return boolean
	 */
	public function isFile($dir) {
		clearstatcache();

		return is_file($dir);
	}

}
