<?php

namespace Samsquid\LaravelFilemanager;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\Cached\CachedAdapter;

class LfmStorageRepository implements RepositoryContract
{
    private $disk;

    private $helper;

    private $path;

    public function __call($function_name, $arguments)
    {
        // TODO: check function exists
        return $this->disk->$function_name($this->path, ...$arguments);
    }

    public function __construct($storage_path, $helper)
    {
        $this->helper = $helper;
        $this->disk   = Storage::disk($this->helper->config('disk'));
        $this->path   = $storage_path;
    }

    public function extension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function makeDirectory()
    {
        $this->disk->makeDirectory($this->path, ...func_get_args());

        $this->disk->setVisibility($this->path, 'public');
    }

    public function move($new_lfm_path)
    {
        return $this->disk->move($this->path, $new_lfm_path->path('storage'));
    }

    public function rootPath()
    {
        $adapter = $this->disk->getDriver()->getAdapter();

        if ($adapter instanceof CachedAdapter) {
            $adapter = $adapter->getAdapter();
        }

        return $adapter->getPathPrefix();
    }

    public function save($file)
    {
        $nameint   = strripos($this->path, "/");
        $nameclean = substr($this->path, $nameint + 1);
        $pathclean = substr_replace($this->path, "", $nameint);
        $this->disk->putFileAs($pathclean, $file, $nameclean, 'public');
    }

    public function url($path)
    {
        return $this->disk->url($path);
    }
}
