<?php

namespace Samsquid\LaravelFilemanager\Handlers;

class ConfigHandler
{
    public function userField()
    {
        return auth()->user()->id;
    }
}
