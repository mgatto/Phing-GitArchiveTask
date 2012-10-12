<?php
/*
 *
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
 * @see VersionControl_Git
 */
class GitArchiveTask extends Task
{
    /**
     * @var 
     */
    protected $tag = null;
    
    /**
     * @var 
     */
    protected $output = null;
    
    /**
     * @var 
     */
    protected $prefix = null;
    
    /**
     * restrict archive to this path only
     * @var 
     */
    protected $path = null;
    
    /**
     * @var 
     */
    protected $format = 'tar.gz';
    
    /**
     * @var 
     */
    protected $tagOrBranchOrCommitToArchive = null;

    /**
     * Phing's main method.
     *
     * @return void
     */
    public function main()
    {
        /** Validation */
        /* Required; from GitBaseTask */
        if (null === $this->getRepository()) {
            throw new BuildException('"repository" is required parameter');
        }
        
        $client = $this->getGitClient(false, $this->getRepository());
        $command = $client->getCommand('archive');
                
        $command
            ->setOption('format', $this->isNoTrack())
            ->setOption('output', $this->isQuiet())
            ->setOption('prefix', $this->isCreate())
            ->setOption('path', $this->isForceCreate())
            ->setOption('tag', $this->isMerge());
  

        $command->addArgument($this->getBranchname());

        if (null !== $this->getStartPoint()) {
            $command->addArgument($this->getStartPoint());
        }

        $this->log('git-archive command: ' . $command->createCommandString(), Project::MSG_INFO);

        try {
            $output = $command->execute();
        } catch (Exception $e) {
            throw new BuildException('Task execution failed.');
        }

        $this->log(
            sprintf('git-archive: archive "%s" repository', $this->getRepository()), 
            Project::MSG_INFO); 
        $this->log('git-archive output: ' . trim($output), Project::MSG_INFO);
    }
    
    public function isFormat() {
        return $this->getFormat();
    }
    public function getFormat() {
        return $this->format;
    }
    public function setFormat($format) {
        $this->format = $format;
    }
    
}
