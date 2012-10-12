<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */
require_once "phing/Task.php";
require_once 'phing/tasks/ext/git/GitBaseTask.php';

/**
 * Wraps `git archive`
 *
 *
 * PHP version 5
 *
 * @version   $Revision$
 * @package   phing.tasks.ext
 * @since
 * @author    Michael Gatto <mgatto@lisantra.com>
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @see       VersionControl_Git
 */
class GitArchiveTask extends GitBaseTask
{
    /**
     * Which revision at which to generate the archive
     *
     * @var string
     */
    protected $revision = 'HEAD';

    /**
     * Where to save the generated archive
     *
     * Defaults to current working directory
     *
     * @var string
     */
    protected $output = '.';

    /**
     * The directory to prepend paths in the archive
     *
     *  Defaults to none
     *
     * @var string
     */
    protected $prefix = null;

    /**
     * restrict archive to these paths only
     *
     * @var mixed
     */
    protected $path = array();

    /**
     * The archive format
     *
     * Defaults to tar.gz; compeltely arbituary choice
     *
     * @var string
     */
    protected $format = 'tar.gz';

    /**
     * Phing's main method.
     *
     * @return void
     */
    public function main()
    {
        /** Validation
         *
         * Most options have defaults built into this class's properties, thus
         * no need to validate them explicitly.
         */
        /* inherited from GitBaseTask */
        if (null === $this->getRepository()) {
            throw new BuildException('"repository" is required parameter');
        }

        /* Get the archive command setup from VersionControl_Git */
        $client = $this->getGitClient(false, $this->getRepository());
        $command = $client->getCommand('archive');

        /* set options */
        $command
            ->setOption('format', $this->getFormat())
            ->setOption('output', $this->getOutput())
            ->setOption('prefix', $this->getPrefix())
            ->setOption('path', $this->getPath());

        /* what to archive; its an argument to git archive */
        $command->addArgument($this->getRevision());

        $this->log(
            sprintf('git-archive command: %s', $command->createCommandString()),
            Project::MSG_INFO
        );

        try {
            $output = $command->execute();

        } catch (Exception $e) {
            throw new BuildException('Task execution failed.');
        }

        /* the command apparently succeeded */
        $this->log(
            sprintf('git-archive: archive "%s" repository', $this->getRepository()),
            Project::MSG_INFO
        );
        $this->log(
            sprintf('git-archive output: %s', trim($output)),
            Project::MSG_INFO
        );
    }

    /**
     * @return string
     */
    public function isFormat()
    {
        return $this->getFormat();
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return void
     * @throws BuildException
     */
    public function setFormat($format)
    {
        /** Validate formats */
        $permitted_formats = array('gz', 'tar', 'tar.gz', 'tgz');
        if (!in_array($format, $permitted_formats)) {
            throw new BuildException(
                sprintf("Archive format '%s' must be one of %s",
                        $format,
                        join(', ', $permitted_formats)
                )
            );
        }

        $this->format = $format;
    }

    /**
     * @return string
     */
    protected function getRevision()
    {
        return $this->revision;
    }

    /**
     * @param $revision
     */
    protected function setRevision($revision)
    {
        $this->revision = $revision;
    }

    /**
     * @return string
     */
    protected function getOutput()
    {
        return $this->output;
    }

    /**
     * @param $output
     */
    protected function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param $prefix
     */
    protected function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return mixed
     */
    protected function getPath()
    {
        return $this->path;
    }

    /**
     * @param $path
     */
    protected function setPath($path)
    {
        $this->path = $path;
    }

}
