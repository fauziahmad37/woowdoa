# Aplikasi Wakaf Santri

Aplikasi Wakaf Santri adalah aplikasi berbasis Laravel untuk mengelola program wakaf santri dengan fitur-fitur berita, event, dan transaksi wakaf.

## Fitur

Aplikasi ini memiliki tiga fitur utama:

1. **Berita (News)** - Mengelola berita dan pengumuman terkait program wakaf santri
2. **Event** - Mengelola acara dan kegiatan santri
3. **Transaksi Wakaf** - Mengelola transaksi wakaf, sadaqah, dan infaq

## Teknologi

- Laravel 12
- PHP 8.3+
- SQLite (dapat diganti dengan MySQL/PostgreSQL)
- RESTful API

## Instalasi

1. Clone repository:
```bash
git clone https://github.com/fauziahmad37/woowdoa.git
cd woowdoa
```

2. Install dependencies:
```bash
composer install
```

3. Copy file environment:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Jalankan migrasi database:
```bash
php artisan migrate
```

6. Jalankan server development:
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## API Endpoints

### News (Berita)

#### Get All News
```
GET /api/news
```

Response:
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "Pembukaan Program Wakaf Santri 2024",
        "content": "...",
        "author": "Admin",
        "image": null,
        "is_published": true,
        "published_at": "2024-01-15T10:00:00.000000Z",
        "created_at": "2024-01-15T10:00:00.000000Z",
        "updated_at": "2024-01-15T10:00:00.000000Z"
      }
    ],
    "total": 1
  }
}
```

#### Create News
```
POST /api/news
Content-Type: application/json

{
  "title": "Judul Berita",
  "content": "Konten berita",
  "author": "Nama Penulis",
  "image": "url_gambar",
  "is_published": true,
  "published_at": "2024-01-15T10:00:00"
}
```

#### Get Single News
```
GET /api/news/{id}
```

#### Update News
```
PUT /api/news/{id}
Content-Type: application/json

{
  "title": "Judul Berita Updated",
  "content": "Konten berita updated"
}
```

#### Delete News
```
DELETE /api/news/{id}
```

### Events

#### Get All Events
```
GET /api/events
```

Response:
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "Halaqah Tahfidz Quran",
        "description": "Acara halaqah tahfidz Quran untuk santri",
        "location": "Masjid Al-Ikhlas",
        "start_date": "2024-02-20T08:00:00.000000Z",
        "end_date": null,
        "image": null,
        "is_active": true,
        "created_at": "2024-02-19T02:45:12.000000Z",
        "updated_at": "2024-02-19T02:45:12.000000Z"
      }
    ],
    "total": 1
  }
}
```

#### Create Event
```
POST /api/events
Content-Type: application/json

{
  "title": "Judul Event",
  "description": "Deskripsi event",
  "location": "Lokasi event",
  "start_date": "2024-02-20T08:00:00",
  "end_date": "2024-02-20T12:00:00",
  "image": "url_gambar",
  "is_active": true
}
```

#### Get Single Event
```
GET /api/events/{id}
```

#### Update Event
```
PUT /api/events/{id}
Content-Type: application/json

{
  "title": "Judul Event Updated"
}
```

#### Delete Event
```
DELETE /api/events/{id}
```

### Waqf Transactions (Transaksi Wakaf)

#### Get All Transactions
```
GET /api/waqf-transactions
```

Response:
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "donor_name": "Ahmad Fauzi",
        "donor_email": "ahmad@example.com",
        "donor_phone": "081234567890",
        "amount": "500000.00",
        "transaction_type": "wakaf",
        "purpose": "Pembangunan asrama santri",
        "payment_method": "transfer_bank",
        "payment_status": "pending",
        "transaction_code": "WQF-PHAPXBGE7S",
        "paid_at": null,
        "created_at": "2024-02-19T02:45:19.000000Z",
        "updated_at": "2024-02-19T02:45:19.000000Z"
      }
    ],
    "total": 1
  }
}
```

#### Create Transaction
```
POST /api/waqf-transactions
Content-Type: application/json

{
  "donor_name": "Nama Donatur",
  "donor_email": "email@example.com",
  "donor_phone": "081234567890",
  "amount": 500000,
  "transaction_type": "wakaf",
  "purpose": "Tujuan wakaf",
  "payment_method": "transfer_bank"
}
```

Transaction types: `wakaf`, `sadaqah`, `infaq`
Payment status: `pending`, `completed`, `failed`

#### Get Single Transaction
```
GET /api/waqf-transactions/{id}
```

#### Update Transaction
```
PUT /api/waqf-transactions/{id}
Content-Type: application/json

{
  "payment_status": "completed",
  "paid_at": "2024-02-19T10:00:00"
}
```

#### Delete Transaction
```
DELETE /api/waqf-transactions/{id}
```

## Database Schema

### News Table
- `id` - Primary key
- `title` - Judul berita
- `content` - Isi berita
- `author` - Penulis
- `image` - URL gambar
- `is_published` - Status publikasi
- `published_at` - Tanggal publikasi
- `created_at`, `updated_at` - Timestamps

### Events Table
- `id` - Primary key
- `title` - Judul event
- `description` - Deskripsi event
- `location` - Lokasi event
- `start_date` - Tanggal mulai
- `end_date` - Tanggal selesai
- `image` - URL gambar
- `is_active` - Status aktif
- `created_at`, `updated_at` - Timestamps

### Waqf Transactions Table
- `id` - Primary key
- `donor_name` - Nama donatur
- `donor_email` - Email donatur
- `donor_phone` - Nomor telepon donatur
- `amount` - Jumlah donasi
- `transaction_type` - Jenis transaksi (wakaf/sadaqah/infaq)
- `purpose` - Tujuan wakaf
- `payment_method` - Metode pembayaran
- `payment_status` - Status pembayaran
- `transaction_code` - Kode transaksi (auto-generated)
- `paid_at` - Tanggal pembayaran
- `created_at`, `updated_at` - Timestamps

## Testing

Jalankan test dengan:
```bash
php artisan test
```

## License

MIT License
