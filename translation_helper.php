<?php

/**
 * Translation Helper Script
 * This script helps identify remaining hardcoded messages that need translation
 */

echo "=== TRANSLATION PROGRESS REPORT ===\n\n";

echo "✅ COMPLETED TRANSLATIONS:\n";
echo "- Frontend JSON files (lang/en.json, lang/ar.json) - Comprehensive\n";
echo "- Basic auth messages (lang/*/auth.php)\n";
echo "- Flash messages (lang/*/flash.php) - Extended with API messages\n";
echo "- Cart Services - Updated to use translation keys\n";
echo "- Discount Services - Updated to use translation keys\n";
echo "- Checkout Controller - Updated to use translation keys\n";
echo "- Cart Controller - Updated to use translation keys\n";
echo "- Newsletter Controller - Updated to use translation keys\n";
echo "- Review Controller - Updated to use translation keys\n";
echo "- Return Products Controller - Updated to use translation keys\n";
echo "- Main Page Controller - Updated to use translation keys\n\n";

echo "❌ REMAINING WORK:\n";
echo "The following files still contain hardcoded messages that need translation:\n\n";

$remainingFiles = [
    'app/Http/Controllers/Api/AllProductsController.php' => [
        'Products Retrieved Successfully',
        'No Products Available'
    ],
    'app/Http/Controllers/Api/CitiesController.php' => [
        'cities Retrieved Successfully',
        'No cities To Retrieved'
    ],
    'app/Http/Controllers/Api/CheckDiscountController.php' => [
        'لقد انتهت صلاحية رمز الخصم هذا أو لم يعد صالحًا.'
    ],
    'app/Http/Controllers/Api/UserAuthController.php' => [
        'انتهت صلاحية رمز التحقق. يرجى طلب واحد جديدة.'
    ],
    'app/Http/Controllers/Api/UserOrdersController.php' => [
        'لا يوجد طلبات لعرضها',
        'الطلب غير موجود',
        'تم الحذف بنجاح',
        'لا يوجد مرتجعات',
        'تم ارجاع الطلب بنجاح'
    ],
    'app/Http/Controllers/Api/guest/GuestOrdersController.php' => [
        'الطلب غير موجود',
        'تم الحذف بنجاح',
        'تم ارجاع الطلب بنجاح'
    ],
    'app/Http/Controllers/Api/guest/GuestCartController.php' => [
        'لا توجد منتجات في السلة',
        'تم الحذف بنجاح',
        'تم التعديل بنجاح'
    ],
    'app/Http/Controllers/Api/guest/CheckoutController.php' => [
        'لا يمكن تحديد اكثر من نوع شحن معا',
        'هذه الخدمة غير مفعلة',
        'لا يمكن اتمام الطلب والسلة فارغة'
    ],
    'app/Http/Controllers/Api/Profile/UserAddressesController.php' => [
        'لا يمكن حذف عنوان رئيسي'
    ],
    'app/Services/SMSGateways/TelephoneVerification.php' => [
        'Failed to send verification SMS. Please try again.'
    ],
    'app/Http/Middleware/CheckUserVerification.php' => [
        'Your account is not verified. A new verification code has been sent to your phone number.',
        'Failed to send verification SMS. Please try again later.'
    ]
];

foreach ($remainingFiles as $file => $messages) {
    echo "📁 $file:\n";
    foreach ($messages as $message) {
        echo "   - \"$message\"\n";
    }
    echo "\n";
}

echo "🔧 NEXT STEPS:\n";
echo "1. Add the remaining messages to lang/en/flash.php and lang/ar/flash.php\n";
echo "2. Replace hardcoded strings with __('flash.key_name') in the listed files\n";
echo "3. Test the application in both languages\n";
echo "4. Consider creating separate translation files for different modules (e.g., api.php, orders.php)\n\n";

echo "💡 TRANSLATION PATTERN:\n";
echo "Replace: 'Hardcoded message'\n";
echo "With: __('flash.message_key')\n\n";

echo "Example:\n";
echo "Before: return ApiResponse::sendResponse(200, 'Products Retrieved Successfully', \$data);\n";
echo "After:  return ApiResponse::sendResponse(200, __('flash.products_retrieved_success'), \$data);\n\n";

echo "=== END REPORT ===\n";