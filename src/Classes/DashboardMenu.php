<?php

namespace Bws\Core\Classes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Psy\Exception\RuntimeException;

class DashboardMenu
{
    protected $links = [];

    public function getMenuSection($section_id = null)
    {
        return $section_id === null
            ? $this->getMenuItems()
            : (isset($this->getMenuItems()[$section_id]) && $this->getMenuItems()[$section_id]
                ? $this->getMenuItems()[$section_id]
                : []);
    }

    public function getMenuItems()
    {
        $array_merge = array_merge($this->defaultMenuItems(), $this->links);
        return $this->unFlattenMenuItems($array_merge);
    }

    private function defaultMenuItems()
    {
        return [
            [
                'id' => 'general_section',
                'priority' => 1,
                'parent_id' => null,
                'name' => trans('bws/core::core.menu.sections.general'),
                'icon' => null,
                'url' => 'javascript:;',
                'children' => [],
                'permissions' => [],
                'active' => false,
            ],
            [
                'id' => 'settings_section',
                'priority' => 2,
                'parent_id' => null,
                'name' => trans('bws/core::core.menu.sections.settings'),
                'icon' => null,
                'url' => 'javascript:;',
                'children' => [],
                'permissions' => [],
                'active' => false,
            ],
            [
                'id' => 'develop_section',
                'priority' => 3,
                'parent_id' => null,
                'name' => trans('bws/core::core.menu.sections.develop'),
                'icon' => null,
                'url' => 'javascript:;',
                'children' => [],
                'permissions' => [],
                'active' => false,
            ]
        ];
    }

    public function addMenuItem(array $options): self
    {
        if (isset($options['children'])) {
            unset($options['children']);
        }

        $defaultOptions = [
            'id' => '',
            'priority' => 99,
            'parent_id' => null,
            'name' => '',
            'icon' => null,
            'url' => '',
            'children' => [],
            'permissions' => [],
            'active' => false,
        ];

        $options = array_merge($defaultOptions, $options);
        if ($options['parent_id'] === null) {
            $options['parent_id'] = 'general_section';
        }
        $id = $options['id'];

        if (!$id && !app()->runningInConsole() && app()->isLocal()) {
            $calledClass = isset(debug_backtrace()[1]) ?
                debug_backtrace()[1]['class'] . '@' . debug_backtrace()[1]['function']
                :
                null;
            throw new RuntimeException('Menu id not specified: ' . $calledClass);
        }

        if (isset($this->links[$id]) && $this->links[$id]['name'] && !app()->runningInConsole() && app()->isLocal()) {
            $calledClass = isset(debug_backtrace()[1]) ?
                debug_backtrace()[1]['class'] . '@' . debug_backtrace()[1]['function']
                :
                null;
            throw new RuntimeException('Menu id already exists: ' . $id . ' on class ' . $calledClass);
        }

        $options['name'] = trans($options['name']);
        $options['permissions'][] = 'access-dashboard';

        if (Auth::user() && Auth::user()->hasAnyPermission($options['permissions'])) {
            $this->links[] = $options;
        }

        $this->links = collect($this->links)->sortBy('priority')->toArray();

        return $this;
    }

    private function unFlattenMenuItems(&$items, $parentId = null)
    {
        $treeItems = [];
        $currentUrl = trim(parse_url(Request::url(), PHP_URL_PATH), '/');

        $prefix = request()->route()->getPrefix();
        if (!$prefix || $prefix === get_dashboard_prefix()) {
            $uri = explode('/', request()->route()->uri());
            $prefix = end($uri);
        }

        $routePrefix = '/' . $prefix;

        if (request()->isSecure()) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        $protocol .= get_dashboard_prefix();

        foreach ($items as $idx => $item) {
            if ((empty($parentId) && empty($item['parent_id'])) || (!empty($item['parent_id']) && !empty($parentId) && $item['parent_id'] == $parentId)) {
                $items[$idx]['children'] = $this->unFlattenMenuItems($items, $items[$idx]['id']);
                $items[$idx]['active'] = $currentUrl === trim(parse_url($items[$idx]['url'], PHP_URL_PATH), '/')
                    || collect($items[$idx]['children'])->filter(function ($child) {
                        return isset($child['active']) && $child['active'];
                    })->count()
                    || (Str::contains($items[$idx]['url'], $routePrefix) &&
                        !in_array($routePrefix, ['//', '/' . get_dashboard_prefix()]) &&
                        !Str::startsWith($items[$idx]['url'], $protocol));
                $treeItems[] = $items[$idx];
            }
        }

        return $treeItems;
    }
}
