# 📡 API Endpoints - SmartShop ERP System

## نظرة عامة

هذا التوثيق يغطي جميع نقاط النهاية (Endpoints) المتاحة في SmartShop ERP API.

**Base URL**: `http://localhost:8000/api/v1`

## Authentication

### تسجيل الدخول
```http
POST /auth/login
```

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "user@example.com",
      "roles": [...]
    },
    "token": "1|abc123...",
    "token_type": "Bearer"
  }
}
```

### تسجيل مستخدم جديد
```http
POST /auth/register
```

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "user@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "+1234567890"
}
```

### تسجيل الخروج
```http
POST /auth/logout
```

**Headers:**
```
Authorization: Bearer {token}
```

## Products

### الحصول على جميع المنتجات
```http
GET /products
```

**Query Parameters:**
- `search` - البحث في اسم أو وصف المنتج
- `category_id` - تصفية حسب التصنيف
- `min_price` - الحد الأدنى للسعر
- `max_price` - الحد الأقصى للسعر
- `sort_by` - ترتيب حسب (price, name, created_at)
- `sort_order` - اتجاه الترتيب (asc, desc)
- `per_page` - عدد العناصر في الصفحة

**Response:**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "name": "Product Name",
        "description": "Product description",
        "price": "99.99",
        "sale_price": "79.99",
        "stock_quantity": 100,
        "category": {...},
        "brand": {...},
        "images": [...]
      }
    ],
    "total": 50,
    "per_page": 12
  }
}
```

### الحصول على منتج واحد
```http
GET /products/{id}
```

### إنشاء منتج جديد (Admin)
```http
POST /products
```

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body:**
```json
{
  "name": "New Product",
  "description": "Product description",
  "price": "99.99",
  "category_id": 1,
  "stock_quantity": 100,
  "images": [file1, file2, ...]
}
```

### تحديث منتج (Admin)
```http
PUT /products/{id}
```

### حذف منتج (Admin)
```http
DELETE /products/{id}
```

### المنتجات المميزة
```http
GET /products/featured
```

## Orders

### الحصول على طلبات المستخدم
```http
GET /orders
```

**Headers:**
```
Authorization: Bearer {token}
```

### إنشاء طلب جديد
```http
POST /orders
```

**Request Body:**
```json
{
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ],
  "shipping_address": {
    "name": "John Doe",
    "address": "123 Main St",
    "city": "New York",
    "country": "USA",
    "postal_code": "10001"
  },
  "payment_method": "stripe"
}
```

### الحصول على طلب واحد
```http
GET /orders/{id}
```

### إلغاء طلب
```http
POST /orders/{id}/cancel
```

## Affiliates

### الحصول على معلومات المسوق
```http
GET /affiliate/profile
```

**Headers:**
```
Authorization: Bearer {token}
```

### إنشاء حساب مسوق
```http
POST /affiliate/register
```

**Request Body:**
```json
{
  "commission_rate": 10,
  "payment_method": "bank_transfer",
  "payment_details": {
    "bank_name": "Example Bank",
    "account_number": "1234567890"
  }
}
```

### الحصول على العمولات
```http
GET /affiliate/commissions
```

### طلب سحب الأرباح
```http
POST /affiliate/payouts
```

**Request Body:**
```json
{
  "amount": 500,
  "payment_method": "bank_transfer"
}
```

## Categories

### الحصول على جميع التصنيفات
```http
GET /categories
```

### الحصول على منتجات التصنيف
```http
GET /categories/{id}/products
```

## Users

### الحصول على معلومات المستخدم
```http
GET /user/profile
```

### تحديث معلومات المستخدم
```http
PUT /user/profile
```

**Request Body:**
```json
{
  "name": "John Doe",
  "phone": "+1234567890",
  "address": "123 Main St"
}
```

### تغيير كلمة المرور
```http
POST /user/change-password
```

**Request Body:**
```json
{
  "current_password": "oldpassword",
  "new_password": "newpassword",
  "new_password_confirmation": "newpassword"
}
```

## Admin Endpoints

### لوحة التحكم - الإحصائيات
```http
GET /admin/dashboard/stats
```

### إدارة المستخدمين
```http
GET /admin/users
POST /admin/users
PUT /admin/users/{id}
DELETE /admin/users/{id}
```

### إدارة الطلبات
```http
GET /admin/orders
PUT /admin/orders/{id}/status
```

### التقارير
```http
GET /admin/reports/sales
GET /admin/reports/products
GET /admin/reports/affiliates
```

## Error Responses

### Validation Error (422)
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

### Unauthorized (401)
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

### Not Found (404)
```json
{
  "success": false,
  "message": "Resource not found"
}
```

### Server Error (500)
```json
{
  "success": false,
  "message": "Internal server error"
}
```

## Rate Limiting

- **Public endpoints**: 60 requests per minute
- **Authenticated endpoints**: 120 requests per minute
- **Admin endpoints**: 300 requests per minute

## Pagination

جميع النقاط النهاية التي تعيد قوائم تدعم الترقيم:

**Query Parameters:**
- `page` - رقم الصفحة (افتراضي: 1)
- `per_page` - عدد العناصر في الصفحة (افتراضي: 15)

**Response Format:**
```json
{
  "current_page": 1,
  "data": [...],
  "first_page_url": "...",
  "from": 1,
  "last_page": 5,
  "last_page_url": "...",
  "next_page_url": "...",
  "path": "...",
  "per_page": 15,
  "prev_page_url": null,
  "to": 15,
  "total": 75
}
```

## File Upload

لرفع الملفات، استخدم `multipart/form-data`:

```http
POST /products
Content-Type: multipart/form-data

{
  "name": "Product",
  "images": [file1, file2, ...]
}
```

**Supported Formats:**
- Images: JPEG, PNG, GIF (max 2MB)
- Documents: PDF, DOC, DOCX (max 5MB)

---

**ملاحظة**: جميع النقاط النهاية تتطلب مصادقة ما لم يذكر خلاف ذلك. 