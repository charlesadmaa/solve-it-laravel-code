<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Storage;
use App\Models\NotificationMessage;

class Helpers
{
    public static function upload(string $dir, string $format, $image = null)
    {
        $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
        if (!Storage::disk('public')->exists($dir)) {
            Storage::disk('public')->makeDirectory($dir);
        }
        Storage::disk('public')->putFileAs($dir, $image, $imageName);

        return $imageName;
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        if ($image == null) {
            return $old_image;
        }
        if (Storage::disk('public')->exists($dir . $old_image)) {
            Storage::disk('public')->delete($dir . $old_image);
        }
        $imageName = Helpers::upload($dir, $format, $image);
        return $imageName;
    }

    //used in seeders
    public static function generateNonRepeatingRandom($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    public static function addNotification($notificationData) {
        $notification = new NotificationMessage();
        $notification->title = $notificationData['title'];
        $notification->created_by_id = $notificationData['created_by_id'];
        $notification->message = $notificationData['message'];
        $notification->referenced_objects = $notificationData['referenced_objects'];
        $notification->type = $notificationData['type'];
        $notification->referenced_user_id = $notificationData['referenced_user_id'];
        $notification->featured_image = $notificationData['featured_image'];
        $notification->save();
    }


    public function user()
    {
        return Auth::guard('web')->user();
    }

}
