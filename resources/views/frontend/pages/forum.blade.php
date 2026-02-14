@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8" x-data="forumPage()" x-init="init()">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Teras Rumah IO - Forum Properti</h1>
                <p class="mt-2 text-gray-600">Tanya jawab, berbagi pengalaman, dan diskusi dengan komunitas properti Indonesia</p>
                <p class="mt-2 text-xs text-gray-500" x-show="polling">Update otomatis aktif</p>
            </div>

            {{-- Categories --}}
            <div class="grid md:grid-cols-4 gap-4 mb-10">
                <button type="button" @click="setCategoryFilter('beli_rumah')"
                    class="w-full bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition text-center ring-2 ring-transparent"
                    :class="categoryFilter === 'beli_rumah' ? 'ring-blue-600' : ''">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-home text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Beli Rumah</h3>
                    <p class="text-sm text-gray-500">Tips dan trik beli rumah</p>
                </button>
                <button type="button" @click="setCategoryFilter('kpr')"
                    class="w-full bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition text-center ring-2 ring-transparent"
                    :class="categoryFilter === 'kpr' ? 'ring-blue-600' : ''">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-file-signature text-2xl text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">KPR</h3>
                    <p class="text-sm text-gray-500">Diskusi KPR dan pembiayaan</p>
                </button>
                <button type="button" @click="setCategoryFilter('investasi')"
                    class="w-full bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition text-center ring-2 ring-transparent"
                    :class="categoryFilter === 'investasi' ? 'ring-blue-600' : ''">
                    <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-building text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Investasi</h3>
                    <p class="text-sm text-gray-500">Properti sebagai investasi</p>
                </button>
                <button type="button" @click="setCategoryFilter('renovasi')"
                    class="w-full bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition text-center ring-2 ring-transparent"
                    :class="categoryFilter === 'renovasi' ? 'ring-blue-600' : ''">
                    <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-tools text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Renovasi</h3>
                    <p class="text-sm text-gray-500">Tips renovasi dan desain</p>
                </button>
            </div>

            {{-- Ask box --}}
            <div class="bg-white rounded-xl shadow-sm mb-8">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between gap-3">
                    <h2 class="text-xl font-bold text-gray-900">Tanya di Forum</h2>
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">
                            Login untuk bertanya
                        </a>
                    @endguest
                </div>
                <div class="p-5">
                    @auth
                        <div class="grid gap-3">
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-12">
                                <div class="sm:col-span-5">
                                    <label class="sr-only">Kategori</label>
                                    <select
                                        class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        x-model="newPost.category" :disabled="submittingPost">
                                        <option value="beli_rumah">Beli Rumah</option>
                                        <option value="kpr">KPR</option>
                                        <option value="investasi">Investasi</option>
                                        <option value="renovasi">Renovasi</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-7">
                                    <input type="text"
                                        class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Judul pertanyaan (contoh: KPR tanpa DP bisa?)" x-model.trim="newPost.title"
                                        :disabled="submittingPost" />
                                </div>
                            </div>
                            <textarea rows="3"
                                class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Ceritakan detailnya (opsional)" x-model.trim="newPost.body" :disabled="submittingPost"></textarea>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500" x-text="postHint"></p>
                                <button type="button" @click="submitPost()"
                                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:opacity-60 disabled:cursor-not-allowed"
                                    :disabled="submittingPost || !newPost.title">
                                    <span x-show="!submittingPost">Kirim</span>
                                    <span x-show="submittingPost">Mengirim...</span>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="rounded-lg bg-blue-50 p-4 text-sm text-blue-900">
                            Silakan <a class="font-semibold underline" href="{{ route('login') }}">login</a> atau
                            <a class="font-semibold underline" href="{{ route('register') }}">daftar</a> untuk ikut berdiskusi.
                        </div>
                    @endauth
                </div>
            </div>

            {{-- Feed --}}
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Pertanyaan Terbaru</h3>
                    <p class="mt-1 text-xs text-gray-500" x-show="categoryFilter">
                        Filter: <span class="font-semibold" x-text="categoryLabel(categoryFilter)"></span>
                        <button type="button" class="ml-2 text-blue-700 hover:underline" @click="setCategoryFilter('')">Reset</button>
                    </p>
                </div>
                <button type="button" class="text-sm text-gray-600 hover:text-gray-800" @click="refresh()">Refresh</button>
            </div>

            <template x-if="error">
                <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800" x-text="error"></div>
            </template>

            <div class="space-y-4 mb-10">
                <template x-if="loading && posts.length === 0">
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="h-4 w-2/3 bg-gray-200 rounded animate-pulse"></div>
                        <div class="mt-3 h-3 w-1/2 bg-gray-200 rounded animate-pulse"></div>
                    </div>
                </template>

                <template x-for="post in posts" :key="post.id">
                    <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1">
                                <button type="button" class="text-left w-full" @click="toggleComments(post)">
                                    <h4 class="font-semibold text-gray-900 hover:text-blue-600" x-text="post.title"></h4>
                                </button>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-xs text-gray-500">
                                    <span>
                                        <i class="far fa-user mr-1"></i>
                                        <span x-text="post.user?.name ?? 'User'"></span>
                                    </span>
                                    <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-700" x-show="post.category"
                                        x-text="categoryLabel(post.category)"></span>
                                    <span>
                                        <i class="far fa-clock mr-1"></i>
                                        <span x-text="formatTime(post.created_at)"></span>
                                    </span>
                                    <span>
                                        <i class="far fa-comment mr-1"></i>
                                        <span x-text="`${post.comments_count} komentar`"></span>
                                    </span>
                                </div>
                                <template x-if="post.body">
                                    <p class="mt-3 text-sm text-gray-700 whitespace-pre-line" x-text="post.body"></p>
                                </template>
                            </div>
                            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                                <button type="button"
                                    class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                    @click="toggleComments(post)">
                                    <span x-show="!post.open">Lihat</span>
                                    <span x-show="post.open">Tutup</span>
                                </button>
                                <template x-if="canDeletePost(post)">
                                    <button type="button" class="text-xs font-semibold text-red-600 hover:text-red-700"
                                        @click="deletePost(post)" :disabled="deletingPostId === post.id">
                                        <span x-show="deletingPostId !== post.id">Hapus pertanyaan</span>
                                        <span x-show="deletingPostId === post.id">...</span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <template x-if="!post.open && post.latest_comments && post.latest_comments.length">
                            <div class="mt-4 rounded-lg bg-gray-50 p-4">
                                <p class="text-xs text-gray-500 mb-3">Komentar terbaru</p>
                                <div class="space-y-3">
                                    <template x-for="c in post.latest_comments" :key="c.id">
                                        <div class="text-sm">
                                            <p class="text-gray-800">
                                                <span class="font-semibold" x-text="c.user?.name ?? 'User'"></span>
                                                <span class="text-gray-400 mx-1">•</span>
                                                <span class="text-xs text-gray-500" x-text="formatTime(c.created_at)"></span>
                                            </p>
                                            <p class="text-gray-700 whitespace-pre-line" x-text="c.body"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="post.open">
                            <div class="mt-4 border-t border-gray-100 pt-4">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-sm font-semibold text-gray-900">Komentar</p>
                                    <p class="text-xs text-gray-500" x-show="post.polling">Update otomatis</p>
                                </div>

                                <template x-if="post.commentsLoading && post.comments.length === 0">
                                    <div class="text-sm text-gray-500">Memuat komentar...</div>
                                </template>

                                <template x-if="post.comments.length === 0 && !post.commentsLoading">
                                    <div class="text-sm text-gray-500">Belum ada komentar. Jadilah yang pertama.</div>
                                </template>

                                <div class="space-y-3">
                                    <template x-for="c in post.comments" :key="c.id">
                                        <div class="rounded-lg bg-gray-50 p-3 text-sm">
                                            <div class="flex items-start justify-between gap-3">
                                                <p class="text-gray-800">
                                                    <span class="font-semibold" x-text="c.user?.name ?? 'User'"></span>
                                                    <span class="text-gray-400 mx-1">•</span>
                                                    <span class="text-xs text-gray-500" x-text="formatTime(c.created_at)"></span>
                                                </p>
                                                <template x-if="canDeleteComment(c)">
                                                    <button type="button" class="text-xs font-semibold text-red-600 hover:text-red-700"
                                                        @click="deleteComment(post, c)" :disabled="post.deletingCommentId === c.id">
                                                        <span x-show="post.deletingCommentId !== c.id">Hapus</span>
                                                        <span x-show="post.deletingCommentId === c.id">...</span>
                                                    </button>
                                                </template>
                                            </div>
                                            <p class="mt-1 text-gray-700 whitespace-pre-line" x-text="c.body"></p>
                                        </div>
                                    </template>
                                </div>

                                <div class="mt-4">
                                    @auth
                                        <div class="flex items-start gap-2">
                                            <textarea rows="2"
                                                class="flex-1 rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Tulis komentar..." x-model.trim="post.commentDraft"
                                                :disabled="post.submittingComment"></textarea>
                                            <button type="button"
                                                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 disabled:opacity-60 disabled:cursor-not-allowed"
                                                @click="submitComment(post)" :disabled="post.submittingComment || !post.commentDraft">
                                                <span x-show="!post.submittingComment">Kirim</span>
                                                <span x-show="post.submittingComment">...</span>
                                            </button>
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-600">
                                            <a class="font-semibold text-blue-700 hover:text-blue-800" href="{{ route('login') }}">Login</a> untuk berkomentar.
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="!loading && posts.length === 0">
                    <div class="bg-white rounded-xl p-6 shadow-sm text-center text-gray-600">
                        Belum ada pertanyaan. Jadilah yang pertama bertanya.
                    </div>
                </template>
            </div>

            <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-8 text-white text-center">
                <h3 class="text-2xl font-bold mb-3">Punya Pertanyaan?</h3>
                <p class="text-purple-200 mb-6">Bergabung dengan komunitas dan ajukan pertanyaan Anda</p>
                @auth
                    <button type="button"
                        class="inline-block px-8 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition"
                        @click="scrollToTop()">
                        Tulis Pertanyaan
                    </button>
                @else
                    <a href="{{ route('register') }}"
                        class="inline-block px-8 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition">
                        Daftar Gratis
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function forumPage() {
            return {
                loading: true,
                error: null,
                polling: false,
                pollTimer: null,
                posts: [],
                currentUserId: @json(Auth::id()),
                currentUserRole: @json(optional(Auth::user())->role),
                deletingPostId: null,
                categoryFilter: '',
                newPost: {
                    category: 'beli_rumah',
                    title: '',
                    body: '',
                },
                submittingPost: false,

                get postHint() {
                    const bodyLen = (this.newPost.body || '').length;
                    return bodyLen ? `${bodyLen}/2000 karakter` : 'Isi detailnya agar mudah dijawab (opsional)';
                },

                csrfToken() {
                    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                },

                async request(url, options = {}) {
                    const headers = {
                        'Accept': 'application/json',
                        ...options.headers
                    };

                    if (options.method && options.method.toUpperCase() !== 'GET') {
                        headers['Content-Type'] = 'application/json';
                        headers['X-CSRF-TOKEN'] = this.csrfToken();
                    }

                    const res = await fetch(url, {
                        credentials: 'same-origin',
                        ...options,
                        headers,
                    });

                    const isJson = res.headers.get('content-type')?.includes('application/json');
                    if (!isJson) {
                        throw new Error('Sesi tidak valid. Silakan refresh halaman atau login ulang.');
                    }

                    const json = await res.json();

                    if (!res.ok) {
                        const message = json?.message
                            ?? (json?.errors ? Object.values(json.errors).flat().join(' ') : null)
                            ?? `Request gagal (${res.status})`;
                        throw new Error(message);
                    }

                    return json;
                },

                normalizePost(post) {
                    return {
                        ...post,
                        open: false,
                        polling: false,
                        commentsLoading: false,
                        comments: [],
                        commentsAfterId: 0,
                        commentDraft: '',
                        submittingComment: false,
                        deletingCommentId: null,
                    };
                },

                categoryLabel(value) {
                    switch (value) {
                        case 'beli_rumah':
                            return 'Beli Rumah';
                        case 'kpr':
                            return 'KPR';
                        case 'investasi':
                            return 'Investasi';
                        case 'renovasi':
                            return 'Renovasi';
                        default:
                            return value || '';
                    }
                },

                maxPostId() {
                    return this.posts.reduce((max, p) => Math.max(max, p.id || 0), 0);
                },

                formatTime(iso) {
                    if (!iso) return '';
                    const dt = new Date(iso);
                    if (Number.isNaN(dt.getTime())) return '';
                    return new Intl.DateTimeFormat('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                    }).format(dt);
                },

                scrollToTop() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth',
                    });
                },

                async init() {
                    const params = new URLSearchParams(window.location.search);
                    const initialCategory = params.get('category') || '';
                    if (['beli_rumah', 'kpr', 'investasi', 'renovasi'].includes(initialCategory)) {
                        this.categoryFilter = initialCategory;
                        this.newPost.category = initialCategory;
                    }
                    await this.refresh();
                    this.startPolling();
                },

                async refresh() {
                    this.error = null;
                    this.loading = true;
                    try {
                        const url = new URL(@json(route('forum.posts')), window.location.origin);
                        if (this.categoryFilter) url.searchParams.set('category', this.categoryFilter);
                        const json = await this.request(url.toString());
                        const incoming = (json?.data ?? []).map((p) => this.normalizePost(p));
                        this.posts = incoming.sort((a, b) => (b.id ?? 0) - (a.id ?? 0));
                    } catch (e) {
                        this.error = e.message || 'Gagal memuat forum';
                    } finally {
                        this.loading = false;
                    }
                },

                startPolling() {
                    if (this.pollTimer) return;
                    this.polling = true;
                    this.pollTimer = window.setInterval(async () => {
                        await this.fetchNewPosts();
                        await this.pollOpenPostComments();
                    }, 4000);
                },

                async fetchNewPosts() {
                    const afterId = this.maxPostId();
                    if (!afterId) return;

                    try {
                        const url = new URL(@json(route('forum.posts')), window.location.origin);
                        url.searchParams.set('after_id', afterId);
                        if (this.categoryFilter) url.searchParams.set('category', this.categoryFilter);
                        const json = await this.request(url.toString());
                        const incoming = (json?.data ?? []).map((p) => this.normalizePost(p));
                        if (!incoming.length) return;

                        const existingIds = new Set(this.posts.map((p) => p.id));
                        const newOnes = incoming.filter((p) => !existingIds.has(p.id));
                        if (!newOnes.length) return;

                        this.posts = [...newOnes.reverse(), ...this.posts];
                    } catch (e) {
                        // silent fail for polling
                    }
                },

                async pollOpenPostComments() {
                    const openPosts = this.posts.filter((p) => p.open);
                    if (!openPosts.length) return;

                    await Promise.all(openPosts.map(async (post) => {
                        await this.fetchComments(post, true);
                    }));
                },

                async toggleComments(post) {
                    post.open = !post.open;
                    if (!post.open) {
                        post.polling = false;
                        return;
                    }

                    if (post.comments.length === 0) {
                        await this.fetchComments(post, false);
                    }
                },

                async fetchComments(post, onlyNew) {
                    post.commentsLoading = !onlyNew && post.comments.length === 0;
                    try {
                        const afterId = onlyNew ? (post.commentsAfterId || 0) : 0;
                        const url = @json(url('/forum/posts')) + `/${post.id}/comments?after_id=${afterId}`;
                        const json = await this.request(url);
                        const incoming = json?.data ?? [];
                        if (!incoming.length) return;

                        if (!afterId) {
                            post.comments = incoming;
                        } else {
                            const existingIds = new Set(post.comments.map((c) => c.id));
                            const newOnes = incoming.filter((c) => !existingIds.has(c.id));
                            post.comments = [...post.comments, ...newOnes];
                        }

                        post.commentsAfterId = post.comments.reduce((max, c) => Math.max(max, c.id || 0), 0);
                        post.comments_count = Math.max(post.comments_count || 0, post.comments.length);
                        post.polling = true;
                    } catch (e) {
                        if (!onlyNew) {
                            this.error = e.message || 'Gagal memuat komentar';
                        }
                    } finally {
                        post.commentsLoading = false;
                    }
                },

                async submitPost() {
                    this.error = null;
                    this.submittingPost = true;
                    try {
                        const payload = {
                            category: this.newPost.category,
                            title: this.newPost.title,
                            body: this.newPost.body || null,
                        };
                        const json = await this.request(@json(route('forum.posts.store')), {
                            method: 'POST',
                            body: JSON.stringify(payload),
                        });
                        const created = this.normalizePost(json?.data);
                        if (!this.categoryFilter || this.categoryFilter === created.category) {
                            this.posts = [created, ...this.posts];
                        }
                        this.newPost.title = '';
                        this.newPost.body = '';
                        this.scrollToTop();
                    } catch (e) {
                        this.error = e.message || 'Gagal mengirim pertanyaan';
                    } finally {
                        this.submittingPost = false;
                    }
                },

                setCategoryFilter(value) {
                    const next = value || '';
                    this.categoryFilter = (this.categoryFilter === next) ? '' : next;
                    if (next) this.newPost.category = next;

                    const url = new URL(window.location.href);
                    if (this.categoryFilter) {
                        url.searchParams.set('category', this.categoryFilter);
                    } else {
                        url.searchParams.delete('category');
                    }
                    window.history.replaceState({}, '', url.toString());

                    this.refresh();
                },

                async submitComment(post) {
                    this.error = null;
                    post.submittingComment = true;
                    try {
                        const payload = {
                            body: post.commentDraft,
                        };
                        const url = @json(url('/forum/posts')) + `/${post.id}/comments`;
                        const json = await this.request(url, {
                            method: 'POST',
                            body: JSON.stringify(payload),
                        });
                        post.comments.push(json?.data);
                        post.commentDraft = '';
                        post.commentsAfterId = post.comments.reduce((max, c) => Math.max(max, c.id || 0), 0);
                        post.comments_count = (post.comments_count || 0) + 1;
                    } catch (e) {
                        this.error = e.message || 'Gagal mengirim komentar';
                    } finally {
                        post.submittingComment = false;
                    }
                },

                canDeleteComment(comment) {
                    if (!this.currentUserId) return false;
                    const commentUserId = comment?.user?.id;
                    const isOwner = Number(commentUserId) === Number(this.currentUserId);
                    const isAdmin = String(this.currentUserRole || '').toLowerCase() === 'admin';
                    return isOwner || isAdmin;
                },

                canDeletePost(post) {
                    if (!this.currentUserId) return false;
                    const postUserId = post?.user?.id;
                    const isOwner = Number(postUserId) === Number(this.currentUserId);
                    const isAdmin = String(this.currentUserRole || '').toLowerCase() === 'admin';
                    return isOwner || isAdmin;
                },

                async deleteComment(post, comment) {
                    if (!this.canDeleteComment(comment)) return;
                    const ok = window.confirm('Hapus komentar ini?');
                    if (!ok) return;

                    this.error = null;
                    post.deletingCommentId = comment.id;
                    try {
                        const url = @json(url('/forum/posts')) + `/${post.id}/comments/${comment.id}`;
                        await this.request(url, { method: 'DELETE' });

                        post.comments = post.comments.filter((c) => c.id !== comment.id);
                        post.commentsAfterId = post.comments.reduce((max, c) => Math.max(max, c.id || 0), 0);
                        post.comments_count = Math.max((post.comments_count || 0) - 1, 0);

                        if (post.latest_comments?.length) {
                            post.latest_comments = post.latest_comments.filter((c) => c.id !== comment.id);
                        }
                    } catch (e) {
                        this.error = e.message || 'Gagal menghapus komentar';
                    } finally {
                        post.deletingCommentId = null;
                    }
                },

                async deletePost(post) {
                    if (!this.canDeletePost(post)) return;
                    const ok = window.confirm('Hapus pertanyaan ini beserta semua komentarnya?');
                    if (!ok) return;

                    this.error = null;
                    this.deletingPostId = post.id;
                    try {
                        const url = @json(url('/forum/posts')) + `/${post.id}`;
                        await this.request(url, { method: 'DELETE' });
                        this.posts = this.posts.filter((p) => p.id !== post.id);
                    } catch (e) {
                        this.error = e.message || 'Gagal menghapus pertanyaan';
                    } finally {
                        this.deletingPostId = null;
                    }
                },
            }
        }
    </script>
@endpush
