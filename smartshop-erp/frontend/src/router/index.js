import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('@/pages/Home.vue'),
        meta: { title: 'الرئيسية' }
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('@/pages/auth/Login.vue'),
        meta: {
            title: 'تسجيل الدخول',
            requiresGuest: true
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('@/pages/auth/Register.vue'),
        meta: {
            title: 'إنشاء حساب',
            requiresGuest: true
        }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('@/pages/dashboard/Dashboard.vue'),
        meta: {
            title: 'لوحة التحكم',
            requiresAuth: true
        }
    },
    {
        path: '/products',
        name: 'Products',
        component: () => import('@/pages/products/ProductList.vue'),
        meta: { title: 'المنتجات' }
    },
    {
        path: '/products/:id',
        name: 'ProductDetail',
        component: () => import('@/pages/products/ProductDetail.vue'),
        meta: { title: 'تفاصيل المنتج' }
    },
    {
        path: '/cart',
        name: 'Cart',
        component: () => import('@/pages/cart/Cart.vue'),
        meta: {
            title: 'سلة التسوق',
            requiresAuth: true
        }
    },
    {
        path: '/checkout',
        name: 'Checkout',
        component: () => import('@/pages/checkout/Checkout.vue'),
        meta: {
            title: 'إتمام الطلب',
            requiresAuth: true
        }
    },
    {
        path: '/orders',
        name: 'Orders',
        component: () => import('@/pages/orders/OrderList.vue'),
        meta: {
            title: 'طلباتي',
            requiresAuth: true
        }
    },
    {
        path: '/orders/:id',
        name: 'OrderDetail',
        component: () => import('@/pages/orders/OrderDetail.vue'),
        meta: {
            title: 'تفاصيل الطلب',
            requiresAuth: true
        }
    },
    {
        path: '/profile',
        name: 'Profile',
        component: () => import('@/pages/profile/Profile.vue'),
        meta: {
            title: 'الملف الشخصي',
            requiresAuth: true
        }
    },
    {
        path: '/affiliate',
        name: 'Affiliate',
        component: () => import('@/pages/affiliate/AffiliateDashboard.vue'),
        meta: {
            title: 'التسويق بالعمولة',
            requiresAuth: true
        }
    },
    // Admin Routes
    {
        path: '/admin',
        name: 'AdminDashboard',
        component: () => import('@/pages/admin/Dashboard.vue'),
        meta: {
            title: 'إدارة النظام',
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/products',
        name: 'AdminProducts',
        component: () => import('@/pages/admin/products/ProductManagement.vue'),
        meta: {
            title: 'إدارة المنتجات',
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/orders',
        name: 'AdminOrders',
        component: () => import('@/pages/admin/orders/OrderManagement.vue'),
        meta: {
            title: 'إدارة الطلبات',
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/users',
        name: 'AdminUsers',
        component: () => import('@/pages/admin/users/UserManagement.vue'),
        meta: {
            title: 'إدارة المستخدمين',
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/affiliates',
        name: 'AdminAffiliates',
        component: () => import('@/pages/admin/affiliates/AffiliateManagement.vue'),
        meta: {
            title: 'إدارة المسوقين',
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    {
        path: '/admin/reports',
        name: 'AdminReports',
        component: () => import('@/pages/admin/reports/Reports.vue'),
        meta: {
            title: 'التقارير',
            requiresAuth: true,
            requiresAdmin: true
        }
    },
    // Error Pages
    {
        path: '/404',
        name: 'NotFound',
        component: () => import('@/pages/errors/NotFound.vue'),
        meta: { title: 'الصفحة غير موجودة' }
    },
    {
        path: '/403',
        name: 'Forbidden',
        component: () => import('@/pages/errors/Forbidden.vue'),
        meta: { title: 'غير مصرح' }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/404'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { top: 0 }
        }
    }
})

// Navigation Guards
router.beforeEach((to, from, next) => {
    // Update page title
    document.title = to.meta.title ? `${to.meta.title} - SmartShop ERP` : 'SmartShop ERP'

    // Check authentication
    const token = localStorage.getItem('token')
    const user = JSON.parse(localStorage.getItem('user') || 'null')

    if (to.meta.requiresAuth && !token) {
        next('/login')
    } else if (to.meta.requiresGuest && token) {
        next('/dashboard')
    } else if (to.meta.requiresAdmin && (!user || !user.roles?.some(role => ['Super Admin', 'Store Manager'].includes(role.name)))) {
        next('/403')
    } else {
        next()
    }
})

export default router 