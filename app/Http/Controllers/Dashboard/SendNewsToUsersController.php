<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Notifications\SendNewsToUserRequest;
use App\Notifications\NewsNotification;

use App\Models\SendNewsToUser;
use App\Models\User;
use App\Repositories\SendNewsToUser\SendNewsToUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SendNewsToUsersController extends Controller
{
  public $SendNewsToUser;
  public function __construct(SendNewsToUserRepository $repo)
  {
    $this->SendNewsToUser = $repo;
  }

  public function create()
  {
    //Gate::authorize('news.view');
    $users = $this->SendNewsToUser->create();
    return view('dashboard.send_news_to_users.create', compact('users'));
  }

  public function sendNewsMail(SendNewsToUserRequest $request)
  {
    $userIds = (array) $request->input('users', []);
    $users   = SendNewsToUser::whereIn('id', $userIds)->get();
    $sent    = 0;
    $failed  = 0;

    foreach ($users as $user) {
      try {
        $user->notify(new NewsNotification(
          $request->input('title'),
          $request->input('body'),
          $user
        ));
        $sent++;
        // Respect Mailtrap / SMTP rate limits — 1 second between sends
        if ($users->count() > 1) usleep(1100000);
      } catch (\Exception $e) {
        \Log::error('Newsletter send failed for: ' . $user->subscription_email . ' — ' . $e->getMessage());
        $failed++;
      }
    }

    $msg = "تم إرسال النشرة البريدية بنجاح إلى {$sent} مشترك.";
    if ($failed > 0) {
      $msg .= " (فشل الإرسال لـ {$failed} بريد)";
    }

    return redirect()->back()->with('success', $msg);
  }
}
