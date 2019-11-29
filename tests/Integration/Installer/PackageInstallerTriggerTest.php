<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ComposerPlugin\Tests\Integration\Installer;

use Composer\Composer;
use Composer\Config;
use Composer\IO\NullIO;
use OxidEsales\ComposerPlugin\Installer\PackageInstallerTrigger;

class PackageInstallerTriggerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * The composer.json file already in source for 5.3.
     */
    public function testGetShopSourcePathByConfiguration()
    {
        $composerConfigMock = $this->getMockBuilder(Config::class)->getMock();
        $composerMock = $this->getMockBuilder(Composer::class)->getMock();
        $composerMock->method('getConfig')->withAnyParameters()->willReturn($composerConfigMock);

        $packageInstallerStub = new PackageInstallerTrigger(new NullIO(), $composerMock);
        $packageInstallerStub->setSettings([
            'source-path' => 'some/path/to/source'
        ]);
        $this->assertEquals($packageInstallerStub->getShopSourcePath(), 'some/path/to/source');
    }

    /**
     * The composer.json file is taken up from the source directory for 6.0, so we should add source to path.
     */
    public function testGetShopSourcePathFor60()
    {
        $composerConfigMock = $this->getMockBuilder(Config::class)->getMock();
        $composerMock = $this->getMockBuilder(Composer::class)->getMock();
        $composerMock->method('getConfig')->withAnyParameters()->willReturn($composerConfigMock);

        $packageInstallerStub = new PackageInstallerTrigger(new NullIO(), $composerMock);
        $result = $packageInstallerStub->getShopSourcePath();

        $this->assertEquals($result, getcwd() . '/source');
    }
}
