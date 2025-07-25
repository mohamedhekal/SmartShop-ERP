# 🚀 SmartShop ERP - Laravel API

## نظرة عامة

هذا هو الجزء الخلفي (Backend) من نظام SmartShop ERP، مبني باستخدام Laravel 10 مع أحدث التقنيات والممارسات.

## المميزات

- ✅ **RESTful API** مع Laravel
- ✅ **Authentication** مع Laravel Sanctum
- ✅ **Authorization** مع Spatie Laravel Permission
- ✅ **File Upload** مع Laravel Storage
- ✅ **Email Notifications** مع Laravel Mail
- ✅ **Database Migrations** و Seeders
- ✅ **API Documentation** مع Swagger
- ✅ **Testing** مع PHPUnit
- ✅ **Validation** و Error Handling
- ✅ **Rate Limiting** و Security

## المتطلبات

- PHP 8.1+
- Composer
- MySQL 8.0+ أو PostgreSQL 13+
- Redis (اختياري للـ caching)
- Node.js (لـ asset compilation)

## التثبيت

### 1. Clone المشروع
```bash
git clone https://github.com/yourusername/smartshop-erp.git
cd smartshop-erp/api
```

### 2. تثبيت Dependencies
```bash
composer install
```

### 3. إعداد البيئة
```bash
cp env.example .env
```

عدّل ملف `.env` مع إعدادات قاعدة البيانات:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartshop_erp
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. تشغيل Migrations
```bash
php artisan migrate
```

### 6. تشغيل Seeders
```bash
php artisan db:seed
```

### 7. إنشاء Storage Link
```bash
php artisan storage:link
```

### 8. تشغيل الخادم
```bash
php artisan serve
```

الـ API سيكون متاح على: `http://localhost:8000`

## هيكل المشروع

```
api/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # API Controllers
│   │   ├── Middleware/      # Custom Middleware
│   │   └── Requests/        # Form Requests
│   ├── Models/              # Eloquent Models
│   ├── Services/            # Business Logic
│   ├── Repositories/        # Data Access Layer
│   └── Providers/           # Service Providers
├── routes/
│   └── api.php             # API Routes
├── database/
│   ├── migrations/         # Database Migrations
│   └── seeders/           # Database Seeders
├── config/                # Configuration Files
└── tests/                 # Tests
```

## API Endpoints

### Authentication
- `POST /api/auth/register` - تسجيل مستخدم جديد
- `POST /api/auth/login` - تسجيل الدخول
- `POST /api/auth/logout` - تسجيل الخروج
- `GET /api/auth/me` - معلومات المستخدم الحالي

### Products
- `GET /api/products` - قائمة المنتجات
- `GET /api/products/{id}` - تفاصيل منتج
- `POST /api/products` - إنشاء منتج جديد (Admin)
- `PUT /api/products/{id}` - تحديث منتج (Admin)
- `DELETE /api/products/{id}` - حذف منتج (Admin)

### Orders
- `GET /api/orders` - قائمة الطلبات
- `POST /api/orders` - إنشاء طلب جديد
- `GET /api/orders/{id}` - تفاصيل طلب
- `PUT /api/orders/{id}/status` - تحديث حالة الطلب

### Affiliates
- `GET /api/affiliate/profile` - ملف المسوق
- `POST /api/affiliate/register` - تسجيل مسوق جديد
- `GET /api/affiliate/commissions` - العمولات
- `POST /api/affiliate/payouts` - طلب سحب الأرباح

## الأدوار والصلاحيات

### الأدوار المتاحة
- **Super Admin** - صلاحيات كاملة
- **Store Manager** - إدارة المتجر
- **Accountant** - إدارة المالية
- **Shipping Agent** - إدارة الشحن
- **Affiliate** - التسويق بالعمولة
- **Customer** - العميل العادي

### الصلاحيات
- `products.create` - إنشاء منتجات
- `products.update` - تحديث منتجات
- `products.delete` - حذف منتجات
- `orders.manage` - إدارة الطلبات
- `users.manage` - إدارة المستخدمين
- `affiliates.manage` - إدارة المسوقين

## Testing

### تشغيل الاختبارات
```bash
php artisan test
```

### تشغيل اختبارات محددة
```bash
php artisan test --filter=ProductTest
```

### Coverage Report
```bash
php artisan test --coverage
```

## Database

### Migrations
```bash
# إنشاء migration جديد
php artisan make:migration create_products_table

# تشغيل migrations
php artisan migrate

# Rollback
php artisan migrate:rollback

# Refresh
php artisan migrate:refresh
```

### Seeders
```bash
# تشغيل جميع seeders
php artisan db:seed

# تشغيل seeder محدد
php artisan db:seed --class=UserSeeder
```

## File Upload

### إعداد Storage
```bash
# إنشاء storage link
php artisan storage:link

# تنظيف storage
php artisan storage:clear
```

### رفع الملفات
```php
// في Controller
if ($request->hasFile('image')) {
    $path = $request->file('image')->store('products', 'public');
    $product->image = $path;
}
```

## Caching

### Redis Cache
```bash
# تثبيت Redis
sudo apt-get install redis-server

# تشغيل Redis
redis-server
```

### Cache Commands
```bash
# Clear cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear
```

## Queue Jobs

### إعداد Queue
```bash
# تشغيل queue worker
php artisan queue:work

# تشغيل queue في الخلفية
php artisan queue:work --daemon
```

### إنشاء Job
```bash
php artisan make:job SendOrderConfirmation
```

## API Documentation

### Swagger/OpenAPI
```bash
# تثبيت L5-Swagger
composer require darkaonline/l5-swagger

# Publish config
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

# Generate documentation
php artisan l5-swagger:generate
```

## Security

### Rate Limiting
```php
// في routes/api.php
Route::middleware('throttle:60,1')->group(function () {
    // Routes here
});
```

### CORS
```php
// في config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

## Monitoring

### Logging
```php
// في .env
LOG_CHANNEL=stack
LOG_LEVEL=debug
```

### Error Tracking
```bash
# تثبيت Sentry
composer require sentry/sentry-laravel
```

## Deployment

### Production Checklist
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure database
- [ ] Set up SSL certificate
- [ ] Configure web server (Nginx/Apache)
- [ ] Set up monitoring
- [ ] Configure backups

### Environment Variables
```env
APP_NAME="SmartShop ERP"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

## Troubleshooting

### Common Issues

#### 1. Permission Denied
```bash
chmod -R 775 storage bootstrap/cache
```

#### 2. Composer Memory Limit
```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

#### 3. Database Connection
```bash
php artisan config:clear
php artisan cache:clear
```

## Contributing

يرجى قراءة [CONTRIBUTING.md](../CONTRIBUTING.md) للمساهمة في المشروع.

## License

هذا المشروع مرخص تحت رخصة MIT - انظر ملف [LICENSE](../LICENSE) للتفاصيل.

---

**Made with ❤️ by the SmartShop Team** 