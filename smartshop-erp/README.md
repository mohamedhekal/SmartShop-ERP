# 🛒 SmartShop ERP System

## 📋 نظرة عامة على المشروع

**SmartShop ERP** هو نظام إدارة متكامل للمتاجر الإلكترونية مبني بأحدث التقنيات، يوفر حلول شاملة لإدارة المنتجات، الطلبات، الفواتير، الشحن، والتسويق بالعمولة.

## ✨ المميزات الرئيسية

### 🛍️ إدارة المتجر
- إدارة المنتجات والتصنيفات
- إدارة المخزون والطلبات
- نظام الفواتير والمدفوعات
- تتبع الشحن والتوصيل

### 👥 إدارة المستخدمين
- نظام أدوار وصلاحيات متقدم
- لوحة تحكم للمديرين
- نظام التسويق بالعمولة
- إدارة العملاء

### 📊 التقارير والإحصائيات
- لوحة تحكم تفاعلية
- تقارير المبيعات والأرباح
- إحصائيات المنتجات الأكثر مبيعاً
- تحليل سلوك العملاء

## 🏗️ البنية التقنية

### Backend (Laravel 10)
- **Framework**: Laravel 10
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Sanctum
- **API**: RESTful API
- **Testing**: PHPUnit

### Frontend (Vue.js 3)
- **Framework**: Vue.js 3 + Composition API
- **Build Tool**: Vite
- **Styling**: Tailwind CSS
- **State Management**: Pinia
- **Router**: Vue Router 4

## 🚀 التثبيت والتشغيل

### المتطلبات الأساسية
- PHP 8.1+
- Composer
- Node.js 18+
- MySQL 8.0+ أو PostgreSQL 13+
- Redis (اختياري)

### خطوات التثبيت

#### 1. استنساخ المشروع
```bash
git clone https://github.com/yourusername/smartshop-erp.git
cd smartshop-erp
```

#### 2. إعداد Backend (Laravel)
```bash
cd api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

#### 3. إعداد Frontend (Vue.js)
```bash
cd ../frontend
npm install
npm run dev
```

## 📁 هيكل المشروع

```
smartshop-erp/
├── api/                    # Laravel Backend
├── frontend/              # Vue.js Frontend
├── docs/                  # التوثيق
└── README.md              # هذا الملف
```

## 🔐 الأدوار والصلاحيات

| الدور | الوصف |
|-------|-------|
| Super Admin | صلاحيات كاملة على النظام |
| Store Manager | إدارة المتجر والمنتجات |
| Accountant | إدارة الفواتير والمدفوعات |
| Shipping Agent | إدارة الشحن والتوصيل |
| Affiliate | التسويق بالعمولة |
| Customer | تصفح وشراء المنتجات |

## 📚 التوثيق

- [دليل البنية البرمجية](docs/architecture.md)
- [توثيق API](docs/api-endpoints.md)
- [دليل الصلاحيات](docs/roles-permissions.md)
- [مخطط قاعدة البيانات](docs/db-schema.drawio)

## 🤝 المساهمة

نرحب بمساهماتكم! يرجى قراءة [دليل المساهمة](CONTRIBUTING.md) قبل البدء.

### خطوات المساهمة
1. Fork المشروع
2. إنشاء branch جديد (`git checkout -b feature/amazing-feature`)
3. Commit التغييرات (`git commit -m 'Add amazing feature'`)
4. Push إلى Branch (`git push origin feature/amazing-feature`)
5. فتح Pull Request

## 📄 الترخيص

هذا المشروع مرخص تحت رخصة MIT - انظر ملف [LICENSE](LICENSE) للتفاصيل.

## 📞 الدعم

- 📧 البريد الإلكتروني: support@smartshop-erp.com
- 💬 Discord: [انضم إلى مجتمعنا](https://discord.gg/smartshop-erp)
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/smartshop-erp/issues)

## 🙏 الشكر

شكر خاص لجميع المساهمين والمطورين الذين ساعدوا في تطوير هذا المشروع.

---

**Made with ❤️ by the SmartShop Team** 