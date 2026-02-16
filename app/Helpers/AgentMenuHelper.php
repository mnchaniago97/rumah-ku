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
        
        // Developers don't have access to Sewa menu
        $isDeveloper = $agentType === \App\Models\AgentApplication::TYPE_DEVELOPER;

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
                    // Hide Sewa menu for developers
                    ...($isDeveloper ? [] : [[
                        'name' => 'Sewa',
                        'path' => route('agent.sewa.index', [], false),
                        'icon' => 'rent',
                    ]]),
                    ...($canRumahSubsidi ? [[
                        'name' => 'Rumah Subsidi',
                        'path' => route('agent.rumah-subsidi.index', [], false),
                        'icon' => 'home-subsidi',
                    ]] : []),
                ],
            ],
            // Developer Projects menu - only for developers
            ...($isDeveloper ? [[
                'title' => 'Developer',
                'items' => [
                    [
                        'name' => 'Proyek Saya',
                        'path' => route('agent.developer-projects.index', [], false),
                        'icon' => 'building',
                    ],
                ],
            ]] : []),
            [
                'title' => 'Akun',
                'items' => [
                    ...(
                        auth()->check()
                            ? [[
                                'name' => 'Profil Saya',
                                'path' => route('agent.profile', [], false),
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
