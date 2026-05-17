<?php

use Illuminate\Contracts\Console\Kernel;
use App\Models\Notification;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "=========================================\n";
echo "         NOTIFICATIONS IN MONGODB        \n";
echo "=========================================\n";

$notifications = Notification::all();
echo "Total notifications: " . $notifications->count() . "\n\n";

foreach ($notifications as $index => $n) {
    echo "Notification #{$index}:\n";
    echo "  - _id (MongoDB): " . (string)$n->_id . "\n";
    echo "  - id (Attribute): " . var_export($n->id, true) . "\n";
    echo "  - type: " . $n->type . "\n";
    echo "  - notifiable_id: " . $n->notifiable_id . "\n";
    echo "  - raw attributes: " . json_encode($n->getAttributes()) . "\n";
    echo "-----------------------------------------\n";
}

echo "=========================================\n";
