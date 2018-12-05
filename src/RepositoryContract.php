<?php

namespace Samsquid\LaravelFilemanager;

interface RepositoryContract
{
    public function move($new_lfm_path);

    public function rootPath();

    public function save($file);
}
