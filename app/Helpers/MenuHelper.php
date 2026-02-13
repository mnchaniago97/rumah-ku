<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups(): array
    {
        return [
            [
                'title' => 'Main',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'path' => route('admin.dashboard', [], false),
                        'icon' => 'dashboard',
                    ],
                ],
            ],
            [
                'title' => 'Manage',
                'items' => [
                    [
                        'name' => 'Properties',
                        'path' => route('admin.properties.index', [], false),
                        'icon' => 'home',
                    ],
                    [
                        'name' => 'Categories',
                        'path' => route('admin.categories.index', [], false),
                        'icon' => 'tag',
                    ],
                    [
                        'name' => 'Banners',
                        'path' => route('admin.banners.index', [], false),
                        'icon' => 'image',
                    ],
                    [
                        'name' => 'Testimonials',
                        'path' => route('admin.testimonials.index', [], false),
                        'icon' => 'message',
                    ],
                    [
                        'name' => 'Articles',
                        'path' => route('admin.articles.index', [], false),
                        'icon' => 'file',
                    ],
                    [
                        'name' => 'Agents',
                        'path' => route('admin.agents.index', [], false),
                        'icon' => 'users',
                    ],
                    [
                        'name' => 'Users',
                        'path' => route('admin.users.index', [], false),
                        'icon' => 'user',
                    ],
                    ...(
                        auth()->check()
                            ? [[
                                'name' => 'My Profile',
                                'path' => route('admin.users.show', ['user' => auth()->id()], false),
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
        $icons = [
            'dashboard' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 9.16667L10 3.33334L17.5 9.16667V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V9.16667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 17.5V12.5H12.5V17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'home' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.5 8.33333L10 3.33334L16.5 8.33333V15.8333C16.5 16.2936 16.1269 16.6667 15.6667 16.6667H4.33333C3.8731 16.6667 3.5 16.2936 3.5 15.8333V8.33333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 16.6667V11.6667H12.5V16.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'tag' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.16663 4.16667H9.99996L16.6666 10.8333L10.8333 16.6667L4.16663 10V4.16667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="7.08329" cy="7.08334" r="1.25" fill="currentColor"/></svg>',
            'users' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 16.6667V15C13.3333 13.6193 12.2141 12.5 10.8333 12.5H5.83333C4.45262 12.5 3.33333 13.6193 3.33333 15V16.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="8.33333" cy="7.5" r="2.5" stroke="currentColor" stroke-width="1.5"/><path d="M16.6667 16.6667V15.8333C16.6667 14.6827 15.85 13.6997 14.7222 13.4815" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M12.5 3.54167C13.5345 3.82205 14.2917 4.76906 14.2917 5.91667C14.2917 7.06428 13.5345 8.01129 12.5 8.29167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            'user' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.33333 16.6667C3.33333 14.8257 4.82572 13.3333 6.66667 13.3333H13.3333C15.1743 13.3333 16.6667 14.8257 16.6667 16.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="10" cy="7.5" r="3.33333" stroke="currentColor" stroke-width="1.5"/></svg>',
            'image' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="3" width="16" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="7.5" cy="8.5" r="1.5" fill="currentColor"/><path d="M2 12L6.5 8.5L10 11.5L14.5 7.5L18 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'message' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.6667 12.5C16.6667 13.4205 15.9205 14.1667 15 14.1667H7.08333L4.16667 16.6667V14.1667H5C4.07953 14.1667 3.33333 13.4205 3.33333 12.5V5.83333C3.33333 4.91286 4.07953 4.16667 5 4.16667H15C15.9205 4.16667 16.6667 4.91286 16.6667 5.83333V12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'file' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.66667 2.5H12.5L16.6667 6.66667V17.5H6.66667C5.74619 17.5 5 16.7538 5 15.8333V4.16667C5 3.24619 5.74619 2.5 6.66667 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12.5 2.5V6.66667H16.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 10H14.1667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M7.5 13.3333H14.1667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
        ];

        return $icons[$name] ?? $icons['dashboard'];
    }
}
