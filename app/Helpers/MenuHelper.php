<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups(): array
    {
        $user = auth()->user();
        $isAdmin = $user && (($user->role ?? null) === 'admin');

        $groups = [
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
                'title' => 'Properti',
                'items' => [
                    [
                        'name' => 'Properti Dijual',
                        'path' => route('admin.properties.index', [], false),
                        'icon' => 'home',
                    ],
                    [
                        'name' => 'Aset Turun Harga',
                        'path' => route('admin.discounted.index', [], false),
                        'icon' => 'discount',
                    ],
                    ...($isAdmin ? [[
                        'name' => 'Rumah Subsidi',
                        'path' => route('admin.rumah-subsidi.index', [], false),
                        'icon' => 'home-subsidi',
                    ], [
                        'name' => 'Sewa',
                        'path' => route('admin.sewa.index', [], false),
                        'icon' => 'rent',
                    ]] : []),
                    [
                        'name' => 'Permintaan Properti',
                        'path' => route('admin.property-inquiries.index', [], false),
                        'icon' => 'search',
                    ],
                ],
            ],
            [
                'title' => 'Konten',
                'items' => [
                    ...($isAdmin ? [[
                        'name' => 'Forum',
                        'path' => route('admin.forum-posts.index', [], false),
                        'icon' => 'forum',
                    ]] : []),
                    [
                        'name' => 'Banners',
                        'path' => route('admin.banners.index', [], false),
                        'icon' => 'image',
                    ],
                    ...($isAdmin ? [[
                        'name' => 'Partners',
                        'path' => route('admin.partners.index', [], false),
                        'icon' => 'handshake',
                    ]] : []),
                    ...($isAdmin ? [[
                        'name' => 'Pesan Kontak',
                        'path' => route('admin.contact-messages.index', [], false),
                        'icon' => 'inbox',
                    ]] : []),
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
                ],
            ],
            [
                'title' => 'Agen',
                'items' => [
                    [
                        'name' => 'Agents',
                        'path' => route('admin.agents.index', [], false),
                        'icon' => 'users',
                    ],
                    ...($isAdmin ? [[
                        'name' => 'Pendaftaran Agent',
                        'path' => route('admin.agent-applications.index', [], false),
                        'icon' => 'file',
                    ], [
                        'name' => 'Pricing (Paket)',
                        'path' => route('admin.subscription-plans.index', [], false),
                        'icon' => 'tag',
                    ]] : []),
                ],
            ],
            [
                'title' => 'Pengaturan',
                'items' => [
                    ...($isAdmin ? [[
                        'name' => 'Pengaturan Website',
                        'path' => route('admin.site-settings.edit', [], false),
                        'icon' => 'settings',
                    ]] : []),
                    [
                        'name' => 'Users',
                        'path' => route('admin.users.index', [], false),
                        'icon' => 'user',
                    ],
                ],
            ],
        ];

        return array_values(array_filter($groups, function ($group) {
            return !empty($group['items'] ?? []);
        }));
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
            'forum' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 4.5H15.5C16.3284 4.5 17 5.17157 17 6V12C17 12.8284 16.3284 13.5 15.5 13.5H8L4.5 16V13.5H4.5C3.67157 13.5 3 12.8284 3 12V6C3 5.17157 3.67157 4.5 4.5 4.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 7.5H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M6 10.5H11.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            'file' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.66667 2.5H12.5L16.6667 6.66667V17.5H6.66667C5.74619 17.5 5 16.7538 5 15.8333V4.16667C5 3.24619 5.74619 2.5 6.66667 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12.5 2.5V6.66667H16.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 10H14.1667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M7.5 13.3333H14.1667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            'search' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="9" cy="9" r="6" stroke="currentColor" stroke-width="1.5"/><path d="M13.5 13.5L17 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            'home-subsidi' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.5 8.33333L10 3.33334L16.5 8.33333V15.8333C16.5 16.2936 16.1269 16.6667 15.6667 16.6667H4.33333C3.8731 16.6667 3.5 16.2936 3.5 15.8333V8.33333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 16.6667V11.6667H12.5V16.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.5 7.5H11.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
            'rent' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.5 8.33333L10 3.33334L16.5 8.33333V15.8333C16.5 16.2936 16.1269 16.6667 15.6667 16.6667H4.33333C3.8731 16.6667 3.5 16.2936 3.5 15.8333V8.33333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.3 12.4H12.7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M7.3 14.9H10.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            'discount' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 2.5L2.5 7.5V15C2.5 16.3807 3.61929 17.5 5 17.5H15C16.3807 17.5 17.5 16.3807 17.5 15V7.5L10 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.25 10H13.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M10 7.5V12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            'settings' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065Z"/><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>',
            'handshake' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 10.5L9.2 8.8C10.4 7.6 12.3 7.6 13.5 8.8L14.2 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16.5 10.5L14.9 12.1C13.7 13.3 11.8 13.3 10.6 12.1L9.8 11.3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 9L7 5L10 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 9L17 5L14 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 9L3 19C3 19.6 3.4 20 4 20H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M21 9V19C21 19.6 20.6 20 20 20H16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            'inbox' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4H20V14H15.5L13.5 17H10.5L8.5 14H4V4Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M4 14V20H20V14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
        ];

        return $icons[$name] ?? $icons['dashboard'];
    }
}
