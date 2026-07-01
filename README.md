# FinTrack - Unified Account System (UAS)

**FinTrack** adalah aplikasi fintech modern berbasis **Laravel 12** dengan arsitektur **Modular Monolith** yang menyediakan solusi manajemen keuangan personal terintegrasi. Aplikasi ini memungkinkan pengguna melacak transaksi, menganalisis pengeluaran dengan AI, dan merencanakan tujuan finansial.

## ✨ Fitur Utama

### 📊 **Module A: Transaction Management**
- Pencatatan income dan expense secara real-time
- Kategorisasi otomatis menggunakan AI (Groq API)
- CRUD operations dengan validasi lengkap
- Filter dan sorting berdasarkan tanggal, kategori, tipe

### 📈 **Module B: Financial Analysis**
- Dashboard ringkasan keuangan (total income, expense, balance)
- Breakdown pengeluaran per kategori dengan persentase
- **AI-Powered Insights** menggunakan Groq API untuk rekomendasi finansial
- Laporan analisis tersimpan untuk tracking historis

### 🎯 **Module C: Financial Planning**
- Goal-based financial planning dengan target amount dan deadline
- Tracking progress terhadap goals
- Integrasi dengan data transaksi untuk real-time progress update
- Rekomendasi investasi berbasis data

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | Laravel 12, PHP 8.2 |
| **Frontend** | Vue.js (via Vite), Tailwind CSS 4, Axios |
| **API** | RESTful API dengan Laravel Sanctum |
| **Database** | MySQL/SQLite dengan Eloquent ORM |
| **AI Integration** | Groq API (groq-1.5-mini) |
| **Build Tool** | Vite 7 |
| **Task Queue** | Laravel Queue |
| **Testing** | PHPUnit 11 |

## 📋 Persyaratan Sistem

- **PHP** 8.2 atau lebih tinggi
- **Node.js** 18+
- **Composer** 2.0+
- **MySQL** 8.0+ atau SQLite
- **Groq API Key** (untuk fitur AI insights)

## 🚀 Instalasi & Setup

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/uas.git
cd uas
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dan konfigurasi:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fintrack
DB_USERNAME=root
DB_PASSWORD=

# Groq AI Configuration
GROQ_API_KEY=your_groq_api_key
GROQ_API_ENDPOINT=https://api.groq.com/v1
GROQ_API_MODEL=groq-1.5-mini
```

### 4. Database Migration
```bash
php artisan migrate
php artisan db:seed
```

### 5. Setup Lengkap (One Command)
```bash
composer setup
```

## 💻 Development

### Jalankan Development Environment
```bash
composer dev
```

Command ini akan menjalankan secara concurrent:
- **PHP Server** (http://localhost:8000)
- **Queue Worker** (untuk job processing)
- **Pail Logs** (real-time logging)
- **Vite Dev Server** (hot reload assets)

### Hanya Frontend
```bash
npm run dev
```

### Build untuk Production
```bash
npm run build
php artisan optimize
```

## 🧪 Testing

Jalankan test suite lengkap:
```bash
composer test
```

Test individual file:
```bash
php artisan test tests/Feature/AuthTest.php
```

## 📡 API Documentation

### Authentication

#### Register
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

### Transactions
```http
# List all transactions
GET /api/transactions
Authorization: Bearer {token}

# Create transaction
POST /api/transactions
Authorization: Bearer {token}
Content-Type: application/json

{
  "amount": 50000,
  "type": "expense",
  "category": "Food",
  "description": "Lunch at cafe",
  "date": "2026-07-01"
}

# Update transaction
PATCH /api/transactions/{id}
Authorization: Bearer {token}

# Delete transaction
DELETE /api/transactions/{id}
Authorization: Bearer {token}
```

### Analysis
```http
# Generate financial analysis
POST /api/analyze
Authorization: Bearer {token}

# Get latest analysis
GET /api/analyze/latest
Authorization: Bearer {token}
```

### Goals
```http
# List goals
GET /api/goals
Authorization: Bearer {token}

