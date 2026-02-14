<?php

namespace App\Helpers;

class AgentMenuHelper
{
    public static function getMenuGroups(): array
    {
        $user = auth()->user();
        $agentType = $user?->agent_type;

        $defaultRumahSubsidi = $agentType === \App\Models\AgentApplication::TYPE_PROPERTY_AGENT;
        $canRumahSubsidi = $user ? $user->canAgentFeature('rumah_subsidi', $defaultRumahSubsidi) : false;

        $groups = [
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
                'title' => 'Properti',
                'items' => [
                    [
                        'name' => 'Properti',
                        'path' => route('agent.properties.index', [], false),
                        'icon' => 'home',
                    ],
                    [
                        'name' => 'Sewa',
                        'path' => route('agent.sewa.index', [], false),
                        'icon' => 'rent',
                    ],
                    ...($canRumahSubsidi ? [[
                        'name' => 'Rumah Subsidi',
                        'path' => route('agent.rumah-subsidi.index', [], false),
                        'icon' => 'home-subsidi',
                    ]] : []),
                ],
            ],
            [
                'title' => 'Akun',
                'items' => [
                    ...(
                        auth()->check()
                            ? [[
                                'name' => 'Profil Saya',
                                'path' => route('agent.users.show', ['user' => auth()->id()], false),
                                'icon' => 'user',
                            ]]
                            : []
                    ),
                ],
            ],
        ];

        return array_values(array_filter($groups, function ($group) {
            return !empty($group['items'] ?? []);
        }));
    }

    public static function getIconSvg(string $name): string
    {
        return MenuHelper::getIconSvg($name);
    }
}
