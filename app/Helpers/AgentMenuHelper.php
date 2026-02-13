<?php

namespace App\Helpers;

class AgentMenuHelper
{
    public static function getMenuGroups(): array
    {
        return [
            [
                'title' => 'Main',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'path' => route('agent.dashboard', [], false),
                        'icon' => 'dashboard',
                    ],
                ],
            ],
            [
                'title' => 'Manage',
                'items' => [
                    [
                        'name' => 'Properties',
                        'path' => route('agent.properties.index', [], false),
                        'icon' => 'home',
                    ],
                    [
                        'name' => 'Rumah Subsidi',
                        'path' => route('agent.rumah-subsidi.index', [], false),
                        'icon' => 'home-subsidi',
                    ],
                    [
                        'name' => 'Users',
                        'path' => route('agent.users.index', [], false),
                        'icon' => 'user',
                    ],
                    ...(
                        auth()->check()
                            ? [[
                                'name' => 'My Profile',
                                'path' => route('agent.users.show', ['user' => auth()->id()], false),
                                'icon' => 'user',
                            ]]
                            : []
                    ),
                ],
            ],
        ];
    }

    public static function getIconSvg(string $name): string
    {
        return MenuHelper::getIconSvg($name);
    }
}
