# 🤝 دليل المساهمة - SmartShop ERP System

شكراً لاهتمامك بالمساهمة في SmartShop ERP! هذا الدليل سيساعدك على البدء.

## 🚀 كيفية المساهمة

### 1. Fork المشروع
1. اذهب إلى [SmartShop ERP Repository](https://github.com/yourusername/smartshop-erp)
2. اضغط على زر "Fork" في أعلى الصفحة
3. سيتم إنشاء نسخة من المشروع في حسابك

### 2. Clone المشروع
```bash
git clone https://github.com/YOUR_USERNAME/smartshop-erp.git
cd smartshop-erp
```

### 3. إعداد البيئة المحلية
```bash
# Backend Setup
cd api
composer install
cp env.example .env
php artisan key:generate
php artisan migrate --seed

# Frontend Setup
cd ../frontend
npm install
```

### 4. إنشاء Branch جديد
```bash
git checkout -b feature/your-feature-name
# أو
git checkout -b fix/your-bug-fix
```

### 5. تطوير الميزة
- اكتب الكود الخاص بك
- تأكد من اتباع معايير الكود
- أضف اختبارات إذا لزم الأمر
- حدث التوثيق إذا لزم الأمر

### 6. Commit التغييرات
```bash
git add .
git commit -m "feat: add new feature description"
```

### 7. Push إلى Repository
```bash
git push origin feature/your-feature-name
```

### 8. إنشاء Pull Request
1. اذهب إلى repository الأصلي
2. اضغط على "Compare & pull request"
3. املأ النموذج بالتفاصيل المطلوبة
4. اضغط على "Create pull request"

## 📋 معايير الكود

### PHP (Laravel)
- اتبع PSR-12 standards
- استخدم meaningful names للـ variables و functions
- أضف comments للـ complex logic
- اكتب unit tests للـ new features

### JavaScript/Vue.js
- استخدم ESLint و Prettier
- اتبع Vue.js Style Guide
- استخدم Composition API للـ Vue 3
- اكتب meaningful component names

### Git Commit Messages
استخدم Conventional Commits:
```
feat: add new feature
fix: fix bug
docs: update documentation
style: format code
refactor: refactor code
test: add tests
chore: maintenance tasks
```

## 🧪 الاختبارات

### Backend Tests
```bash
cd api
php artisan test
```

### Frontend Tests
```bash
cd frontend
npm run test
```

## 📝 التوثيق

### تحديث التوثيق
- حدث README.md إذا أضفت ميزات جديدة
- أضف تعليقات للـ API endpoints
- حدث screenshots إذا تغيرت الواجهات

### إضافة Screenshots
```bash
# أضف screenshots في
docs/screenshots/
```

## 🐛 الإبلاغ عن الأخطاء

### إنشاء Issue
1. اذهب إلى Issues tab
2. اضغط على "New Issue"
3. اختر نوع المشكلة:
   - 🐛 Bug Report
   - 💡 Feature Request
   - 📚 Documentation
   - ❓ Question

### Bug Report Template
```markdown
## وصف المشكلة
وصف واضح ومختصر للمشكلة

## خطوات إعادة الإنتاج
1. اذهب إلى '...'
2. اضغط على '...'
3. انزل إلى '...'
4. شاهد الخطأ

## السلوك المتوقع
وصف لما كنت تتوقعه أن يحدث

## Screenshots
إذا كان ذلك مناسباً، أضف screenshots

## معلومات إضافية
- OS: [e.g. macOS, Windows]
- Browser: [e.g. Chrome, Safari]
- Version: [e.g. 22]
```

## 💡 اقتراح ميزات جديدة

### Feature Request Template
```markdown
## وصف الميزة
وصف واضح ومختصر للميزة المطلوبة

## المشكلة التي تحلها
وصف للمشكلة التي تحلها هذه الميزة

## الحل المقترح
وصف للحل المقترح

## البدائل المدروسة
وصف لأي حلول بديلة تم النظر فيها

## معلومات إضافية
أي سياق أو screenshots إضافية
```

## 🔧 إعداد البيئة المحلية

### المتطلبات
- PHP 8.1+
- Composer
- Node.js 18+
- MySQL 8.0+ أو PostgreSQL 13+
- Git

### خطوات الإعداد
```bash
# 1. Clone المشروع
git clone https://github.com/YOUR_USERNAME/smartshop-erp.git
cd smartshop-erp

# 2. إعداد Backend
cd api
composer install
cp env.example .env
# عدّل .env file
php artisan key:generate
php artisan migrate --seed
php artisan serve

# 3. إعداد Frontend
cd ../frontend
npm install
npm run dev
```

## 📞 التواصل

### قنوات التواصل
- **GitHub Issues**: للإبلاغ عن الأخطاء واقتراح الميزات
- **GitHub Discussions**: للمناقشات العامة
- **Email**: support@smartshop-erp.com

### Code of Conduct
نلتزم ببيئة ودية ومحترمة للجميع. يرجى قراءة [Code of Conduct](CODE_OF_CONDUCT.md).

## 🏆 الاعتراف

سيتم إضافة جميع المساهمين إلى [CONTRIBUTORS.md](CONTRIBUTORS.md) file.

## 📄 الترخيص

بالمساهمة في هذا المشروع، فإنك توافق على أن مساهماتك ستكون مرخصة تحت نفس رخصة المشروع (MIT).

---

**شكراً لك على المساهمة في SmartShop ERP! 🎉** 
