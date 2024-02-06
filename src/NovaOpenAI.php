<?php

namespace Outl1ne\NovaOpenAI;

use Laravel\Nova\Tool;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;

class NovaOpenAI extends Tool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Nova OpenAI';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'nova-openai';
    }

    public function menu(Request $request)
    {
        return MenuSection::make('OpenAI', array_filter([
            self::makeResourceMenuItem('openai_request'),
        ]))->icon('newspaper')->collapsable();
    }

    protected static function makeResourceMenuItem($resourceName) : MenuItem
    {
        return MenuItem::make(NovaOpenAIConfig::resource($resourceName)::label(), '/resources/' . NovaOpenAIConfig::resource($resourceName)::uriKey());
    }
}
