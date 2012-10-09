<?php

require_once "phing/Task.php";
require_once "VersionControl/Git.php";

/**
 * The GitArchiveTask...
 *
 *
 * PHP version 5
 *
 * @package   phing.tasks.ext
 * @author    Michael Gatto <mgatto@lisantra.com>
 * @copyright 2012 Lisantra Technologies, LLC
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version   $Revision$
 * @link
 * @example
 */
class GitArchiveTask extends Task
{
    protected $sourceDir = null;
    protected $destinationDir = null;
    protected $destinationFormat = 'tgz';
    protected $tagBeforeArchiving = false;

    /**
     * Phing's main method.
     *
     * @return void
     */
    public function main()
    {
        $this->archive();
    }

}