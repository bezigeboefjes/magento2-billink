<?php


namespace Balticode\Billink\Model;

use Magento\Framework\Module\ModuleListInterface;

class VersionChecker implements \Balticode\Billink\Model\VersionCheckerInterface
{
    const MODULE_NAME = 'Balticode_Billink';

    protected $moduleList;

    public function __construct(ModuleListInterface $moduleList)
    {
        $this->moduleList = $moduleList;

    }
    /**
     * @return mixed
     */
    public function getRemoteVersion()
    {
        return $this->moduleList->getOne(static::MODULE_NAME)['setup_version'];
    }
}