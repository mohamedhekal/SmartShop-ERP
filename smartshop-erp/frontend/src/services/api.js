import axios from 'axios'
import { toast } from 'vue3-toastify'

// Create axios instance
const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})

// Request interceptor
api.interceptors.request.use(
    (config) => {
        // Add token to headers if exists
        const token = localStorage.getItem('token')
        if (token) {
            config.headers.Authorization = `Bearer ${token}`
        }

        // Add loading indicator
        if (config.showLoading !== false) {
            // You can add a global loading state here
        }

        return config
    },
    (error) => {
        return Promise.reject(error)
    }
)

// Response interceptor
api.interceptors.response.use(
    (response) => {
        return response
    },
    (error) => {
        const { response } = error

        // Handle different error status codes
        switch (response?.status) {
            case 401:
                // Unauthorized - clear token and redirect to login
                localStorage.removeItem('token')
                localStorage.removeItem('user')
                window.location.href = '/login'
                toast.error('انتهت صلاحية الجلسة، يرجى تسجيل الدخول مرة أخرى')
                break

            case 403:
                // Forbidden
                toast.error('ليس لديك صلاحية للوصول لهذا المورد')
                break

            case 404:
                // Not found
                toast.error('المورد المطلوب غير موجود')
                break

            case 422:
                // Validation errors
                const errors = response.data.errors
                if (errors) {
                    Object.values(errors).forEach(errorArray => {
                        errorArray.forEach(error => {
                            toast.error(error)
                        })
                    })
                } else {
                    toast.error(response.data.message || 'بيانات غير صحيحة')
                }
                break

            case 429:
                // Too many requests
                toast.error('تم تجاوز الحد المسموح من الطلبات، يرجى المحاولة لاحقاً')
                break

            case 500:
                // Server error
                toast.error('حدث خطأ في الخادم، يرجى المحاولة لاحقاً')
                break

            default:
                // Other errors
                const message = response?.data?.message || 'حدث خطأ غير متوقع'
                toast.error(message)
        }

        return Promise.reject(error)
    }
)

// API methods
export const authAPI = {
    login: (credentials) => api.post('/auth/login', credentials),
    register: (userData) => api.post('/auth/register', userData),
    logout: () => api.post('/auth/logout'),
    me: () => api.get('/auth/me'),
    refresh: () => api.post('/auth/refresh')
}

export const userAPI = {
    profile: () => api.get('/user/profile'),
    updateProfile: (data) => api.put('/user/profile', data),
    changePassword: (data) => api.post('/user/change-password', data)
}

export const productAPI = {
    getAll: (params) => api.get('/products', { params }),
    getById: (id) => api.get(`/products/${id}`),
    create: (data) => api.post('/products', data),
    update: (id, data) => api.put(`/products/${id}`, data),
    delete: (id) => api.delete(`/products/${id}`),
    featured: () => api.get('/products/featured'),
    related: (id) => api.get(`/products/${id}/related`)
}

export const categoryAPI = {
    getAll: () => api.get('/categories'),
    getById: (id) => api.get(`/categories/${id}`),
    getProducts: (id) => api.get(`/categories/${id}/products`)
}

export const orderAPI = {
    getAll: (params) => api.get('/orders', { params }),
    getById: (id) => api.get(`/orders/${id}`),
    create: (data) => api.post('/orders', data),
    cancel: (id) => api.post(`/orders/${id}/cancel`),
    updateStatus: (id, status) => api.put(`/orders/${id}/status`, { status })
}

export const affiliateAPI = {
    profile: () => api.get('/affiliate/profile'),
    register: (data) => api.post('/affiliate/register', data),
    commissions: (params) => api.get('/affiliate/commissions', { params }),
    payouts: (data) => api.post('/affiliate/payouts', data)
}

export const adminAPI = {
    // Dashboard
    dashboardStats: () => api.get('/admin/dashboard/stats'),

    // Users
    users: (params) => api.get('/admin/users', { params }),
    createUser: (data) => api.post('/admin/users', data),
    updateUser: (id, data) => api.put(`/admin/users/${id}`, data),
    deleteUser: (id) => api.delete(`/admin/users/${id}`),

    // Orders
    adminOrders: (params) => api.get('/admin/orders', { params }),
    updateOrderStatus: (id, status) => api.put(`/admin/orders/${id}/status`, { status }),

    // Affiliates
    affiliates: (params) => api.get('/admin/affiliates', { params }),
    updateAffiliate: (id, data) => api.put(`/admin/affiliates/${id}`, data),

    // Reports
    salesReport: (params) => api.get('/admin/reports/sales', { params }),
    productsReport: (params) => api.get('/admin/reports/products', { params }),
    affiliatesReport: (params) => api.get('/admin/reports/affiliates', { params })
}

// File upload helper
export const uploadFile = (file, onProgress) => {
    const formData = new FormData()
    formData.append('file', file)

    return api.post('/upload', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: (progressEvent) => {
            if (onProgress) {
                const percentCompleted = Math.round(
                    (progressEvent.loaded * 100) / progressEvent.total
                )
                onProgress(percentCompleted)
            }
        }
    })
}

// Export default instance
export default api 