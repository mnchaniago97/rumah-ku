{{-- Notification Dropdown Component --}}
@php
    use App\Models\ForumComment;
    use App\Models\ForumPost;
    use App\Models\ContactMessage;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $contactUnread = ContactMessage::query()->unread()->count();
    $contactLatest = ContactMessage::query()
        ->orderByDesc('created_at')
        ->orderByDesc('id')
        ->take(6)
        ->get();

    $posts = ForumPost::query()
        ->with(['user:id,name,avatar'])
        ->latest()
        ->take(8)
        ->get();

    $comments = ForumComment::query()
        ->with(['user:id,name,avatar', 'post:id,title'])
        ->latest()
        ->take(8)
        ->get();

    $items = collect()
        ->merge($posts->map(function (ForumPost $p) {
            $user = $p->user;
            $avatar = $user?->avatar;
            if (filled($avatar) && !str_starts_with($avatar, 'http') && !str_starts_with($avatar, '/')) {
                $avatar = Storage::url($avatar);
            }

            return [
                'type' => 'post',
                'id' => $p->id,
                'user_name' => $user?->name ?? 'User',
                'user_avatar' => $avatar,
                'title' => $p->title,
                'body' => $p->body,
                'time' => $p->created_at,
                'url' => route('admin.forum-posts.show', $p->id),
            ];
        }))
        ->merge($comments->map(function (ForumComment $c) {
            $user = $c->user;
            $avatar = $user?->avatar;
            if (filled($avatar) && !str_starts_with($avatar, 'http') && !str_starts_with($avatar, '/')) {
                $avatar = Storage::url($avatar);
            }

            return [
                'type' => 'comment',
                'id' => $c->id,
                'user_name' => $user?->name ?? 'User',
                'user_avatar' => $avatar,
                'title' => $c->post?->title ?? 'Posting',
                'body' => $c->body,
                'time' => $c->created_at,
                'url' => route('admin.forum-comments.show', $c->id),
            ];
        }))
        ->sortByDesc('time')
        ->take(8)
        ->values();

    $latestTs = optional($items->first())['time']?->timestamp ?? 0;
@endphp

