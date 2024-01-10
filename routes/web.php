<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\RoleController;


use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\Frontend\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'Index']);


Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/password/change', [UserController::class, 'UserPasswordChange'])->name('user.password.change');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
    
});

//** Admin Group Middleware Start **/ 
Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');
    Route::get('/admin/password/change', [AdminController::class, 'AdminPasswordChange'])->name('admin.password.change');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
    
}); 
//** Admin Group Middleware End **/

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');


//** Admin Group Middleware Start **/ 
Route::middleware(['auth', 'roles:admin'])->group(function () {

    //** All Team Routes Start **/
    Route::controller(TeamController::class)->group(function () {
        Route::get('/team/all', 'TeamAll')->name('team.all')->middleware('permission:team.all');
        Route::get('/team/add', 'TeamAdd')->name('team.add')->middleware('permission:team.add');
        Route::post('/team/store', 'TeamStore')->name('team.store');
        Route::get('/team/edit/{id}', 'TeamEdit')->name('team.edit');
        Route::post('/team/update', 'TeamUpdate')->name('team.update');
    });
    //** All Team Routes End **/

    //** All Booking Area Routes Start **/
    Route::controller(TeamController::class)->group(function () {
        Route::get('/team/booking/area/edit', 'TeamBookingAreaEdit')->name('team.booking.area.edit'); 
        Route::post('/team/booking/area/update', 'TeamBookingAreaUpdate')->name('team.booking.area.update');   

    });
    //** All Booking Area Routes End **/

    //** All Room Type Routes Start **/
    Route::controller(RoomTypeController::class)->group(function () {
        Route::get('/room/type/list', 'RoomTypeList')->name('room.type.list'); 
        Route::get('/room/type/add', 'RoomTypeAdd')->name('room.type.add');
        Route::post('/room/type/store', 'RoomTypeStore')->name('room.type.store'); 

    });
    //** All Room Type Routes End **/

     //** All Room Routes Start **/
     Route::controller(RoomController::class)->group(function () {
        Route::get('/room/edit/{id}', 'RoomEdit')->name('room.edit'); 
        Route::post('/room/update/{id}', 'RoomUpdate')->name('room.update');
        Route::get('/multi/image/delete/{id}', 'MultiImageDelete')->name('multi.image.delete'); 
        Route::post('/room/number/store/{id}', 'RoomNumberStore')->name('room.number.store');
        Route::get('/room/number/edit/{id}', 'RoomNumberEdit')->name('room.number.edit');
        Route::post('/room/number/update/{id}', 'RoomNumberUpdate')->name('room.number.update');
        Route::get('/room/number/delete/{id}', 'RoomNumberDelete')->name('room.number.delete');

        Route::get('/room/delete/{id}', 'RoomDelete')->name('room.delete');

    });
    //** All Room Routes End **/

     //** All Admin Booking Routes Start **/
     Route::controller(BookingController::class)->group(function () {
        Route::get('/booking/list', 'BookingList')->name('booking.list'); 
        Route::get('/booking/edit/{id}', 'BookingEdit')->name('booking.edit'); 

        Route::get('/download/invoice/{id}', 'DownloadInvoice')->name('download.invoice'); 

        
    });
     //** All Admin Booking Routes End **/


     //** All Admin Room List Routes Start **/
     Route::controller(RoomListController::class)->group(function () {
        Route::get('/room/list/view/', 'RoomListView')->name('room.list.view'); 
        Route::get('/room/list/add/', 'RoomListAdd')->name('room.list.add'); 
        Route::post('/room/list/store/', 'RoomListStore')->name('room.list.store'); 
        
    });
     //** All Admin Room List Routes End **/

    //** All Admin SMTP SettingController Routes Start **/
    Route::controller(SettingController::class)->group(function () {
        Route::get('/smtp/setting/', 'SmtpSetting')->name('smtp.setting'); 
        Route::post('/smtp/update/', 'SmtpUpdate')->name('smtp.update'); 
        
        
    });
     //** All Admin SMTP SettingController Routes End **/

    //** All Admin TestimonialController Routes Start **/
    Route::controller(TestimonialController::class)->group(function () {
        Route::get('/testimonial/all/', 'TestimonialAll')->name('testimonial.all'); 
        Route::get('/testimonial/add/', 'TestimonialAdd')->name('testimonial.add'); 
        Route::post('/testimonial/store/', 'TestimonialStore')->name('testimonial.store'); 
        Route::get('/testimonial/edit/{id}', 'TestimonialEdit')->name('testimonial.edit'); 
        Route::post('/testimonial/update/', 'TestimonialUpdate')->name('testimonial.update'); 
        Route::get('/testimonial/delete/{id}', 'TestimonialDelete')->name('testimonial.delete'); 
        
    });
     //** All Admin TestimonialController Routes End **/

    //** All Admin BlogCategory Routes Start **/
    Route::controller(BlogController::class)->group(function () {
        Route::get('/blog/category/', 'BlogCategory')->name('blog.category'); 
        Route::post('/blog/category/store/', 'BlogCategoryStore')->name('blog.category.store'); 
        Route::get('/blog/category/edit/{id}', 'BlogCategoryEdit'); 
        Route::post('/blog/category/update/', 'BlogCategoryUpdate')->name('blog.category.update'); 
        Route::get('/blog/category/delete/{id}', 'BlogCategoryDelete')->name('blog.category.delete'); 

    });
     //** All Admin BlogCategory Routes End **/

    //** All Admin BlogPost Routes Start **/
    Route::controller(BlogController::class)->group(function () {
        Route::get('/blog/post/all/', 'BlogPostAll')->name('blog.post.all'); 
        Route::get('/blog/post/add/', 'BlogPostAdd')->name('blog.post.add'); 
        Route::post('/blog/post/store/', 'BlogPostStore')->name('blog.post.store'); 
        Route::get('/blog/post/edit/{id}', 'BlogPostEdit')->name('blog.post.edit'); 
        Route::post('/blog/post/update/', 'BlogPostUpdate')->name('blog.post.update'); 
        Route::get('/blog/post/delete/{id}', 'BlogPostDelete')->name('blog.post.delete'); 

    });
    //** All Admin BlogPost Routes End **/

    //** All Admin Comment Routes Start **/
    Route::controller(CommentController::class)->group(function () {
        Route::get('/comment/all/', 'CommentAll')->name('comment.all'); 
        Route::post('/update/comment/status/', 'UpdateCommentStatus')->name('update.comment.status'); 
        
    });
    //** All Admin Comment Routes End **/

    //** All Admin Booking Report Routes Start **/
    Route::controller(ReportController::class)->group(function () {
        Route::get('/booking/report/', 'BookingReport')->name('booking.report'); 
        Route::post('/booking/report/search', 'BookingReportSearch')->name('search-by-date'); 

        
    });
    //** All Admin Booking Report Routes End **/

     //** All Admin Site SettingController Routes Start **/
     Route::controller(SettingController::class)->group(function () {
        Route::get('/site/setting/', 'SiteSetting')->name('site.setting'); 
        Route::post('/site/update/', 'SiteUpdate')->name('site.update'); 
     
    });
     //** All Admin Site SettingController Routes End **/

     //** All Admin GalleryController Routes Start **/
     Route::controller(GalleryController::class)->group(function () {
        Route::get('/gallery/all/', 'GalleryAll')->name('gallery.all'); 
        Route::get('/gallery/add/', 'GalleryAdd')->name('gallery.add'); 
        Route::post('/gallery/store/', 'GalleryStore')->name('gallery.store'); 
        Route::get('/gallery/edit/{id}', 'GalleryEdit')->name('gallery.edit'); 
        Route::post('/gallery/update/', 'GalleryUpdate')->name('gallery.update'); 
        Route::get('/gallery/delete/{id}', 'GalleryDelete')->name('gallery.delete'); 

        Route::post('/gallery/multiple/delete/', 'GalleryMultipleDelete')->name('gallery.multiple.delete'); 

        /** Admin Contact Message Routes */
        Route::get('/contact/message/', 'AdminContactMessage')->name('contact.message'); 

    });
     //** All Admin GalleryController Routes End **/

      //** All Admin Permission RoleController Routes Start **/
      Route::controller(RoleController::class)->group(function () {
        Route::get('/permission/all/', 'PermissionAll')->name('permission.all'); 
        Route::get('/permission/add/', 'PermissionAdd')->name('permission.add'); 
        Route::post('/permission/store/', 'PermissionStore')->name('permission.store'); 
        Route::get('/permission/edit/{id}', 'PermissionEdit')->name('permission.edit'); 
        Route::post('/permission/update/', 'PermissionUpdate')->name('permission.update'); 
        Route::get('/permission/delete/{id}', 'PermissionDelete')->name('permission.delete'); 

        Route::get('/permission/import/', 'PermissionImport')->name('permission.import'); 
        Route::get('/export', 'Export')->name('export'); 
        Route::post('/import', 'Import')->name('import'); 
        
    });
     //** All Admin Permission RoleController Routes End **/

     //** All Admin Role RoleController Routes Start **/
     Route::controller(RoleController::class)->group(function () {
        Route::get('/role/all/', 'RoleAll')->name('role.all'); 
        Route::get('/role/add/', 'RoleAdd')->name('role.add'); 
        Route::post('/role/store/', 'RoleStore')->name('role.store'); 
        Route::get('/role/edit/{id}', 'RoleEdit')->name('role.edit'); 
        Route::post('/role/update/', 'RoleUpdate')->name('role.update'); 
        Route::get('/role/delete/{id}', 'RoleDelete')->name('role.delete');
        
        Route::get('/role/permission/add/', 'RolePermissionAdd')->name('role.permission.add'); 
        Route::post('/role/permission/store/', 'RolePermissionStore')->name('role.permission.store'); 
        Route::get('/role/permission/all/', 'RolePermissionAll')->name('role.permission.all'); 

        Route::get('/admin/role/edit/{id}', 'AdminRoleEdit')->name('admin.role.edit'); 
        Route::post('/admin/role/update/{id}', 'AdminRoleUpdate')->name('admin.role.update'); 
        Route::get('/admin/role/delete/{id}', 'AdminRoleDelete')->name('admin.role.delete'); 

    });
     //** All Admin Role RoleController Routes End **/

      //** All Admin Role AdminController Routes Start **/
      Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/all/', 'AdminAll')->name('admin.all'); 
        Route::get('/admin/add/', 'AdminAdd')->name('admin.add'); 
        Route::post('/admin/store/', 'AdminStore')->name('admin.store'); 
        Route::get('/admin/edit/{id}', 'AdminEdit')->name('admin.edit'); 
        Route::post('/admin/update/{id}', 'AdminUpdate')->name('admin.update'); 
        Route::get('/admin/delete/{id}', 'AdminDelete')->name('admin.delete'); 

    });
     //** All Admin Role AdminController Routes End **/



}); 
//** Admin Group Middleware End **/




 //** All Frontend Room Routes Start **/
 Route::controller(FrontendRoomController::class)->group(function () {
    Route::get('/frontend/room/all', 'FrontendRoomAll')->name('frontend.room.all'); 
    Route::get('/room/details/{id}', 'RoomDetailsPage'); 
    Route::get('/booking/search/results', 'BookingSearch')->name('booking.search'); 
    Route::get('/room/search/details/{id}', 'RoomSearchDetails')->name('room.search.details'); 

    Route::get('/check_room_availability/', 'CheckRoomAvailability')->name('check_room_availability');

});
//** All Frontend Room Routes End **/


 //** All Frontend Booking/Checkout Routes Start **/
