<?php


namespace Balticode\Billink\Model;


class VersionChecker implements \Balticode\Billink\Model\VersionCheckerInterface
{
    /**
     * @return mixed
     */
    public function getRemoteVersion()
    {
        // TODO: implement from remote server
        return '1.0.1';
    }
}