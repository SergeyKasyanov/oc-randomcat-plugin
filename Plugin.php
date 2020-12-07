<?php namespace SergeyKasyanov\RandomCat;

use SergeyKasyanov\RandomCat\ReportWidgets\RandomCat;
use System\Classes\PluginBase;

/**
 * RandomCat Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'RandomCat',
            'description' => 'sergeykasyanov.randomcat::lang.plugin.description',
            'author'      => 'SergeyKasyanov',
            'icon'        => 'icon-smile-o'
        ];
    }

    public function registerReportWidgets(): array
    {
        return [
            RandomCat::class => [
                'label'   => 'sergeykasyanov.randomcat::lang.plugin.widget.label',
                'context' => 'dashboard',
            ]
        ];
    }
}
