import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/services/api'
import { toast } from 'vue3-toastify'

export const useAuthStore = defineStore('auth', () => {
    // State
    const user = ref(null)
    const token = ref(localStorage.getItem('token'))
    const loading = ref(false)

    // Getters
    const isAuthenticated = computed(() => !!token.value)
    const isAdmin = computed(() => {
        if (!user.value || !user.value.roles) return false
        return user.value.roles.some(role => ['Super Admin', 'Store Manager'].includes(role.name))
    })
    const isAffiliate = computed(() => {
        if (!user.value || !user.value.roles) return false
        return user.value.roles.some(role => role.name === 'Affiliate')
    })

    // Actions
    const login = async (credentials) => {
        try {
            loading.value = true
            const response = await api.post('/auth/login', credentials)

            if (response.data.success) {
                const { user: userData, token: tokenData } = response.data.data

                // Store data
                user.value = userData
                token.value = tokenData

                // Save to localStorage
                localStorage.setItem('token', tokenData)
                localStorage.setItem('user', JSON.stringify(userData))

                // Set token in axios headers
                api.defaults.headers.common['Authorization'] = `Bearer ${tokenData}`

                toast.success('تم تسجيل الدخول بنجاح')
                return { success: true }
            }
        } catch (error) {
            const message = error.response?.data?.message || 'حدث خطأ في تسجيل الدخول'
            toast.error(message)
            return { success: false, error: message }
        } finally {
            loading.value = false
        }
    }

    const register = async (userData) => {
        try {
            loading.value = true
            const response = await api.post('/auth/register', userData)

            if (response.data.success) {
                const { user: newUser, token: tokenData } = response.data.data

                // Store data
                user.value = newUser
                token.value = tokenData

                // Save to localStorage
                localStorage.setItem('token', tokenData)
                localStorage.setItem('user', JSON.stringify(newUser))

                // Set token in axios headers
                api.defaults.headers.common['Authorization'] = `Bearer ${tokenData}`

                toast.success('تم إنشاء الحساب بنجاح')
                return { success: true }
            }
        } catch (error) {
            const message = error.response?.data?.message || 'حدث خطأ في إنشاء الحساب'
            toast.error(message)
            return { success: false, error: message }
        } finally {
            loading.value = false
        }
    }

    const logout = async () => {
        try {
            // Call logout API
            await api.post('/auth/logout')
        } catch (error) {
            console.error('Logout API error:', error)
        } finally {
            // Clear local data
            user.value = null
            token.value = null

            // Remove from localStorage
            localStorage.removeItem('token')
            localStorage.removeItem('user')

            // Remove from axios headers
            delete api.defaults.headers.common['Authorization']

            toast.success('تم تسجيل الخروج بنجاح')
        }
    }

    const fetchUser = async () => {
        try {
            if (!token.value) return

            const response = await api.get('/auth/me')
            if (response.data.success) {
                user.value = response.data.data.user
                localStorage.setItem('user', JSON.stringify(response.data.data.user))
            }
        } catch (error) {
            console.error('Fetch user error:', error)
            // If token is invalid, logout
            if (error.response?.status === 401) {
                logout()
            }
        }
    }

    const updateProfile = async (profileData) => {
        try {
            loading.value = true
            const response = await api.put('/user/profile', profileData)

            if (response.data.success) {
                user.value = response.data.data.user
                localStorage.setItem('user', JSON.stringify(response.data.data.user))
                toast.success('تم تحديث الملف الشخصي بنجاح')
                return { success: true }
            }
        } catch (error) {
            const message = error.response?.data?.message || 'حدث خطأ في تحديث الملف الشخصي'
            toast.error(message)
            return { success: false, error: message }
        } finally {
            loading.value = false
        }
    }

    const changePassword = async (passwordData) => {
        try {
            loading.value = true
            const response = await api.post('/user/change-password', passwordData)

            if (response.data.success) {
                toast.success('تم تغيير كلمة المرور بنجاح')
                return { success: true }
            }
        } catch (error) {
            const message = error.response?.data?.message || 'حدث خطأ في تغيير كلمة المرور'
            toast.error(message)
            return { success: false, error: message }
        } finally {
            loading.value = false
        }
    }

    const initializeAuth = () => {
        // Set token in axios headers if exists
        if (token.value) {
            api.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
            // Fetch user data
            fetchUser()
        }
    }

    return {
        // State
        user,
        token,
        loading,

        // Getters
        isAuthenticated,
        isAdmin,
        isAffiliate,

        // Actions
        login,
        register,
        logout,
        fetchUser,
        updateProfile,
        changePassword,
        initializeAuth
    }
}) 