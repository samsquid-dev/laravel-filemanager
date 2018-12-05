<?php

namespace Samsquid\LaravelFilemanager\Middlewares;

use Closure;
use Samsquid\LaravelFilemanager\Lfm;
use Samsquid\LaravelFilemanager\LfmPath;

class CreateDefaultFolder
{
    private $helper;

    private $lfm;

    public function __construct()
    {
        $this->lfm    = app(LfmPath::class);
        $this->helper = app(Lfm::class);
    }

    public function handle($request, Closure $next)
    {
        $this->checkDefaultFolderExists('user');
        $this->checkDefaultFolderExists('share');

        return $next($request);
    }

    private function checkDefaultFolderExists($type = 'share')
    {
        if (!$this->helper->allowFolderType($type)) {
            return;
        }

        $this->lfm->dir($this->helper->getRootFolder($type))->createFolder();
    }
}
