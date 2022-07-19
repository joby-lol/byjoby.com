<?php
// used for running cron from the command line, such as with cron jobs
// note that for this to work you must have a urls.protocol and urls.domain manually configured

use DigraphCMS\Context;
use DigraphCMS\Cron\Cron;
use DigraphCMS\URL\URL;
use DigraphCMS\URL\URLs;
use DigraphCMS\URL\WaybackMachine;

if (file_exists(__DIR__.'/../.maintenance')) exit();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../initialize.php';

// deactivate wayback machine so that it doesn't generate
// useless notifications based on a root URL context
WaybackMachine::deactivate();

// set up a reasonable context
URLs::beginContext(new URL('/'));
Context::begin();
Context::url(new URL('/'));

// run cron jobs
set_time_limit(300);
Cron::runJobs(time() + 120);
