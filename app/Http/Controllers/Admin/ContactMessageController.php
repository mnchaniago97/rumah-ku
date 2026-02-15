<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->get('filter', 'unread'); // unread|all

        $query = ContactMessage::query()->orderByDesc('created_at')->orderByDesc('id');
        if ($filter === 'unread') {
            $query->unread();
        }

        $messages = $query->paginate(20)->withQueryString();

        return view('admin.pages.contact-messages.index', [
            'title' => 'Pesan Kontak',
            'filter' => $filter,
            'messages' => $messages,
            'unreadCount' => ContactMessage::query()->unread()->count(),
        ]);
    }

    public function show(ContactMessage $contactMessage): View
    {
        if (!$contactMessage->is_read) {
            $contactMessage->forceFill([
                'is_read' => true,
                'read_at' => Carbon::now(),
            ])->save();
        }

        return view('admin.pages.contact-messages.show', [
            'title' => 'Detail Pesan',
            'message' => $contactMessage,
        ]);
    }

    public function markRead(ContactMessage $contactMessage): RedirectResponse
    {
        if (!$contactMessage->is_read) {
            $contactMessage->forceFill([
                'is_read' => true,
                'read_at' => Carbon::now(),
            ])->save();
        }

        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function markUnread(ContactMessage $contactMessage): RedirectResponse
    {
        if ($contactMessage->is_read) {
            $contactMessage->forceFill([
                'is_read' => false,
                'read_at' => null,
            ])->save();
        }

        return back()->with('success', 'Pesan ditandai belum dibaca.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}

