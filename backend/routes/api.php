<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RiderRatingQuestionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\BankDetailController;
use App\Http\Controllers\OrderCancelQuestionController;
use App\Http\Controllers\OrderRiderLocationController;
use App\Http\Controllers\OrderRiderQuestionsRatingController;
use App\Http\Controllers\OrderRiderRatingController;
use App\Http\Controllers\OrderTransactionController;
use App\Http\Controllers\PendingInfoController;
use App\Http\Controllers\RestaurantOccurrenceController;
use App\Http\Controllers\RestaurantRatingQuestionController;
use App\Http\Controllers\RestaurantRefillController;
use App\Http\Controllers\RestaurantRiderQuestionsRatingController;
use App\Http\Controllers\RestaurantRiderRatingController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SupportQuestionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ChatUserController;
use App\Http\Controllers\ChatMessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('payment-method', [TransactionController::class, 'paymentMethodApis']);


Route::middleware("sessionAuth")->group(function () {
    // Admin Calls
    Route::get("get-countries", [AdminController::class, 'get_countries'])->name("GetCountries");
    Route::post("admin-login", [AdminController::class, 'login'])->name("AdminLogin");
    Route::get("get-cities", [AdminController::class, 'get_cities_against_country'])->name("GetCities");
    Route::get("get-locations", [AdminController::class, 'get_locations_against_cities'])->name("GetLocationAgainstCities");
    // Admin Callsw

    // Rider Calls
    Route::post("rider-register", [RiderController::class, 'store'])->name("RiderRegister");
    Route::post("rider-login", [RiderController::class, 'login'])->name("RiderLogin");

    Route::post("rider-check-forget-password-token", [RiderController::class, 'check_forget_password_token'])->name("CheckRiderForgetPasswordToken");
    Route::post("rider-check-email-for-forget-password", [RiderController::class, 'rider_check_email_for_forget_password'])->name("RiderCheckEmailForForgetPassword");
    Route::post("update-rider-password", [RiderController::class, 'update_password'])->name("UpdateRiderPassword");
    // Rider Calls

    // Restaurant Calls
    Route::post("rest-login", [RestaurantController::class, 'login'])->name("RestaurantLogin");
    Route::post("verify-rest-email", [RestaurantController::class, 'verify_email'])->name("RestaurantEmailVerify");
    Route::post("check-forget-password-token", [RestaurantController::class, 'check_forget_password_token'])->name("CheckRestaurantForgetPasswordToken");
    Route::post("update-password", [RestaurantController::class, 'update_password'])->name("UpdateRestaurantPassword");
    // Restaurant Calls
});

Route::middleware("sessionAuth")->prefix('/rest/')->group(function () {
    //Address Calls
    Route::post("address", [AddressController::class, 'store'])->name("StoreAddress");
    Route::get("get-addresses-by-name", [AddressController::class, 'get_addresses_by_name'])->name("GetAddressesByName");
    Route::get("get-all-addresses", [AddressController::class, 'index'])->name("GetAllAddresses");
    //Address Calls

    // Admin Controller Calls
    Route::post('save-pn-token', [AdminController::class, 'save_push_notif_token'])->name("SavePNTokenRest");
    Route::get('check-token', [AdminController::class, 'check_push_notif_token'])->name("CheckTokenRest");
    // Admin Controller Calls

    //Orders Calls
    Route::post("order", [OrderController::class, 'store'])->name("StoreOrder");
    Route::post("get-orders", [OrderController::class, 'index'])->name("GetRestaurantOrders");
    Route::post("rest-remove-rider/{order_id}", [OrderController::class, 'rest_remove_rider'])->name("RestaurantRemoveRider");
    Route::post("cancel-order/{order}", [OrderController::class, 'cancel_order_by_rest'])->name("RestaurantCancelOrder");
    //Orders Calls

    // Branch Calls
    Route::get("get-branches-by-name", [BranchController::class, 'get_branches_by_name'])->name("GetBranchesByName");
    // Branch Calls


    // Restaurant Occurrences Calls
    Route::post("store-restaurant-occurrence/{order_id}", [RestaurantOccurrenceController::class, 'store'])->name("StoreRestaurantOccurrence");
    // Restaurant Occurrences Calls

    // Restaurant Refills Calls
    Route::post('store-refills', [RestaurantRefillController::class, 'store'])->name("StoreRefills");
    // Restaurant Refills Calls

    // Restaurant Give Rider Rating and Review Calls
    Route::post("store-order-rider-question-rating/{order}", [OrderRiderQuestionsRatingController::class, 'store'])->name("OrderRiderQuestionRating");
    Route::get("get-rating-of-order/{order}", [OrderRiderQuestionsRatingController::class, 'get_rider_ratings_against_order'])->name("GetRatingOfOrder");
    // Restaurant Give Rider Rating and Review Calls

    // Chat User Controller
    Route::post("start-chat/{order_id}", [ChatUserController::class, 'store_rest'])->name('StoreChatRest');
    Route::post("add-chat-message/{order}", [ChatMessageController::class, 'store_rest'])->name('StoreChatMessageFromRest');
    Route::post("get-messages/{order_id}", [ChatMessageController::class, 'get_rest_messages'])->name('GetChatMessagesHistoryRest');
    // Chat User Controller

    // Order Cancel Question Controller
    Route::get("get-active-cancel-questions", [OrderCancelQuestionController::class, 'restaurant_index']);

    // Order Cancel Question Controller

    // Restaurant Controller
    Route::get("rest-logout", [RestaurantController::class, 'logout'])->name('RestLogout');
    // Restaurant Controller

    // Rider Rating Question Controller
    Route::get("rider-rating-active-questions", [RiderRatingQuestionController::class, 'index_active'])->name("AllRiderRatingActiveQuestions");
    // Rider Rating Question Controller
});