<div class="relative" x-data="{
    dropdownOpen: false,
    notifying: false,
    latestTs: @json($latestTs),
    contactUnread: @json($contactUnread),
    init() {
        const key = 'admin_forum_notif_seen_ts';
        const seen = Number(localStorage.getItem(key) || 0);
        this.notifying = this.latestTs > seen;
    },
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
        if (this.dropdownOpen) {
            const key = 'admin_forum_notif_seen_ts';
            localStorage.setItem(key, String(this.latestTs || 0));
            this.notifying = false;
        }
    },
    closeDropdown() {
        this.dropdownOpen = false;
    }
}" @click.away="closeDropdown()">
    <!-- Notification Button -->
    <button
        class="relative flex items-center justify-center text-gray-500 transition-colors bg-white border border-gray-200 rounded-full hover:text-dark-900 h-11 w-11 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        @click="toggleDropdown()"
        type="button"
    >
        <!-- Notification Badge -->
        <template x-if="contactUnread > 0">
            <span class="absolute -right-1 -top-1 z-10 inline-flex min-w-[18px] items-center justify-center rounded-full bg-red-600 px-1.5 py-0.5 text-[10px] font-bold leading-none text-white ring-2 ring-white dark:ring-gray-900">
                <span x-text="contactUnread > 99 ? '99+' : contactUnread"></span>
            </span>
        </template>
        <span x-show="notifying && contactUnread === 0" class="absolute right-0 top-0.5 z-1 h-2 w-2 rounded-full bg-orange-400">
            <span class="absolute inline-flex w-full h-full bg-orange-400 rounded-full opacity-75 -z-1 animate-ping"></span>
        </span>

        <!-- Bell Icon -->
        <svg
            class="fill-current"
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z"
                fill=""
            />
        </svg>
    </button>

    <!-- Dropdown Start -->
    <div
        x-show="dropdownOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute -right-[240px] mt-[17px] flex h-[480px] w-[350px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark sm:w-[361px] lg:right-0"
        style="display: none;"
    >
        <!-- Dropdown Header -->
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100 dark:border-gray-800">
            <h5 class="text-lg font-semibold text-gray-800 dark:text-white/90">Notifikasi</h5>

            <button @click="closeDropdown()" class="text-gray-500 dark:text-gray-400" type="button">
                <svg
                    class="fill-current"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
                        fill=""
                    />
                </svg>
            </button>
        </div>

        <div class="px-4 pb-2">
            <div class="flex items-center justify-between">
                <div class="text-sm font-semibold text-gray-800 dark:text-white/90">Pesan Kontak</div>
                <a href="{{ route('admin.contact-messages.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                    Lihat semua
                </a>
            </div>
        </div>

        <ul class="flex flex-col h-auto overflow-y-auto custom-scrollbar">
            @forelse($contactLatest as $m)
                <li>
                    <a class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                        href="{{ route('admin.contact-messages.show', $m) }}"
                        @click="closeDropdown()">
                        <span class="relative block h-10 w-10 rounded-full z-1 flex-shrink-0 overflow-hidden bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-200 flex items-center justify-center">
                            <i class="fas fa-envelope"></i>
                        </span>

                        <span class="block min-w-0">
                            <span class="mb-1.5 block text-theme-sm text-gray-500 dark:text-gray-400">
                                <span class="font-medium text-gray-800 dark:text-white/90">{{ $m->name }}</span>
                                <span class="ml-1">{{ $m->subject ?: 'Pesan kontak' }}</span>
                            </span>
                            <span class="block text-theme-xs text-gray-500 dark:text-gray-400">
                                {{ Str::limit((string) $m->message, 90) }}
                            </span>
                            <span class="mt-2 flex items-center gap-2 text-gray-500 text-theme-xs dark:text-gray-400">
                                <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $m->is_read ? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-200' }}">
                                    {{ $m->is_read ? 'Dibaca' : 'Baru' }}
                                </span>
                                <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                <span>{{ optional($m->created_at)->diffForHumans() }}</span>
                            </span>
                        </span>
                    </a>
                </li>
            @empty
                <li class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada pesan kontak.
                </li>
            @endforelse
        </ul>

        <div class="px-4 pt-4 pb-2">
            <div class="flex items-center justify-between">
                <div class="text-sm font-semibold text-gray-800 dark:text-white/90">Aktivitas Forum</div>
                <a href="{{ route('admin.forum-posts.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                    Lihat semua
                </a>
            </div>
        </div>

        <!-- Notification List -->
        <ul class="flex flex-col h-auto overflow-y-auto custom-scrollbar">
            @forelse($items as $item)
                @php
                    $initials = collect(explode(' ', (string) ($item['user_name'] ?? '')))
                        ->filter()
                        ->take(2)
                        ->map(fn ($s) => Str::upper(Str::substr($s, 0, 1)))
                        ->join('');

                    $badge = ($item['type'] ?? '') === 'comment' ? 'Komentar' : 'Posting';
                    $badgeClass = ($item['type'] ?? '') === 'comment'
                        ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-200'
                        : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-200';
                @endphp

                <li>
                    <a
                        class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                        href="{{ $item['url'] ?? '#' }}"
                        @click="closeDropdown()"
                    >
                        <span class="relative block h-10 w-10 rounded-full z-1 flex-shrink-0 overflow-hidden bg-gray-200 dark:bg-gray-800">
                            @if(filled($item['user_avatar'] ?? null))
                                <img src="{{ $item['user_avatar'] }}" alt="{{ $item['user_name'] ?? 'User' }}" class="h-full w-full object-cover" />
                            @else
                                <span class="flex h-full w-full items-center justify-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $initials !== '' ? $initials : 'U' }}
                                </span>
                            @endif
                        </span>

                        <span class="block min-w-0">
                            <span class="mb-1.5 block text-theme-sm text-gray-500 dark:text-gray-400">
                                <span class="font-medium text-gray-800 dark:text-white/90">
                                    {{ $item['user_name'] ?? 'User' }}
                                </span>
                                @if(($item['type'] ?? '') === 'comment')
                                    mengomentari:
                                @else
                                    membuat posting:
                                @endif
                                <span class="font-medium text-gray-800 dark:text-white/90">
                                    {{ Str::limit((string) ($item['title'] ?? ''), 60) }}
                                </span>
                            </span>

                            @if(filled($item['body'] ?? null))
                                <span class="block text-theme-xs text-gray-500 dark:text-gray-400">
                                    {{ Str::limit(strip_tags((string) $item['body']), 90) }}
                                </span>
                            @endif

                            <span class="mt-2 flex items-center gap-2 text-gray-500 text-theme-xs dark:text-gray-400">
                                <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $badgeClass }}">{{ $badge }}</span>
                                <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                <span>{{ optional($item['time'] ?? null)->diffForHumans() }}</span>
                            </span>
                        </span>
                    </a>
                </li>
            @empty
                <li class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada aktivitas forum.
                </li>
            @endforelse
        </ul>

        <div class="mt-3 grid grid-cols-2 gap-2 px-4 pb-4">
            <a href="{{ route('admin.contact-messages.index') }}"
                class="flex justify-center rounded-lg border border-gray-300 bg-white p-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                @click="closeDropdown()">
                Inbox Pesan
            </a>
            <a href="{{ route('admin.forum-posts.index') }}"
                class="flex justify-center rounded-lg border border-gray-300 bg-white p-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                @click="closeDropdown()">
                Forum
            </a>
        </div>
    </div>
    <!-- Dropdown End -->
</div>
