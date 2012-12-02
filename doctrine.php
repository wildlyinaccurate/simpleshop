<?php
/**
 * Doctrine CLI bootstrap for CodeIgniter
 *
 * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
 * @link    http://wildlyinaccurate.com/integrating-doctrine-2-with-codeigniter-2
 */

// Small hack to enable the Doctrine console during development
function get_instance()
{
	return (object) array(
		'db' => (object) array(
			'dbprefix' => 'default_',
		),
	);
}

// Pretend that CodeIgniter and PyroCMS are initialized
define('APPPATH', __DIR__ . '/../../../../system/cms/');
define('BASEPATH', APPPATH . '/../system/');
define('ENVIRONMENT', 'development');
define('PYRO_DEVELOPMENT', 'development');
define('PYRO_PRODUCTION', 'production');

chdir(APPPATH);

require __DIR__ . '/libraries/Doctrine.php';

foreach ($GLOBALS as $helperSetCandidate) {
    if ($helperSetCandidate instanceof \Symfony\Component\Console\Helper\HelperSet) {
        $helperSet = $helperSetCandidate;
        break;
    }
}

$doctrine = new Doctrine;
$em = $doctrine->em;

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);
