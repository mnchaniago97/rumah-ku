@php
  /** @var \App\Models\SubscriptionPlan|null $plan */
  $plan = $plan ?? null;

  $currentName = old('name', $plan->name ?? '');
  $currentSubtitle = old('subtitle', $plan->subtitle ?? '');
  $currentBadge = old('badge', $plan->badge ?? '');

  $currentAgentType = old('agent_type', $plan->agent_type ?? ($type ?? null));
  $nameOptions = \App\Models\SubscriptionPlan::allowedNamesForAgentType((string)($currentAgentType ?? ''));
  $subtitleOptions = \App\Models\SubscriptionPlan::subtitleOptions();
  $badgeOptions = \App\Models\SubscriptionPlan::badgeOptions();

  $featuresText = old('features_text');
  if ($featuresText === null && $plan) {
      $featuresText = is_array($plan->features) ? implode("\n", $plan->features) : '';
  }

  $accessJson = old('access_json');
  if ($accessJson === null && $plan) {
      $accessJson = $plan->access ? json_encode($plan->access, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '';
  }
@endphp

<div class="grid gap-4 md:grid-cols-2">
  <div>
    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Tipe Agent</label>
    <select name="agent_type" class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" required>
      @foreach(($typeOptions ?? []) as $k => $label)
        <option value="{{ $k }}" @selected(old('agent_type', $plan->agent_type ?? ($type ?? null)) === $k)>{{ $label }}</option>
      @endforeach
    </select>
    @error('agent_type')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Nama Paket</label>
    <select name="name"
      class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white"
      required>
      @foreach($nameOptions as $val => $label)
        <option value="{{ $val }}" @selected($currentName === $val)>{{ $label }}</option>
      @endforeach
    </select>
    @error('name')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Subjudul (opsional)</label>
    <select name="subtitle"
      class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
      <option value="" @selected($currentSubtitle === '')>-</option>
      @foreach($subtitleOptions as $val => $label)
        <option value="{{ $val }}" @selected($currentSubtitle === $val)>{{ $label }}</option>
      @endforeach
    </select>
    @error('subtitle')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Badge (opsional)</label>
    <select name="badge"
      class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
      <option value="" @selected($currentBadge === '')>-</option>
      @foreach($badgeOptions as $val => $label)
        <option value="{{ $val }}" @selected($currentBadge === $val)>{{ $label }}</option>
      @endforeach
    </select>
    @error('badge')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
  </div>

  <div class="grid grid-cols-2 gap-3">
    <div>
      <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Harga (angka)</label>
      <input type="number" min="0" name="price" value="{{ old('price', $plan->price ?? '') }}"
        class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
      <div class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">Kosongkan untuk "Hubungi kami".</div>
      @error('price')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
    </div>
    <div>
      <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Periode</label>
      <input name="period_label" value="{{ old('period_label', $plan->period_label ?? '') }}"
        placeholder="per bulan / per iklan / custom"
        class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
      @error('period_label')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
    </div>
  </div>

  <div class="grid grid-cols-3 gap-3 md:col-span-2">
    <label class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
      <input type="checkbox" name="is_active" value="1" @checked((bool)old('is_active', $plan?->is_active ?? true)) />
      Aktif
    </label>
    <label class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
      <input type="checkbox" name="is_highlight" value="1" @checked((bool)old('is_highlight', $plan?->is_highlight ?? false)) />
      Highlight
    </label>
    <div>
      <input type="number" min="0" max="65535" name="sort_order" value="{{ old('sort_order', $plan->sort_order ?? 0) }}"
        class="h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
      <div class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">Urutan tampil</div>
      @error('sort_order')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
    </div>
  </div>

  <div class="md:col-span-2">
    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Fitur (1 baris = 1 fitur)</label>
    <textarea name="features_text" rows="5"
      class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">{{ $featuresText }}</textarea>
    @error('features_text')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
  </div>

  <div class="md:col-span-2">
    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Akses (JSON, opsional)</label>
    <textarea name="access_json" rows="5"
      placeholder='Contoh: { "listings": 10, "boost": true, "stats": true }'
      class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 font-mono text-xs dark:border-gray-800 dark:bg-gray-900 dark:text-white">{{ $accessJson }}</textarea>
    @error('access_json')<div class="mt-1 text-xs text-red-600">{{ $message }}</div>@enderror
  </div>
</div>
