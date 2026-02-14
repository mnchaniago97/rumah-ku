@extends('admin.layouts.app')

@section('content')
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Pengaturan Website</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola halaman Tentang, Kontak, dan footer.</p>
      </div>
    </div>

    @if (session('success'))
      <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800 dark:border-green-900/40 dark:bg-green-900/20 dark:text-green-200">
        {{ session('success') }}
      </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
      <form method="POST" action="{{ route('admin.site-settings.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        @php
          $about = $settings['about'] ?? [];
          $contact = $settings['contact'] ?? [];
          $footer = $settings['footer'] ?? [];
          $legal = $settings['legal'] ?? [];

          $quickLinks = $footer['quick_links'] ?? [];
          while (count($quickLinks) < 6) $quickLinks[] = ['label' => '', 'url' => ''];

          $legalLinks = $footer['legal_links'] ?? [];
          while (count($legalLinks) < 4) $legalLinks[] = ['label' => '', 'url' => ''];
        @endphp

        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Halaman Tentang</h2>
              <p class="text-sm text-gray-500 dark:text-gray-400">Judul, subjudul, dan konten.</p>
            </div>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Judul</label>
              <input name="about[title]" value="{{ old('about.title', $about['title'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" required />
              @error('about.title')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Subjudul</label>
              <input name="about[subtitle]" value="{{ old('about.subtitle', $about['subtitle'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              @error('about.subtitle')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
          </div>

          <div>
            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Heading Konten</label>
            <input name="about[heading]" value="{{ old('about.heading', $about['heading'] ?? '') }}"
              class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            @error('about.heading')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
          </div>

          <div>
            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Konten</label>
            @php
              $aboutContent = old('about.content', $about['content'] ?? null);
              if ($aboutContent === null && filled($about['content_html'] ?? null)) {
                  $aboutContent = trim(preg_replace("/\\n{3,}/", "\n\n", strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $about['content_html']))));
              }
            @endphp
            <textarea name="about[content]" rows="6"
              class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white"
              placeholder="Tulis deskripsi tentang Rumah IO... (boleh pakai enter untuk paragraf)">{{ $aboutContent }}</textarea>
            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Teks biasa (tanpa HTML). Enter = baris baru/paragraf.</div>
            @error('about.content')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="h-px bg-gray-200 dark:bg-gray-800"></div>

        <div class="space-y-4">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Halaman Kontak</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi kontak dan lokasi.</p>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Judul</label>
              <input name="contact[title]" value="{{ old('contact.title', $contact['title'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" required />
              @error('contact.title')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Subjudul</label>
              <input name="contact[subtitle]" value="{{ old('contact.subtitle', $contact['subtitle'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              @error('contact.subtitle')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
          </div>

          <div>
            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Alamat</label>
            <input name="contact[address]" value="{{ old('contact.address', $contact['address'] ?? '') }}"
              class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            @error('contact.address')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Telepon</label>
              <input name="contact[phone]" value="{{ old('contact.phone', $contact['phone'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              @error('contact.phone')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Email</label>
              <input name="contact[email]" value="{{ old('contact.email', $contact['email'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              @error('contact.email')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">WhatsApp (teks)</label>
              <input name="contact[whatsapp]" value="{{ old('contact.whatsapp', $contact['whatsapp'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              @error('contact.whatsapp')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">WhatsApp Link</label>
              <input name="contact[whatsapp_link]" value="{{ old('contact.whatsapp_link', $contact['whatsapp_link'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              @error('contact.whatsapp_link')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Jam Operasional</label>
              <input name="contact[hours]" value="{{ old('contact.hours', $contact['hours'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              @error('contact.hours')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Catatan</label>
              <input name="contact[notes]" value="{{ old('contact.notes', $contact['notes'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              @error('contact.notes')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
          </div>

          <div>
            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Maps Embed (HTML)</label>
            <textarea name="contact[maps_embed_html]" rows="4"
              class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">{{ old('contact.maps_embed_html', $contact['maps_embed_html'] ?? '') }}</textarea>
            @error('contact.maps_embed_html')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="h-px bg-gray-200 dark:bg-gray-800"></div>

        <div class="space-y-4">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Halaman Legal</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kebijakan Privasi, Syarat Penggunaan, dan panduan komunitas.</p>
          </div>

          @php
            $legalPages = [
              'privacy_policy' => 'Kebijakan Privasi',
              'terms' => 'Syarat Penggunaan',
              'agent_terms' => 'Syarat Penggunaan Agen',
              'community_guideline' => 'Community Guideline',
            ];
          @endphp

          <div class="grid gap-4 md:grid-cols-2">
            @foreach($legalPages as $key => $label)
              <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800 md:col-span-2">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $label }}</div>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Konten teks biasa (tanpa HTML). Enter = baris baru.</div>
                  </div>
                </div>

                <div class="mt-4 grid gap-3 md:grid-cols-2">
                  <div class="md:col-span-2">
                    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Judul</label>
                    <input name="legal[{{ $key }}][title]" value="{{ old('legal.' . $key . '.title', $legal[$key]['title'] ?? $label) }}"
                      class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
                    @error('legal.' . $key . '.title')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
                  </div>

                  <div class="md:col-span-2">
                    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Konten</label>
                    <textarea name="legal[{{ $key }}][content]" rows="8"
                      class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white"
                      placeholder="Tulis konten {{ strtolower($label) }}...">{{ old('legal.' . $key . '.content', $legal[$key]['content'] ?? '') }}</textarea>
                    @error('legal.' . $key . '.content')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="h-px bg-gray-200 dark:bg-gray-800"></div>

        <div class="space-y-4">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Footer</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Brand, deskripsi, sosial media, tautan, dan kontak.</p>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Nama Brand</label>
              <input name="footer[brand]" value="{{ old('footer.brand', $footer['brand'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" required />
              @error('footer.brand')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
              <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Copyright</label>
              <input name="footer[copyright]" value="{{ old('footer.copyright', $footer['copyright'] ?? '') }}"
                class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              @error('footer.copyright')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
          </div>

          <div>
            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Deskripsi</label>
            <textarea name="footer[description]" rows="3"
              class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">{{ old('footer.description', $footer['description'] ?? '') }}</textarea>
            @error('footer.description')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
          </div>

          <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">
            <div class="text-sm font-semibold text-gray-900 dark:text-white">Sosial Media</div>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
              @foreach(['facebook' => 'Facebook', 'instagram' => 'Instagram', 'twitter' => 'Twitter/X', 'youtube' => 'YouTube', 'linkedin' => 'LinkedIn', 'whatsapp' => 'WhatsApp'] as $k => $label)
                <div>
                  <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">{{ $label }} URL</label>
                  <input name="footer[socials][{{ $k }}]" value="{{ old('footer.socials.' . $k, $footer['socials'][$k] ?? '') }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
                </div>
              @endforeach
            </div>
          </div>

          <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">
            <div class="text-sm font-semibold text-gray-900 dark:text-white">Tautan Cepat</div>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
              @foreach($quickLinks as $idx => $row)
                <div class="rounded-lg border border-gray-100 p-3 dark:border-gray-800">
                  <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Link {{ $idx+1 }}</div>
                  <div class="mt-2 grid gap-2">
                    <input name="footer[quick_links][{{ $idx }}][label]" value="{{ old('footer.quick_links.' . $idx . '.label', $row['label'] ?? '') }}"
                      placeholder="Label"
                      class="h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
                    <input name="footer[quick_links][{{ $idx }}][url]" value="{{ old('footer.quick_links.' . $idx . '.url', $row['url'] ?? '') }}"
                      placeholder="URL (contoh: /about)"
                      class="h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">
            <div class="text-sm font-semibold text-gray-900 dark:text-white">Kontak (Footer)</div>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
              <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Alamat</label>
                <input name="footer[contact][address]" value="{{ old('footer.contact.address', $footer['contact']['address'] ?? '') }}"
                  class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              </div>
              <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Telepon</label>
                <input name="footer[contact][phone]" value="{{ old('footer.contact.phone', $footer['contact']['phone'] ?? '') }}"
                  class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              </div>
              <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Email</label>
                <input name="footer[contact][email]" value="{{ old('footer.contact.email', $footer['contact']['email'] ?? '') }}"
                  class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              </div>
              <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">WhatsApp</label>
                <input name="footer[contact][whatsapp]" value="{{ old('footer.contact.whatsapp', $footer['contact']['whatsapp'] ?? '') }}"
                  class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
              </div>
            </div>
          </div>

          <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">
            <div class="text-sm font-semibold text-gray-900 dark:text-white">Link Bawah (Legal)</div>
            <div class="mt-4 grid gap-4 md:grid-cols-3">
              @foreach($legalLinks as $idx => $row)
                <div class="rounded-lg border border-gray-100 p-3 dark:border-gray-800">
                  <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Link {{ $idx+1 }}</div>
                  <div class="mt-2 grid gap-2">
                    <input name="footer[legal_links][{{ $idx }}][label]" value="{{ old('footer.legal_links.' . $idx . '.label', $row['label'] ?? '') }}"
                      placeholder="Label"
                      class="h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
                    <input name="footer[legal_links][{{ $idx }}][url]" value="{{ old('footer.legal_links.' . $idx . '.url', $row['url'] ?? '') }}"
                      placeholder="URL"
                      class="h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <button type="submit" class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-600">
            Simpan
          </button>
          <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/[0.03]">
            Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection
