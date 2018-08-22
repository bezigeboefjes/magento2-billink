<?php


namespace Balticode\Billink\Model;


interface VersionCheckerInterface
{
    /**
     * @api
     * @return mixed
     */
    public function getRemoteVersion();
}