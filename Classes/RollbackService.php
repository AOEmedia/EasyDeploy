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


/**
 *
 * 
 * @author: Michael Klapper <michael.klapper@aoemedia.de>
 * @date: 28.10.11
 * @time: 15:41
 */
class EasyDeploy_RollbackService {

	/**
	 * @var array
	 */
	private $allowedEnvironments = array(
		'staging',
		'production'
	);

	/**
	 * Environment can be "staging" or "production"
	 * @var string
	 */
	private $environment;

	/**
	 * Target path for the installation
	 * @var string
	 */
	private $systemPath;

	/**
	 * @param string $environment
	 * @return void
	 */
	public function setEnvironment($environment) {
		if (!in_array($environment, $this->allowedEnvironments)) {
			throw new UnexpectedValueException('Environment must be: ' . PHP_EOL . '- ' . implode(PHP_EOL . '- ', $this->allowedEnvironments) . PHP_EOL . PHP_EOL);
		}
		$this->environment = $environment;
	}

	/**
	 * This is not the path to web root!
	 *
	 * @param string $systemPath
	 * @return void
	 */
	public function setSystemPath($systemPath) {
		$this->systemPath = $systemPath;
	}

	/**
	 * Switch active with inactive environment.
	 *
	 * @param EasyDeploy_AbstractServer $server
	 * @return void
	 */
	public function process(EasyDeploy_AbstractServer $server) {

		if ($server->isLink($this->systemPath)) {
			
		}

		$command =<<<EOD
cd $this->systemPath \
&& ln -s {TARGET_PORTAL} {SYSTEM_INSTANCE_NAME}_tmp
&& mv -Tf {SYSTEM_INSTANCE_NAME}_tmp {SYSTEM_INSTANCE_NAME}
EOD;

		$server->run($command);
	}
}