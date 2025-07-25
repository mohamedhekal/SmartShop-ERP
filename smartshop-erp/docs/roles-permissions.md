# 🔐 الأدوار والصلاحيات - SmartShop ERP System

## نظرة عامة

نظام SmartShop ERP يستخدم نظام أدوار وصلاحيات متقدم مبني على Spatie Laravel Permission، مما يوفر مرونة عالية في إدارة الصلاحيات.

## الأدوار المتاحة

### 1. Super Admin 👑
**الوصف**: المدير العام للنظام مع صلاحيات كاملة

**الصلاحيات**:
- إدارة جميع المستخدمين
- إدارة جميع المنتجات
- إدارة جميع الطلبات
- إدارة المسوقين
- الوصول لجميع التقارير
- إعدادات النظام
- إدارة الأدوار والصلاحيات

### 2. Store Manager 🏪
**الوصف**: مدير المتجر المسؤول عن العمليات اليومية

**الصلاحيات**:
- إدارة المنتجات (إنشاء، تعديل، حذف)
- إدارة الطلبات (تحديث الحالة، التتبع)
- إدارة المخزون
- عرض التقارير الأساسية
- إدارة العملاء

### 3. Accountant 💰
**الوصف**: المحاسب المسؤول عن الشؤون المالية

**الصلاحيات**:
- عرض جميع الطلبات
- إدارة الفواتير
- إدارة المدفوعات
- التقارير المالية
- إدارة الميزانية

### 4. Shipping Agent 🚚
**الوصف**: مسؤول الشحن والتوصيل

**الصلاحيات**:
- عرض الطلبات المطلوب شحنها
- تحديث حالة الشحن
- إدارة التتبع
- طباعة ملصقات الشحن
- إدارة العناوين

### 5. Affiliate 🎯
**الوصف**: المسوق بالعمولة

**الصلاحيات**:
- عرض منتجاته المسوقة
- تتبع العمولات
- طلب سحب الأرباح
- عرض الإحصائيات الشخصية
- إدارة الرابط الخاص

### 6. Customer 👤
**الوصف**: العميل العادي

**الصلاحيات**:
- تصفح المنتجات
- إضافة للمفضلة
- إنشاء الطلبات
- تتبع طلباته
- إدارة الملف الشخصي
- كتابة التقييمات

## الصلاحيات التفصيلية

### إدارة المنتجات
```php
// الصلاحيات المتاحة
'products.view'      // عرض المنتجات
'products.create'    // إنشاء منتج جديد
'products.edit'      // تعديل المنتجات
'products.delete'    // حذف المنتجات
'products.manage'    // إدارة كاملة للمنتجات
```

### إدارة الطلبات
```php
// الصلاحيات المتاحة
'orders.view'        // عرض الطلبات
'orders.create'      // إنشاء طلب
'orders.edit'        // تعديل الطلبات
'orders.cancel'      // إلغاء الطلبات
'orders.manage'      // إدارة كاملة للطلبات
```

### إدارة المستخدمين
```php
// الصلاحيات المتاحة
'users.view'         // عرض المستخدمين
'users.create'       // إنشاء مستخدم جديد
'users.edit'         // تعديل المستخدمين
'users.delete'       // حذف المستخدمين
'users.manage'       // إدارة كاملة للمستخدمين
```

### إدارة المسوقين
```php
// الصلاحيات المتاحة
'affiliates.view'    // عرض المسوقين
'affiliates.create'  // إنشاء مسوق جديد
'affiliates.edit'    // تعديل المسوقين
'affiliates.delete'  // حذف المسوقين
'affiliates.manage'  // إدارة كاملة للمسوقين
```

### التقارير
```php
// الصلاحيات المتاحة
'reports.sales'      // تقارير المبيعات
'reports.products'   // تقارير المنتجات
'reports.users'      // تقارير المستخدمين
'reports.affiliates' // تقارير المسوقين
'reports.financial'  // التقارير المالية
```

## إعداد الأدوار والصلاحيات

### إنشاء الأدوار
```php
// في DatabaseSeeder
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// إنشاء الأدوار
$superAdmin = Role::create(['name' => 'Super Admin']);
$storeManager = Role::create(['name' => 'Store Manager']);
$accountant = Role::create(['name' => 'Accountant']);
$shippingAgent = Role::create(['name' => 'Shipping Agent']);
$affiliate = Role::create(['name' => 'Affiliate']);
$customer = Role::create(['name' => 'Customer']);

// إنشاء الصلاحيات
$permissions = [
    'products.view', 'products.create', 'products.edit', 'products.delete',
    'orders.view', 'orders.create', 'orders.edit', 'orders.cancel',
    'users.view', 'users.create', 'users.edit', 'users.delete',
    'affiliates.view', 'affiliates.create', 'affiliates.edit', 'affiliates.delete',
    'reports.sales', 'reports.products', 'reports.users', 'reports.affiliates'
];

foreach ($permissions as $permission) {
    Permission::create(['name' => $permission]);
}
```

