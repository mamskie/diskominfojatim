<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

Untuk menginstal dan menjalankan aplikasi Laravel ini, ikuti langkah-langkah berikut:

### Prerequisites

Pastikan Anda telah menginstal:

- PHP (versi 7.4 atau lebih tinggi)
- Composer
- MySQL atau MariaDB
- Laravel (jika Anda ingin menginstalnya secara global)

### Step 1: Clone the Repository

Clone repositori ini ke dalam direktori lokal Anda:

```bash
git clone https://github.com/mamskie/diskominfojatim.git
cd diskominfojatim
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Configurasi Environment

```bash
cp .env.example .env
```
Edit file .env dan masukkan detail database Anda:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seleksidiskominfojatim
DB_USERNAME=db_username
DB_PASSWORD=db_password
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Migrasi Database

```bash
php artisan migrate
```

### Step 6: Jalankan Aplikasi

```bash
php artisan serve
```

## API Documentation

### Overview

Aplikasi ini menyediakan API untuk mengelola produk dan pesanan. API ini memiliki dua endpoint utama: **Products** dan **Orders**.

### Products API

#### List Products
- Url = /api/products
- Method = `GET`
- Deskripsi = Mendapatkan daftar semua produk

Respon:
 - HTTP Code = 200
 - Content Type = "application/json"
 - Data Schema:
```json
   {
  "message": "List Products",
  "data": [
        {
        "id": 1,
        "name": "Product 1",
        "price": 10000,
        "stock": 50,
        "sold": 10,
        "created_at": "2024-09-22T10:00:00Z",
        "updated_at": "2024-09-22T12:00:00Z"
        }
        ]
    }
```

#### Create Product
- Url: /api/products
- Method: `POST`
- Deskripsi: Menambahkan produk baru
- Request Body:
```json
{
  "name": "Product Name",
  "price": 15000, 
  "stock": 20 
}
```
Respon:
- HTTP Code: 200
- Content Type: application/json
- Data Schema:
```json
{
  "message": "Product Created",
  "data": {
    "id": 2,
    "name": "Product Name",
    "price": 15000, 
    "stock": 20, 
    "sold": 0, 
    "created_at": "2024-09-22T12:00:00Z", 
    "updated_at": "2024-09-22T12:00:00Z" 
  }
}
```
#### Detail Products
- Url: /api/products/`{id}`
- Method: `GET`
- Deskripsi: Mendapatkan detail sebuah produk berdasarkan ID
  
Path Parameter:
- `id`: string (required)
  
Respon:
- HTTP Code: 200
- Content Type: application/json
- Data Schema:
```json
{
  "message": "Product Detail",
  "data": {
    "id": 2,
    "name": "Product Name",
    "price": 15000, 
    "stock": 20, 
    "sold": 5, 
    "created_at": "2024-09-22T12:00:00Z", 
    "updated_at": "2024-09-23T12:00:00Z" 
  }
}
```

#### Update Products
- Url: /api/products/`{id}`
- Method: `PUT`
- Deskripsi: Memperbarui sebuah produk berdasarkan ID

Path Parameter:
- id: string (required)
- Request Body (optional)
```json
{
  "name": "Updated Product",
  "price": 20000,
  "stock": 15
}
```

Respon:
- HTTP Code: 200
- Content Type: application/json
- Data Schema:
```json
{
  "message": "Product Updated",
  "data": {
    "id": 2,
    "name": "Updated Product",
    "price": 20000,
    "stock": 15,
    "sold": 5,
    "created_at": "2024-09-22T12:00:00Z",
    "updated_at": "2024-09-23T15:00:00Z"
  }
}
```
#### Delete Product
- Url: /api/products/`{id}`
- Method: `DELETE`
- Deskripsi: Menghapus sebuah produk berdasarkan ID

Path Parameter:
- id: string (required)

Respon:
- HTTP Code: 200
- Content Type: application/json
- Data Schema:
```json
{
  "message": "Product Deleted",
  "data": {
    "id": 2,
    "name": "Product Name",
    "price": 15000,
    "stock": 20,
    "sold": 5,
    "created_at": "2024-09-22T12:00:00Z",
    "updated_at": "2024-09-23T15:00:00Z"
  }
}
```
Error Responses
- HTTP Code: 422 (Parameter Error)
```json
{
  "message": "Validation Error",
  "errors": {
    "name": ["Name is required"],
    "price": ["Price must be at least 1"],
    "stock": ["Stock must be a positive number"]
  }
}
```
- HTTP Code: 404 (Product Not Found)
```json
{
  "message": "Product not found"
}
```

### Orders API

#### List Orders
- Url: /api/orders
- Method: `GET`
- Deskripsi: Mendapatkan daftar semua pesanan

Respon:
- HTTP Code: 200
- Content Type: application/json
- Data Schema:
```json
{
  "message": "List Orders",
  "data": [
    {
      "id": 1,
      "products": [
        {
          "id": 2,
          "quantity": 3
        }
      ],
      "created_at": "2024-09-22T10:00:00Z",
      "updated_at": "2024-09-22T12:00:00Z"
    }
  ]
}
```

#### Create Order
- Url: /api/orders
- Method: `POST`
- Deskripsi: Membuat pesanan baru
- Request Body:
```json
{
  "products": [
    {
      "id": 1,
      "quantity": 2
    },
    {
      "id": 2,
      "quantity": 1
    }
  ]
}
```

Respon:
- HTTP Code: 200
- Content Type: application/json
- Data Schema:
```json
{
  "message": "Order Created",
  "data": {
    "id": 1,
    "products": [
      {
        "id": 1,
        "quantity": 2
      },
      {
        "id": 2,
        "quantity": 1
      }
    ],
    "created_at": "2024-09-22T10:00:00Z",
    "updated_at": "2024-09-22T10:00:00Z"
  }
}
```

#### Detail Order
- Url: /api/orders/`{id}`
- Method: `GET`
- Deskripsi: Mendapatkan detail sebuah pesanan berdasarkan ID

Path Parameter:
- id: string (required)

Respon:
- HTTP Code: 200
- Content Type: application/json
- Data Schema:
```json
{
  "message": "Order Detail",
  "data": {
    "id": 1,
    "products": [
      {
        "id": 1,
        "quantity": 2
      },
      {
        "id": 2,
        "quantity": 1
      }
    ],
    "created_at": "2024-09-22T10:00:00Z",
    "updated_at": "2024-09-22T10:00:00Z"
  }
}
```

#### Delete Order
- Url: /api/orders/`{id}`
- Method: `DELETE`
- Deskripsi: Menghapus atau membatalkan sebuah pesanan berdasarkan ID

Path Parameter:
- id: string (required)

Respon:
- HTTP Code: 200
- Content Type: application/json
- Data Schema:
```json
{
  "message": "Order Deleted",
  "data": {
    "id": 1,
    "products": [
      {
        "id": 1,
        "quantity": 2
      },
      {
        "id": 2,
        "quantity": 1
      }
    ],
    "created_at": "2024-09-22T10:00:00Z",
    "updated_at": "2024-09-22T10:00:00Z"
  }
}
```
Error Responses
- HTTP Code: 404 (Record Not Found)
```json
{
  "message": "Order not found"
}
```
- HTTP Code: 400 (Bad Request)
```json
{
  "message": "Bad Request"
}
```
