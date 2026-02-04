<div class="flex items-center" wire:poll.2s>
    <div class="flex max-w-md flex-col gap-2 rounded-xl border border-gray-100 bg-white/90 px-3 py-2 text-right shadow-sm">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                <span>الإشعارات</span>
                @if ($this->unreadCount > 0)
                    <span class="inline-flex items-center rounded-full bg-amber-500 px-2 py-0.5 text-xs font-bold text-white">
                        {{ $this->unreadCount }}
                    </span>
                @endif
            </div>
            <span class="text-[11px] text-gray-400">تحديث لحظي</span>
        </div>

        <div class="flex flex-col gap-1 text-xs text-gray-600">
            @forelse ($this->notifications as $notification)
                <div class="flex items-center justify-between gap-2">
                    <span class="line-clamp-1 max-w-[220px] font-medium text-gray-700">
                        {{ $notification->data['title'] ?? $notification->data['message'] ?? $notification->type }}
                    </span>
                    <span class="shrink-0 text-[10px] text-gray-400">
                        {{ $notification->created_at?->diffForHumans() }}
                    </span>
                </div>
            @empty
                <div class="text-[11px] text-gray-400">لا توجد إشعارات حالياً</div>
            @endforelse
        </div>
    </div>
</div>
