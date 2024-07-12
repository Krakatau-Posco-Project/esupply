<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // view()->composer(['layouts.master'], function ($view) {
        //     $view->with('notifpicapproverequest', Transaction::where('pic_approver', auth()->user()->id_user_me)->where('purchase_type', 'Purchase Request Proposal')->where('pic_approval', 'Pending')->count())
        //         ->with('notifpicapprovedirect', Transaction::where('pic_approver', auth()->user()->id_user_me)->where('purchase_type', 'Direct Pick Up')->where('pic_approval', 'Pending')->count())
        //         ->with('notiftluserapproverequest', Transaction::where('tl_approver', auth()->user()->id_user_me)->where('purchase_type', 'Purchase Request Proposal')->where('tl_approval', 'Pending')->count())
        //         ->with('notiftlgamapproverequest', Transaction::where('tlgam_approver', auth()->user()->id_user_me)->where('purchase_type', 'Purchase Request Proposal')->where('tlgam_approval', 'Pending')->count());
        // });

        view()->composer(['layouts.master'], function ($view) {
            $view->with('transaction', Transaction::where('created_at', '>', now()->subDays(31)->endOfDay())->get())
                ->with('pr_trans', Transaction::where('created_at', '>', now()->subDays(31)->endOfDay())->whereHas('user', function ($query){
                    $query->where('id_org_unit', auth()->user()->id_org_unit);
                })->where('purchase_type', 'Purchase Request Proposal')->get());
        });


        Gate::Define('admin', function (User $user) { //use on 'can'/'canany' blade
            return $user->priv === 'admin';
        });
        Gate::Define('pic', function (User $user) {
            return $user->priv === 'pic';
        });
        Gate::Define('tluser', function (User $user) {
            return $user->priv === 'tluser';
        });
        Gate::Define('tlgam', function (User $user) {
            return $user->priv === 'tlgam';
        });

    }
}