Route::middleware("sessionAuth")->prefix('/rider/')->group(function () {
    // Admin Controller Calls
    Route::post('save-pn-token', [AdminController::class, 'save_push_notif_token'])->name("SavePNTokenRider");
    Route::get('check-token', [AdminController::class, 'check_push_notif_token'])->name("CheckTokenRider");
    // Admin Controller Calls

    // Region Calls
    Route::get("all-regions", [RegionController::class, 'get_all_regions_app'])->name("AllRegionsApp");
    // Region Calls

    //Order Controller Calls
    Route::post("accept-order/{order}", [OrderController::class, 'accept_order'])->name("AcceptOrder");
    Route::get('nearby-orders', [OrderController::class, 'show']);
    Route::post("complete-order/{order}", [OrderController::class, 'completed_order'])->name("CompleteOrder");
    Route::post("cancel-order/{order}", [OrderController::class, 'cancel_order_by_rider'])->name("CancelOrderByRider");
    Route::post("update-order-collect-time/{order}", [OrderController::class, 'update_collect_time'])->name("UpdateCollectTime");
    Route::get("get-location/{order}", [OrderController::class, 'get_location'])->name("GetLocation");
    Route::get("get-order/{order}", [OrderController::class, 'get_order_address'])->name("GetOrderAddress");
    Route::get("rider-orders-balance", [OrderController::class, 'rider_orders_balance'])->name("RiderDayBalance");
    Route::get("rider-orders", [OrderController::class, 'rider_orders'])->name("RiderOrders");
    Route::get("rider-day-orders", [OrderController::class, 'rider_day_orders'])->name("RiderDayOrders");
    Route::post("search-order-rider-date", [OrderController::class, 'search_orders_rider_date'])->name("SearchOrderRiderDate");
    Route::get("get-all-canceled-orders", [OrderController::class, 'rider_all_cancel_orders'])->name("GetAllCanceledOrders");
    Route::post("rider-reject/{order}", [OrderController::class, 'reject_order_by_rider'])->name("RejectOrderByRider");
    //Order Controller Calls

    // Rider Controller Calls
    Route::post("rider-status", [RiderController::class, 'rider_available_status_update'])->name("RiderStatus");
    Route::get("rider-logout", [RiderController::class, 'logout'])->name("RiderLogout");
    Route::get("me", [RiderController::class, 'show'])->name("Me");
    Route::post('change-password', [RiderController::class, 'change_password']);
    Route::post('rider-details-update', [RiderController::class, 'update_rider_details']);
    Route::get('show-rider-details', [RiderController::class, 'show_details']);
    Route::post("get-rider-in-progress-order", [RiderController::class, 'get_rider_in_progress_order'])->name('GetRiderLastOpenOrder');
    // Rider Controller Calls

    // Transactions Controller
    Route::post('get-transactions', [TransactionController::class, 'index'])->name("GetRiderTransactions");
    Route::post('store-rider-transaction', [TransactionController::class, 'store'])->name("StoreRiderTransaction");
    // Transactions Controller

    // Order Rider Questions Rating Calls
    Route::post("store-restaurant-rider-question-rating/{order}", [RestaurantRiderQuestionsRatingController::class, 'store'])->name("RestaurantRiderQuestionRating");
    // Order Rider Questions Rating Calls

    // Order cancel Questions
    // Rating Active Questions
    Route::get("rider-rating-active-questions", [RestaurantRatingQuestionController::class, 'index_active']);

    // Me Call 

    // Order Rider Location Calls
    Route::post("rider-location", [OrderRiderLocationController::class, 'store']);
    // change password

    // bank_detail update
    Route::post('bank-details/{bank_detail}', [PendingInfoController::class, 'bank_details']);
    Route::post('bank-details-update', [BankDetailController::class, 'update']);
    Route::get('show-bank-details/{id}', [BankDetailController::class, 'show']);
    // Rider update
    Route::post('rider-details', [PendingInfoController::class, 'store']);

    // Support Call Add
    Route::post("add-support", [SupportController::class, 'store']);
    Route::get("get-support-questions", [SupportQuestionController::class, 'index']);
    // Support

    //Chat Message Controller Calls
    Route::post("add-chat-message-to-rest/{order}", [ChatMessageController::class, 'store_rider_for_rest'])->name('StoreChatMessageFromRiderToRest');
    Route::post("add-chat-message-to-admin/{order}", [ChatMessageController::class, 'store_rider_for_admin'])->name('StoreChatMessageFromRiderToAdmin');
    Route::post("get-messages-admin/{order}", [ChatMessageController::class, 'get_rider_messages_admin'])->name('GetChatMessagesHistoryAdmin');
    Route::post("get-messages-rest/{order}", [ChatMessageController::class, 'get_rider_messages_rest'])->name('GetChatMessagesHistoryRest');
    //Chat Message Controller Calls

    //Cancel Order 
    Route::get("get-active-cancel-questions", [OrderCancelQuestionController::class, 'rider_index']);
    Route::post("cancel-order/{order_id}", [CancelOrderController::class, 'store'])->name('StoreCancelOrder');
    //Cancel Order Controller
});

