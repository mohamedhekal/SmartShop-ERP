# 🎨 SmartShop ERP - Vue.js Frontend

## نظرة عامة

هذا هو الجزء الأمامي (Frontend) من نظام SmartShop ERP، مبني باستخدام Vue.js 3 مع أحدث التقنيات والممارسات.

## المميزات

- ✅ **Vue.js 3** مع Composition API
- ✅ **Vite** للبناء السريع
- ✅ **Tailwind CSS** للتصميم
- ✅ **Vue Router 4** للتنقل
- ✅ **Pinia** لإدارة الحالة
- ✅ **Axios** للـ API calls
- ✅ **Vue3-Toastify** للإشعارات
- ✅ **Chart.js** للرسوم البيانية
- ✅ **Responsive Design** للجميع الأجهزة
- ✅ **RTL Support** للغة العربية
- ✅ **Dark Mode** (قيد التطوير)

## المتطلبات

- Node.js 18+
- npm أو yarn
- Git

## التثبيت

### 1. Clone المشروع
```bash
git clone https://github.com/yourusername/smartshop-erp.git
cd smartshop-erp/frontend
```

### 2. تثبيت Dependencies
```bash
npm install
# أو
yarn install
```

### 3. إعداد البيئة
```bash
cp .env.example .env
```

عدّل ملف `.env`:
```env
VITE_API_URL=http://localhost:8000/api
VITE_APP_NAME="SmartShop ERP"
```

### 4. تشغيل الخادم المحلي
```bash
npm run dev
# أو
yarn dev
```

التطبيق سيكون متاح على: `http://localhost:3000`

## هيكل المشروع

```
frontend/
├── src/
│   ├── assets/             # الصور والملفات الثابتة
│   ├── components/         # المكونات القابلة لإعادة الاستخدام
│   │   ├── ui/            # مكونات واجهة المستخدم الأساسية
│   │   ├── forms/         # مكونات النماذج
│   │   └── layout/        # مكونات التخطيط
│   ├── pages/             # صفحات التطبيق
│   │   ├── auth/          # صفحات المصادقة
│   │   ├── dashboard/     # صفحات لوحة التحكم
│   │   ├── products/      # صفحات المنتجات
│   │   └── admin/         # صفحات الإدارة
│   ├── router/            # إعدادات التوجيه
│   ├── store/             # إدارة الحالة مع Pinia
│   │   ├── auth.js        # حالة المصادقة
│   │   ├── products.js    # حالة المنتجات
│   │   └── orders.js      # حالة الطلبات
│   ├── services/          # خدمات API
│   │   ├── api.js         # إعداد Axios
│   │   ├── auth.js        # خدمات المصادقة
│   │   └── products.js    # خدمات المنتجات
│   ├── utils/             # الدوال المساعدة
│   │   ├── validation.js  # قواعد التحقق
│   │   ├── formatters.js  # تنسيق البيانات
│   │   └── constants.js   # الثوابت
│   ├── App.vue            # المكون الرئيسي
│   └── main.js            # نقطة البداية
├── public/                # الملفات العامة
├── dist/                  # مجلد البناء
└── package.json           # إعدادات المشروع
```

## المكونات الرئيسية

### 1. Layout Components
- `AppHeader.vue` - رأس التطبيق
- `AppSidebar.vue` - الشريط الجانبي
- `AppFooter.vue` - تذييل الصفحة
- `AppModal.vue` - النوافذ المنبثقة

### 2. UI Components
- `BaseButton.vue` - الأزرار
- `BaseInput.vue` - حقول الإدخال
- `BaseCard.vue` - البطاقات
- `BaseTable.vue` - الجداول
- `BaseBadge.vue` - الشارات

### 3. Form Components
- `LoginForm.vue` - نموذج تسجيل الدخول
- `RegisterForm.vue` - نموذج التسجيل
- `ProductForm.vue` - نموذج المنتج
- `OrderForm.vue` - نموذج الطلب

## إدارة الحالة (State Management)

### Pinia Stores

#### Auth Store
```javascript
// store/auth.js
export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
    isAuthenticated: false
  }),
  
  actions: {
    async login(credentials) {
      // Login logic
    },
    
    async logout() {
      // Logout logic
    }
  }
})
```