Route::middleware(['auth'])->group(function () {

    Route::controller(BookingController::class)->group(function () {
        Route::get('/checkout/', 'Checkout')->name('checkout'); 
        Route::post('/booking/store/', 'BookingStore')->name('user_booking_store'); 
        Route::post('/checkout/store/', 'CheckoutStore')->name('checkout.store'); 
        Route::match(['get', 'post'],'/stripe_pay', [BookingController::class, 'stripe_pay'])->name('stripe_pay');

        //Booking update
        Route::post('/booking/status/update/{id}', 'BookingStatusUpdate')->name('booking.status.update'); 
        Route::post('/booking/details/update/{id}', 'BookingDetailsUpdate')->name('booking.details.update'); 

        //Assign Room Modal Route
        Route::get('/assign_room/{id}', 'AssignRoom')->name('assign_room'); 
        Route::get('/assign_room_store/{booking_id}/{room_number_id}', 'AssignRoomStore')->name('assign_room_store'); 
        Route::get('/assign_room_delete/{id}', 'AssignRoomDelete')->name('assign_room_delete'); 

        /** User Booking Routes */
        Route::get('/user/booking/', 'UserBooking')->name('user.booking'); 
        Route::get('/user/invoice/{id}', 'UserInvoice')->name('user.invoice'); 

    });

});
 //** All Frontend Booking Routes End **/


 //** All Frontend Blog Routes Start / No Auth **/
 Route::controller(BlogController::class)->group(function () {
    Route::get('/blog/details/{slug}', 'BlogDetails'); 
    Route::get('/blog/category/list/{id}', 'BlogCategoryList');    
    Route::get('/blog/list/', 'BlogList')->name('blog.list');    

});
//** All Frontend Blog Routes End **/


//** All Frontend Comment Routes Start / No Auth **/
Route::controller(CommentController::class)->group(function () {
    Route::post('/comment/store/', 'CommentStore')->name('comment.store'); 
      

});
//** All Frontend Comment Routes End **/

//** All Frontend Gallery Routes Start / No Auth **/
Route::controller(GalleryController::class)->group(function () {
    Route::get('/gallery/show/', 'GalleryShow')->name('gallery.show'); 

    //** Contact Us routes */
    Route::get('/contact/details/', 'ContactDetails')->name('contact.details'); 
    Route::post('/contact/store/', 'ContactStore')->name('contact.store'); 

});
//** All Frontend Gallery Routes End **/

//** All Admin Notification Routes Start / No Auth **/
Route::controller(BookingController::class)->group(function () {
    Route::post('/mark-notification-as-read/{notification}', 'MarkAsRead'); 
      
});
//** All Admin Notification Routes End **/


require __DIR__.'/auth.php';