# Create goal
POST /api/goals
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Save for vacation",
  "target_amount": 5000000,
  "deadline": "2026-12-31"
}
```

### Finance Summary
```http
GET /api/finance/summary
Authorization: Bearer {token}
```

## 📁 Project Structure

```
uas/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/          # API Controllers
│   │   └── Requests/                 # Form Request Validation
│   ├── Models/                       # Eloquent Models
│   ├── Services/                     # Business Logic
│   │   ├── TransactionService.php
│   │   ├── AnalysisService.php
│   │   ├── GoalService.php
│   │   ├── PlanningService.php
│   │   └── AiCategorizationService.php
│   └── Providers/
├── database/
│   ├── migrations/                   # Database Migrations
│   ├── factories/                    # Faker Factories
│   └── seeders/                      # Database Seeders
├── resources/
│   ├── css/                          # Tailwind CSS
│   ├── js/                           # Vue.js Components
│   └── views/                        # Blade Templates
├── routes/
│   ├── api.php                       # API Routes
│   ├── web.php                       # Web Routes
│   └── console.php                   # Artisan Commands
├── config/                           # Configuration Files
├── storage/                          # Logs, Cache
├── tests/                            # Test Cases
├── design/                           # UI/UX Design Docs
└── public/                           # Public Assets
```

## 📊 Data Models

### User
- Relationships: hasMany(Transaction, Goal, Plan, AnalysisReport, AiInsight, Category)
- Authentication: Sanctum tokens

### Transaction
- **Fields**: id, user_id, amount, type, category, description, date, timestamps
- **Relations**: belongsTo(User)
- **Casts**: amount (decimal:2), date (date)

### Goal
- **Fields**: id, user_id, name, target_amount, current_amount, deadline, timestamps
- **Relations**: belongsTo(User)
- **Casts**: target_amount (decimal:2), current_amount (decimal:2), deadline (date)

### AnalysisReport
- **Fields**: id, user_id, total_income, total_expense, balance, transaction_count, top_category, timestamps
- **Relations**: hasMany(CategoryBreakdown), hasMany(AiInsight)

### Plan
- **Fields**: id, user_id, name, description, created_at, updated_at
- **Relations**: belongsTo(User)

## 🎨 UI/UX Design

Aplikasi menggunakan **Catppuccin Mocha** palette dengan aksen hijau fintech:
- **Primary Color**: `#1E8A4F` (Finance Green)
- **Design System**: Glassmorphism ringan, rounded corners 12-16px
- **Responsive**: Desktop dan mobile
- **Dark Mode**: Support penuh

Lihat `design/fintrack-ui-ux-design.md` untuk detail lengkap.

## 🔐 Security

- **Authentication**: Laravel Sanctum (token-based API auth)
- **Validation**: Form requests validation
- **CORS**: Configured untuk API security
- **Password**: Hashing dengan bcrypt
- **Env**: Sensitive data di `.env` (tidak di-commit)

## 🚦 Environment Variables

```env
APP_NAME=FinTrack
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fintrack
DB_USERNAME=root
DB_PASSWORD=

GROQ_API_KEY=
GROQ_API_ENDPOINT=https://api.groq.com/v1
GROQ_API_MODEL=groq-1.5-mini

QUEUE_CONNECTION=database
```

## 📝 Artisan Commands

```bash
# Scaffold resources
php artisan make:model Transaction -m
php artisan make:controller Api/TransactionController
php artisan make:request StoreTransactionRequest
php artisan make:service TransactionService

# Database
php artisan migrate
php artisan migrate:rollback
php artisan db:seed

# Queue
php artisan queue:work
php artisan queue:listen

# Optimization
php artisan optimize
php artisan config:cache
```

## 🔄 Roadmap

- [ ] Keycloak integration (OIDC authentication)
- [ ] Two-factor authentication (2FA)
- [ ] Export reports (PDF, Excel)
- [ ] Budget planning module
- [ ] Mobile app (React Native)
- [ ] Real-time notifications
- [ ] Multi-currency support
- [ ] Advanced analytics dashboard

## 🤝 Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

## 📄 License

Project ini dilisensikan di bawah **MIT License** - lihat file [LICENSE](LICENSE) untuk detail.

## 👨‍💻 Author

**[Your Name]** - [GitHub Profile](https://github.com/yourusername)

## 📞 Support

Jika Anda menemukan bug atau punya saran:
- 📧 Email: support@fintrack.dev
- 💬 Issues: [GitHub Issues](https://github.com/yourusername/uas/issues)
- 📚 Documentation: [Wiki](https://github.com/yourusername/uas/wiki)

---

**Made with ❤️ for personal finance management**