#### Products Store
```javascript
// store/products.js
export const useProductsStore = defineStore('products', {
  state: () => ({
    products: [],
    loading: false,
    pagination: {}
  }),
  
  actions: {
    async fetchProducts(params) {
      // Fetch products logic
    }
  }
})
```

## الخدمات (Services)

### API Service
```javascript
// services/api.js
import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  timeout: 10000
})

// Request interceptor
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

// Response interceptor
api.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401) {
      // Handle unauthorized
    }
    return Promise.reject(error)
  }
)

export default api
```

## التوجيه (Routing)

### Router Configuration
```javascript
// router/index.js
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('@/pages/Home.vue')
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/pages/auth/Login.vue'),
    meta: { requiresGuest: true }
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('@/pages/dashboard/Dashboard.vue'),
    meta: { requiresAuth: true }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
```

## التصميم (Styling)

### Tailwind CSS
```css
/* Custom styles in style.css */
@layer components {
  .btn-primary {
    @apply bg-primary-600 text-white hover:bg-primary-700;
  }
  
  .card {
    @apply bg-white rounded-lg shadow-md;
  }
}
```

### RTL Support
```html
<!-- في index.html -->
<html lang="ar" dir="rtl">
```

## الرسوم البيانية (Charts)

### Chart.js Integration
```javascript
// components/charts/SalesChart.vue
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: {
    chartData: {
      type: Object,
      required: true
    }
  },
  mounted() {
    this.renderChart(this.chartData, this.options)
  }
}
```

## الإشعارات (Notifications)

### Vue3-Toastify
```javascript
import { toast } from 'vue3-toastify'

// Success notification
toast.success('تم حفظ البيانات بنجاح')

// Error notification
toast.error('حدث خطأ في العملية')

// Warning notification
toast.warning('يرجى التحقق من البيانات')
```

## التحقق من البيانات (Validation)

### VeeValidate
```javascript
import { useForm } from 'vee-validate'
import * as yup from 'yup'

const schema = yup.object({
  email: yup.string().email().required(),
  password: yup.string().min(8).required()
})

const { handleSubmit, errors } = useForm({
  validationSchema: schema
})
```

## الاختبارات (Testing)

### تشغيل الاختبارات
```bash
npm run test
```

### تشغيل الاختبارات مع Coverage
```bash
npm run test:coverage
```

## البناء (Building)

### Development Build
```bash
npm run dev
```

### Production Build
```bash
npm run build
```

### Preview Production Build
```bash
npm run preview
```

## التحسين (Optimization)

### Code Splitting
```javascript
// Lazy loading للصفحات
const Dashboard = () => import('@/pages/Dashboard.vue')
```

### Image Optimization
```javascript
// استخدام Vite's asset handling
import productImage from '@/assets/images/product.jpg'
```

### Bundle Analysis
```bash
npm run build -- --analyze
```

## التطوير (Development)

### Hot Reload
التطبيق يدعم Hot Reload تلقائياً عند تغيير الملفات.

### ESLint
```bash
# تشغيل ESLint
npm run lint

# إصلاح الأخطاء تلقائياً
npm run lint:fix
```

### Prettier
```bash
# تنسيق الكود
npm run format
```

## النشر (Deployment)

### Static Hosting
```bash
# بناء المشروع
npm run build

# رفع مجلد dist إلى الخادم
```

### Docker
```dockerfile
FROM node:18-alpine
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build
EXPOSE 3000
CMD ["npm", "run", "preview"]
```

## Troubleshooting

### Common Issues

#### 1. Node Modules Issues
```bash
rm -rf node_modules package-lock.json
npm install
```

#### 2. Vite Build Issues
```bash
npm run build -- --force
```

#### 3. Port Already in Use
```bash
# تغيير المنفذ
npm run dev -- --port 3001
```

## Contributing

يرجى قراءة [CONTRIBUTING.md](../CONTRIBUTING.md) للمساهمة في المشروع.

## License

هذا المشروع مرخص تحت رخصة MIT - انظر ملف [LICENSE](../LICENSE) للتفاصيل.

---

**Made with ❤️ by the SmartShop Team** 