Route::middleware("sessionAuth")->prefix('/admin/')->group(function () {
    // Admin Calls
    Route::post("store-admin", [AdminController::class, 'store'])->name("StoreAdmin");
    Route::get("get-admins", [AdminController::class, 'index'])->name("GetAdmins");
    Route::post("delete-admin", [AdminController::class, 'delete'])->name("DeleteAdmins");
    Route::post("update-admin", [AdminController::class, 'update'])->name("UpdateAdmin");
    Route::post('save-pn-token', [AdminController::class, 'save_push_notif_token'])->name("SavePNTokenAdmin");
    Route::get('check-token', [AdminController::class, 'check_push_notif_token'])->name("CheckTokenAdmin");
    Route::get("admin-logout", [AdminController::class, 'logout'])->name('AdminLogout');
    // Admin Calls

    // Rider Calls
    Route::post("get-riders", [RiderController::class, 'index'])->name("GetRiders");
    Route::post("block-rider", [RiderController::class, 'block_rider'])->name("BlockRider");
    Route::post("unblock-rider", [RiderController::class, 'unblock_rider'])->name("UnblockRider");
    Route::post("exclude-driver", [RiderController::class, 'exclude_driver'])->name("ExcludeRider");
    Route::post("update-rider/{id}", [RiderController::class, 'update'])->name("UpdateRiderInfo");
    Route::get("get-riders-by-name", [RiderController::class, 'get_riders_by_name'])->name("GetRidersByName");
    Route::get("get-riders-by-name-admin", [RiderController::class, 'get_riders_by_name_admin'])->name("GetRidersByNameAdmin");
    // Rider Calls

    // Region Calls
    Route::post("region", [RegionController::class, 'store'])->name("StoreRegion");
    Route::post("update-region/{id}", [RegionController::class, 'update'])->name("UpdateRegion");
    Route::get("all-regions", [RegionController::class, 'get_all_regions'])->name("AllRegions");
    Route::get("active-regions", [RegionController::class, 'get_active_regions'])->name("AllActiveRegions");
    Route::get("get-regions-by-name", [RegionController::class, 'get_regions_by_name'])->name("GetRegionsByName");
    // Region Calls

    // Restaurant Calls
    Route::post("restaurant", [RestaurantController::class, 'store'])->name("StoreRestaurant");
    Route::post("delete-restaurant", [RestaurantController::class, 'exclude_rest'])->name("DeleteRestaurant");
    Route::post("all-rests", [RestaurantController::class, 'index'])->name("AllRests");
    Route::post("block-restaurant", [RestaurantController::class, 'block_rest'])->name("BlockRestaurant");
    Route::post("active-restaurants", [RestaurantController::class, 'get_active_restaurants'])->name("AllActiveRestaurants");
    Route::post("unblock-restaurants", [RestaurantController::class, 'unblock_rest'])->name("UnblockRestaurants");
    Route::get("get-restaurant/{id}", [RestaurantController::class, 'show'])->name("GetSingleRestaurant");
    Route::get("get-restaurants-by-name", [RestaurantController::class, 'get_rests_by_name'])->name("GetRestaurantsByName");
    Route::post("update-restaurant-props/{id}", [RestaurantController::class, 'update_restaurant_props'])->name("UpdateRestaurantProperties");
    Route::post("restaurant/{restaurant}", [RestaurantController::class, 'update'])->name("UpdateRestaurant");
    // Restaurant Calls

    // Rider Rating Questions Calls
    Route::get("rider-rating-questions", [RiderRatingQuestionController::class, 'index'])->name("AllRiderRatingQuestions");
    Route::post("rider-rating-question", [RiderRatingQuestionController::class, 'store'])->name("AddRiderRatingQuestion");
    Route::post("update-rider-rating-question", [RiderRatingQuestionController::class, 'update'])->name("UpdateRiderRatingQuestion");
    Route::post("get-rider-rating-question", [RiderRatingQuestionController::class, 'show'])->name("GetRiderRatingQuestion");
    // Rider Rating Questions Calls

    // Restaturant Reviews calls
    Route::post("get-order-rider-ratings/{rider}", [OrderRiderRatingController::class, 'index']);
    //  update status api
    Route::post("rider-review-status/{review}", [OrderRiderRatingController::class, 'update']);
    // get review Rider Reviews

    // Branch Calls
    Route::post("branch/{rest_id}", [BranchController::class, 'store'])->name("StoreBranch");
    Route::post("get-branches", [BranchController::class, 'index'])->name("GetBranches");
    Route::post("update-branch/{branch_id}", [BranchController::class, 'update'])->name("UpdateBranch");
    // Branch Calls

    // Setting Calls
    Route::get("settings", [SettingController::class, 'index'])->name("GetSettings");
    Route::post("update-settings", [SettingController::class, 'update_page_one'])->name("UpdateSetting");
    Route::post("update-settings-page-two", [SettingController::class, 'update_page_two'])->name("UpdateSettingPageTwo");
    // Setting Calls

    // Notification Calls
    Route::post("send-notification", [NotificationController::class, 'store'])->name("StoreNotification");
    Route::get("get-notifications", [NotificationController::class, 'index'])->name("GetNotifications");
    Route::get("update-notifications/{id}", [NotificationController::class, 'update'])->name("UpdateNotification");
    // Notification Calls

    //Orders Calls
    Route::get("report-screen-data", [OrderController::class, 'report_screen_dependencies'])->name("ReportScreenDependencyData");
    Route::get("get-all-orders/{rest_id}", [OrderController::class, 'get_all_order'])->name("GetAllOrders");
    Route::get("get-rider-orders/{rider_id}", [OrderController::class, 'get_rider_order'])->name("GetRiderOrders");
    Route::post("get-filter-orders", [OrderController::class, 'get_filter_orders'])->name("GetFilterOrders");
    Route::post("order-details/{id}", [OrderController::class, 'order_details_admin'])->name("GetOrderDetailsForAdmin");
    Route::post("get-latest-location/{id}", [OrderController::class, 'order_rider_latest_location'])->name("OrderRiderLatestLocation");
    //Orders Calls

    // Order Rider Questions Rating Calls
    Route::post("get-riders-who-got-rated", [OrderRiderQuestionsRatingController::class, 'get_riders_who_got_rate_by_restaurants'])->name("GetRidersWhoGotRatingByRestaurants");
    Route::get("get-single-rider-ratings/{id}", [OrderRiderQuestionsRatingController::class, 'get_single_rider_ratings'])->name("GetSingleRiderRatings");
    // Order Rider Questions Rating Calls

    // Restaurant Occurrences Calls
    Route::get("get-restaurant-occurrences", [RiderController::class, 'occurrences'])->name("GetRestaurantOccurrence");
    Route::get("get-rider-stats/{rider}", [RiderController::class, 'stats'])->name("GetRiderStats");
    Route::post("get-occurrences/{rider}", [RestaurantOccurrenceController::class, 'index'])->name("GetOccurrence");
    // Restaurant Occurrences Calls

    // Order Cancel Questions Calls
    Route::post("store-order-cancel-question", [OrderCancelQuestionController::class, 'store'])->name('StoreCancelOrderQuestion');;
    Route::get("get-order-cancel-questions", [OrderCancelQuestionController::class, 'index'])->name('GetCancelOrderQuestions');
    Route::post("update-order-cancel-question", [OrderCancelQuestionController::class, 'update'])->name('UpdateCancelOrderQuestions');
    // Order Cancel Questions Calls

    // Transactions Admin Calls
    Route::post('all-transactions', [TransactionController::class, 'show'])->name("GetAllTransactions");
    Route::post('store-admin-transaction', [TransactionController::class, 'admin_transaction_request'])->name("StoreAdminTransaction");
    // Transactions Admin Calls

    // Restaurant Rating Questions Calls
    Route::get("restaurant-rating-questions", [RestaurantRatingQuestionController::class, 'index'])->name("AllRestaurantRatingQuestions");
    Route::get("restaurant-rating-active-questions", [RestaurantRatingQuestionController::class, 'index_active'])->name("AllRestaurantRatingActiveQuestions");
    Route::post("restaurant-rating-question", [RestaurantRatingQuestionController::class, 'store'])->name("AddRestaurantRatingQuestion");
    Route::post("update-restaurant-rating-question", [RestaurantRatingQuestionController::class, 'update'])->name("UpdateRestaurantRatingQuestion");
    Route::post("get-restaurant-rating-question", [RestaurantRatingQuestionController::class, 'show'])->name("GetRestaurantRatingQuestion");
    Route::delete("delete-restaurant-rating-question/{id}", [RestaurantRatingQuestionController::class, 'destroy'])->name("DeleteRestaurantRatingQuestion");
    // Restaurant Rating Questions Calls

    // Restaturant Reviews calls
    Route::post("get-restaurant-rider-ratings", [RestaurantRiderRatingController::class, 'index']);
    //  update status api
    Route::post("restaurant-review-status/{review}", [RestaurantRiderRatingController::class, 'update']);
    // Restaturant Reviews calls

    // Finance Calls
    // Route::post("get-finance", [TransactionController::class, 'index']);
    // Finance Calls

    // bank_detail update
    Route::post('bank-details-update', [BankDetailController::class, 'update']);
    Route::get('show-bank-details/{id}', [BankDetailController::class, 'show']);
    // Rider detail update
    Route::post('rider-details-update', [RiderController::class, 'update_rider_details']);
    Route::get('show-rider-details/{id}', [RiderController::class, 'show_details']);

    //   Support Question calls
    Route::post("support-questions-admin", [SupportQuestionController::class, 'index_admin']);
    Route::post("support-question", [SupportQuestionController::class, 'store']);
    Route::get("delete-support-question/{id}", [SupportQuestionController::class, 'destroy']);
    //   Support Question calls

    // Rider Supports
    Route::get("supports", [SupportController::class, 'index']);
    // Rider Supports

    //Chat User Controller Calls
    Route::post("start-chat/{order_id}", [ChatUserController::class, 'store'])->name('StoreChatUser');
    //Chat User Controller Calls

    //Chat Message Controller Calls
    Route::post("add-chat-message/{order}", [ChatMessageController::class, 'store'])->name('StoreChatMessageFromAdmin');
    Route::post("get-all-messages/{order}", [ChatMessageController::class, 'get_admin_messages'])->name('GetAllMessagesAdmin');
    //Chat Message Controller Calls

    //Address Controller
    Route::get("get-all-addresses", [AddressController::class, 'index'])->name("GetAllAddressesAdmin");
    //Address Controller
});
