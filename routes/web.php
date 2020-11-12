<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/login', 'AuthController@showLoginForm')->name('login');
Route::post('/login', 'AuthController@login')->name('auth.login');
Route::get('/register', 'AuthController@showRegisterForm')->name('register');
Route::post('/register_user', 'AuthController@register')->name('auth.register');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::get('/verify/{id}', 'AuthController@verifyPage')->name('verify'); // page seteleah register, pemberitahuan untuk konfirmasi email
Route::post('/resend', 'AuthController@resendConfirmation')->name('verification.resend');

Route::get('/confirmation_success/{id}', 'AuthController@confirmationSuccess')->name('auth.confirmation_success');
Route::post('/confirmation', 'AuthController@setConfirmation')->name('auth.confirmation'); // update email_confirmed and verified at in users table

Route::group(['middleware' => 'auth'], function() {
    Route::get('/all', 'NotificationController@allNotification')->name('all.notification');
    Route::get('/user_notification', 'NotificationController@userNotification')->name('user.notification');

    Route::get('/notifaction', 'AjaxController@getNotification')->name('ajax.notification');
    Route::get('/allnotifaction', 'AjaxController@allNotification')->name('ajax.allNotification');
    Route::get('/usernotifaction', 'AjaxController@userNotification')->name('ajax.userNotification');
    Route::post('/setclick', 'AjaxController@setClick')->name('ajax.setClick');

    Route::get('/share/{sharedValue}', 'AffiliateController@shareLink');

    Route::group(['prefix' => 'user'], function() {
        Route::get('/detail', 'Admin\UserController@detailProfile')->name('user.detail');
        Route::get('/edit', 'Admin\UserController@editProfile')->name('user.editProfile');
        Route::post('/update', 'Admin\UserController@updateProfile')->name('user.update');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'can:isAdmin'], function () {
        Route::get('/dashboard', 'HomeController@index')->name('admin.dashboard');

        Route::group(['prefix' => 'affiliate'], function() {
            Route::get('/list', 'Admin\AffiliateController@index')->name('affiliate.index');
            Route::get('/vendor', 'Admin\AffiliateController@vendor')->name('affiliate.byVendor');
            Route::get('/detail', 'Admin\AffiliateController@detail')->name('affiliate.detail');
            Route::get('/detailVendor', 'Admin\AffiliateController@detailVendor')->name('affiliate.detailVendor');
        });
        
        Route::group(['prefix' => 'vendor'], function() {
            Route::get('/list', 'Admin\VendorController@index')->name('vendor.index');
            Route::get('/add', 'Admin\VendorController@create')->name('vendor.add');
            Route::post('/store', 'Admin\VendorController@store')->name('vendor.store');
            Route::get('/edit/{id}', 'Admin\VendorController@edit')->name('vendor.edit');
            Route::post('/update', 'Admin\VendorController@update')->name('vendor.update');
            Route::post('/delete', 'Admin\VendorController@destroy')->name('vendor.destroy');
        });

        Route::group(['prefix' => 'transaction'], function() {
            Route::get('/list', 'Admin\TransactionController@index')->name('transaction.index');
            Route::post('/store', 'Admin\TransactionController@store')->name('transaction.store');
            Route::post('/cancel', 'Admin\TransactionController@cancel')->name('transaction.cancel');

            Route::get('/downloadPdf/{status}/{start_date}/{end_date}', 'Admin\TransactionController@downloadPdf');
        });

        Route::group(['prefix' => 'lead'], function() {
            Route::get('/list', 'Admin\LeadController@index')->name('lead.index');
            Route::post('/store', 'Admin\LeadController@store')->name('lead.store');
            Route::get('/proses', 'Admin\LeadController@prosesLead')->name('lead.detail');
            Route::post('/save', 'Admin\LeadController@saveProses')->name('lead.proses');
            Route::post('/cancel/{id}', 'Admin\LeadController@cancel')->name('lead.cancel');

            Route::get('/downloadPdf/{status}/{start_date}/{end_date}', 'Admin\LeadController@downloadPdf');
        });

        Route::group(['prefix' => 'withdraw'], function() {
            Route::get('/request', 'Admin\WithdrawController@index')->name('withdraw.request');
            Route::get('/proses', 'Admin\WithdrawController@proses')->name('withdraw.proses');
            Route::post('/payout', 'Admin\WithdrawController@payout')->name('withdraw.payout');
            Route::post('/delete/{id}', 'Admin\WithdrawController@destroy')->name('withdraw.destroy');
        });

        Route::group(['prefix' => 'komisi'], function() {
            Route::get('/list', 'Admin\KomisiController@index')->name('komisi.index');
            Route::post('/store', 'Admin\KomisiController@store')->name('komisi.store');
            Route::get('/edit', 'Admin\KomisiController@edit')->name('komisi.edit');
            Route::post('/update', 'Admin\KomisiController@update')->name('komisi.update');
            Route::post('/delete', 'Admin\KomisiController@destroy')->name('komisi.destroy');
        });

        Route::group(['prefix' => 'user_management'], function() {
            Route::get('/list', 'Admin\UserController@index')->name('user.index');
            Route::get('/detail_user/{id}', 'Admin\UserController@detailUser')->name('user.detailUser');
            Route::get('/edit_user/{id}', 'Admin\UserController@editUser')->name('user.editUser');    
        });

        Route::group(['prefix' => 'payout'], function() {
            Route::get('/list', 'Admin\PayoutController@index')->name('payout.index');
            Route::post('/store', 'Admin\PayoutController@store')->name('payout.store');
            Route::get('/edit', 'Admin\PayoutController@edit')->name('payout.edit');
            Route::post('/update', 'Admin\PayoutController@update')->name('payout.update');
            Route::post('/delete', 'Admin\PayoutController@destroy')->name('payout.destroy');
        });

        Route::group(['prefix' => 'script'], function() {
            Route::get('/referral_link', 'Admin\ScriptController@index')->name('script.index');
            Route::post('/store', 'Admin\ScriptController@store')->name('script.store');
        });

        Route::get('/setCommission', 'AjaxController@setCommission')->name('ajax.setCommission');
        Route::get('/getAffiliate', 'AjaxController@loadUserAffiliate')->name('ajax.getUserAffiliate');
        Route::get('/getProductService', 'AjaxController@getProductService')->name('ajax.getProductService');

        Route::get('/topAffiliate', 'DatatableController@topAffiliateAdmin')->name('datatableTopAffiliate');
        Route::get('/vendorAdmin', 'DatatableController@vendorAdmin')->name('datatableVendorAdmin');
        Route::get('/affiliateAdmin', 'DatatableController@affiliateAdmin')->name('datatableAffiliateAdmin');
        Route::get('/affiliateVendor', 'DatatableController@affiliateByVendor')->name('datatableAffiliateVendorAdmin');
        Route::get('/affiliateTransaction', 'DatatableController@detailAffiliateTransaction')->name('datatableDetailAffiliateAdmin');
        Route::get('/transactionAdmin', 'DatatableController@transactionAdmin')->name('datatableTransactionAdmin');
        Route::get('/leadAdmin', 'DatatableController@leadAdmin')->name('datatableLeadAdmin');
        Route::get('/widthdrawAdmin', 'DatatableController@withdrawalAdmin')->name('datatableWithdrawAdmin');
        Route::get('/userAdmin', 'DatatableController@userAdmin')->name('datatableUserAdmin');
        Route::get('/komisiAdmin', 'DatatableController@komisiAdmin')->name('datatableKomisiAdmin');
        Route::get('/payoutAdmin', 'DatatableController@payoutAdmin')->name('datatablePayoutAdmin');
    });

    Route::group(['prefix' => 'affiliate', 'middleware' => 'can:isAffiliator'], function () {
        Route::get('/dashboard', 'AffiliateController@dashboard')->name('affiliate.dashboard');
        Route::get('/vendor', 'AffiliateController@vendorList')->name('affiliate.vendor');
        
        Route::group(['prefix' => 'wallet'], function() {
            Route::get('/list', 'AffiliateController@wallet')->name('affiliate.wallet');
            Route::post('withdraw', 'AffiliateController@withdraw')->name('affiliate.withdraw');
            Route::get('/detail', 'AffiliateController@detailWithdraw')->name('affiliate.detailWithdraw');
        });

        Route::group(['prefix' => 'lead'], function() {
            Route::get('/list', 'AffiliateController@leadList')->name('affiliate.lead');
            Route::get('/downloadPdfLead/{status}/{start_date}/{end_date}', 'AffiliateController@downloadPdfLead');
        });

        Route::group(['prefix' => 'transaction'], function() {
            Route::get('/list', 'AffiliateController@transactionList')->name('affiliate.transaction');
            Route::get('/downloadPdfTransaction/{status}/{start_date}/{end_date}', 'AffiliateController@downloadPdfTransaction');
        });

        Route::get('/contact-admin', 'AffiliateController@contactAdmin')->name('affiliate.contactAdmin');
        Route::post('/send', 'AffiliateController@sendContact')->name('affiliate.sendContact');

        Route::get('/vendorAffiliate', 'DatatableController@vendorAffiliate')->name('datatableVendorAffiliate');
        Route::get('/transactionAffiliate', 'DatatableController@transactionAffiliate')->name('datatableTransactionAffiliate');
        Route::get('/leadAffiliate', 'DatatableController@leadAffiliate')->name('datatableLeadAffiliate');
        Route::get('/walletAffiliate', 'DatatableController@walletAffiliate')->name('datatableWalletAffiliate');

        Route::get('/clickAffiliate', 'DatatableController@clickAffiliate')->name('datatableClickAffiliate');
    });
});
