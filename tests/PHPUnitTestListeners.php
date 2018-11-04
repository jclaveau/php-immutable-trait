<?php

// namespace BR\PHPUnitTestListeners;

use PHPUnit_Framework_TestListener;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;
use PHPUnit_Framework_AssertionFailedError;
use Exception;

/**
 * @author Baldur Rensch <brensch@gmail.com>
 */
class XHGuiTestListener implements PHPUnit_Framework_TestListener
{
    protected $dbHost;
    protected $dbName;
    protected $dbUser;
    protected $dbPass;
    protected $applicationName;

    public function __construct($dbHost, $dbName, $dbUser, $dbPass, $applicationName)
    {
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->applicationName = $applicationName;
    }

    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        $xhprof_data = xhprof_disable();

        $pmu = isset($xhprof_data['main()']['pmu']) ? $xhprof_data['main()']['pmu'] : '';
        $wt  = isset($xhprof_data['main()']['wt'])  ? $xhprof_data['main()']['wt']  : '';
        $cpu = isset($xhprof_data['main()']['cpu']) ? $xhprof_data['main()']['cpu'] : '';
        $url = 'phpunit::' . $test->getName();

        $xhprof_runs = new \XHProfRuns_Default();

        $run_id = $xhprof_runs->save_run($xhprof_data, $this->applicationName);

        $sql = 'INSERT INTO xhprof (`id`, `url`, `c_url`, `timestamp`, `server name`, `perfdata`, `type`, `cookie`, `post`, `get`, `pmu`, `wt`, `cpu`,
            `server_id`, `aggregateCalls_include`)
            VALUES (:run_id, :url, :canonical_url, null, :server_name, :perfdata, 0, :cookie, :post, :get, :pmu, :wt, :cpu, :server_id, \'\');';

        $pdo = $this->getDatabaseHandle();
        $statement = $pdo->prepare($sql);

        $statement->bindValue('run_id', $run_id);
        $statement->bindValue('url', $url);
        $statement->bindValue('canonical_url', $url);
        $statement->bindValue('server_name', 'phpunit');
        $statement->bindValue('perfdata',  gzcompress(json_encode($xhprof_data), 2));
        $statement->bindValue('cookie', json_encode(array()));
        $statement->bindValue('post', json_encode(array()));
        $statement->bindValue('get', json_encode(array()));
        $statement->bindValue('pmu', $pmu);
        $statement->bindValue('wt', $wt);
        $statement->bindValue('cpu', $cpu);
        $statement->bindValue('server_id', 'phpunit');

        $statement->execute();

    }

    private function getDatabaseHandle()
    {
        $pdo = new \PDO(
            "mysql:host={$this->dbHost};dbname={this->dbName}",
            $this->dbUser,
            $this->dbPpass
        );

        return $pdo;
    }

    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
    }

    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
    }

    public function startTest(PHPUnit_Framework_Test $test)
    {
        xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
    }

    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }

    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
    }
}