### تعيين الصلاحيات للأدوار
```php
// Super Admin - جميع الصلاحيات
$superAdmin->givePermissionTo(Permission::all());

// Store Manager
$storeManager->givePermissionTo([
    'products.view', 'products.create', 'products.edit', 'products.delete',
    'orders.view', 'orders.edit',
    'users.view',
    'reports.sales', 'reports.products'
]);

// Accountant
$accountant->givePermissionTo([
    'orders.view',
    'reports.sales', 'reports.financial'
]);

// Shipping Agent
$shippingAgent->givePermissionTo([
    'orders.view', 'orders.edit'
]);

// Affiliate
$affiliate->givePermissionTo([
    'products.view'
]);

// Customer
$customer->givePermissionTo([
    'products.view'
]);
```

## التحقق من الصلاحيات

### في Controllers
```php
public function store(Request $request)
{
    $this->authorize('products.create');
    
    // Logic here
}
```

### في Blade Templates
```php
@can('products.create')
    <button>إنشاء منتج جديد</button>
@endcan

@role('Super Admin')
    <div>محتوى للمدير العام فقط</div>
@endrole
```

### في Vue.js Components
```javascript
// في Vue component
computed: {
  canCreateProduct() {
    return this.user?.permissions?.includes('products.create')
  },
  
  isAdmin() {
    return this.user?.roles?.some(role => 
      ['Super Admin', 'Store Manager'].includes(role.name)
    )
  }
}
```

## Middleware

### حماية Routes
```php
// في routes/api.php
Route::middleware(['auth:sanctum', 'role:Super Admin'])->group(function () {
    // Routes for Super Admin only
});

Route::middleware(['auth:sanctum', 'permission:products.create'])->group(function () {
    // Routes for users with products.create permission
});
```

### Custom Middleware
```php
// إنشاء middleware مخصص
php artisan make:middleware CheckAffiliatePermission

// في Middleware
public function handle($request, Closure $next)
{
    if (!auth()->user()->hasRole('Affiliate')) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }
    
    return $next($request);
}
```

## إدارة الأدوار ديناميكياً

### إنشاء دور جديد
```php
$newRole = Role::create(['name' => 'New Role']);
$newRole->givePermissionTo(['products.view', 'orders.view']);
```

### تعيين دور للمستخدم
```php
$user = User::find(1);
$user->assignRole('Store Manager');
```

### إزالة دور من المستخدم
```php
$user->removeRole('Customer');
```

### التحقق من الأدوار
```php
if ($user->hasRole('Super Admin')) {
    // Super Admin logic
}

if ($user->hasAnyRole(['Super Admin', 'Store Manager'])) {
    // Admin logic
}
```

## أفضل الممارسات

### 1. مبدأ أقل الصلاحيات
- امنح المستخدمين أقل الصلاحيات المطلوبة لأداء مهامهم
- راجع الصلاحيات بانتظام

### 2. تجميع الصلاحيات
- استخدم أدوار بدلاً من صلاحيات فردية عندما يكون ذلك ممكناً
- أنشئ أدوار مخصصة للمشاريع أو الفرق

### 3. التوثيق
- وثق جميع الأدوار والصلاحيات
- حدد مسؤوليات كل دور بوضوح

### 4. الاختبار
- اختبر الصلاحيات بانتظام
- تأكد من أن المستخدمين لا يمكنهم الوصول لصلاحيات غير مصرح بها

### 5. المراجعة الدورية
- راجع الأدوار والصلاحيات شهرياً
- احذف الأدوار والصلاحيات غير المستخدمة

## أمثلة عملية

### مثال: إدارة المنتجات
```php
// في ProductController
public function store(Request $request)
{
    $this->authorize('products.create');
    
    // Validation
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        // ... other validation rules
    ]);
    
    // Create product
    $product = Product::create($validated);
    
    return response()->json([
        'success' => true,
        'message' => 'تم إنشاء المنتج بنجاح',
        'data' => $product
    ]);
}
```

### مثال: التحقق في Vue.js
```javascript
// في Vue component
methods: {
  async createProduct(productData) {
    if (!this.canCreateProduct) {
      this.$toast.error('ليس لديك صلاحية لإنشاء منتجات')
      return
    }
    
    try {
      const response = await this.$api.post('/products', productData)
      this.$toast.success('تم إنشاء المنتج بنجاح')
    } catch (error) {
      this.$toast.error('حدث خطأ في إنشاء المنتج')
    }
  }
}
```

---

**ملاحظة**: هذا النظام يوفر مرونة عالية ويمكن تخصيصه حسب احتياجات المشروع. 