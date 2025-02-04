<?php

namespace Phing\Test\Task\Optional\Hg;

use Phing\Project;
use Phing\Test\Support\BuildFileTest;

/**
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
 *
 * @internal
 */
class HgRevertTaskTest extends BuildFileTest
{
    use HgTaskTestSkip;

    public function setUp(): void
    {
        $this->markTestAsSkippedWhenHgNotInstalled();

        mkdir(PHING_TEST_BASE . '/tmp/hgtest');
        $this->configureProject(
            PHING_TEST_BASE
            . '/etc/tasks/ext/hg/HgRevertTaskTest.xml'
        );
    }

    public function tearDown(): void
    {
        $this->rmdir(PHING_TEST_BASE . '/tmp/hgtest');
    }

    public function testFileNotSpecified(): void
    {
        $this->expectBuildExceptionContaining(
            'fileNotSpecified',
            'fileNotSpecified',
            'abort: no files or directories specified'
        );
        $this->assertInLogs('Executing: hg revert', Project::MSG_INFO);
        $this->rmdir(PHING_TEST_BASE . '/tmp/hgtest');
    }

    public function testRevertAll(): void
    {
        $this->executeTarget('revertAll');
        $this->assertInLogs('Executing: hg revert --all', Project::MSG_INFO);
        $this->rmdir(PHING_TEST_BASE . '/tmp/hgtest');
    }

    public function testRevertAllRevSet(): void
    {
        $this->expectBuildExceptionContaining(
            'revertAllWithRevisionSet',
            'revertAllWithRevisionSet',
            "abort: unknown revision 'deadbeef0a0b'!"
        );
        $this->rmdir(PHING_TEST_BASE . '/tmp/hgtest');
    }
}
