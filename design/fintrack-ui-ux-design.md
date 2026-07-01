# FinTrack Modular Monolith UI/UX Design

## Konsep Utama

- **Modular Monolith**: satu aplikasi tunggal dengan tiga domain terasa seperti mini-system yang terpisah secara logika.
- **Visual separation** antara module: sidebar grouping, section headings, card accents, dan background cards.
- **Clean, modern, glassmorphism ringan** dengan dominasi warna hijau (finance), putih, abu lembut.
- **Rounded corner 12–16px**, **shadow halus**, font modern seperti `Inter` atau `Poppins`.
- **Responsive** untuk desktop dan mobile.
- **Dark mode** tersedia sebagai lapisan tambahan (`dark` state).

---

## Palet Warna

- Primary: `#1E8A4F` / `#34B27E`
- Soft green: `#ECF9F1`
- White: `#FFFFFF`
- Light grey: `#F5F7FA`
- Neutral grey: `#A1A9B8`
- Dark grey: `#2C333A`
- Glass overlay: `rgba(255,255,255,0.65)`
- Accent AI: `#EAF7FF`

## Typography

- Font utama: `Inter`, fallback `system-ui`, `sans-serif`
- Judul: `600` atau `700`
- Body: `400`
- Spacing: `1.25rem` container, `0.75rem` card padding

---

## Struktur Navigasi

### Sidebar Modular

- `MAIN MENU`
- `MODULE A — TRANSACTIONS`
  - Transactions
  - Categories
- `MODULE B — ANALYSIS`
  - Financial Summary
  - Insights (AI)
- `MODULE C — PLANNING`
  - Goals
  - Investment Recommendation
- `OTHER`
  - Profile
  - Logout

### Top Navbar

- Breadcrumb / page title
- Search kecil atau quick action
- Mode switch (light/dark)
- User avatar + status

---

## Komponen Reusable

### 1. Sidebar Card

- Glass card background
- Group label + vertical menu
- Active item highlight hijau
- Module badge text kecil

### 2. Module Header

- `Transaction Module`, `Analysis Module`, `Planning Module` label
- Subtitle: "Mini system untuk ..."
- Card header with accent line

### 3. Summary Card

- Ringkasan utama: Income / Expense / Balance
- Icon sederhana, value besar, trend subtitle
- `bg-white` / `bg-slate-50` dengan shadow ringan

### 4. AI Insight Card

- Badged label `AI Generated`
- Highlight background `#EAF7FF`
- Title + recommended action
- Optional CTA `Lihat detail` atau `Analisis ulang`

### 5. Chart Card

- Card dengan title, subtitle, dan chart canvas
- `Chart.js` friendly
- Sass/Tailwind utility classes

### 6. Modal Form Modern

- Rounded corners besar
- Soft overlay
- Floating labels atau simple labels
- Buttons: `Save`, `Cancel`

### 7. Loading Skeleton

- Block placeholders
- Animated shimmer
- Use on page load / chart render / table load

---

## Halaman dan Layout

### 1. Dashboard Global

**Tujuan**: pusat overview dengan ringkasan global dan gateway ke ketiga module.

- Hero card full-width: `Halo, [User]`, ringkasan singkat sistem
- Summary tiles: `Total Income`, `Total Expense`, `Balance`
- `Overview` chart (line area chart)
- `Insight AI` card: ringkasan otomatis + `AI Generated` badge
- `Quick Recommendations` card: 2–3 bullets / CTA
- `Module launcher`: 3 mini cards
  - Transaction Module
  - Analysis Module
  - Planning Module


### 2. Transaction Module

**Tujuan**: manajemen input & data transaksi.

- Page header: `Transaction Module` + deskripsi
- Filter bar: date range, kategori, search
- Action row: `Tambah Transaksi` button
- Table clean:
  - Date, Description, Category, Amount, Type, Action
  - Hover row effect, badge kategori, tag AI jika otomatis
- `AI category suggestion` badge kecil di setiap baris baru
- Side-panel / card sebelah kanan:
  - Quick summary module
  - `Auto categorization` status
  - CTA `Use AI Auto-categorize`

### 3. Analysis Module

**Tujuan**: visualisasi dan insight AI.

- Page header: `Analysis Module` + deskripsi
- Statistik utama: cards `Expenses by category`, `Income vs Expense`, `Balance trend`
- Chart grid:
  - Doughnut / pie untuk category breakdown
  - Bar / line untuk monthly comparison
- `Insight AI` highlight card:
  - `AI Generated`
  - Summary text + advice
- `Top categories` list card
- `Action card` untuk generate ulang insight atau compare scenario

### 4. Planning Module

**Tujuan**: goals, investasi, simulasi keputusan.

- Page header: `Planning Module` + deskripsi
- Goals section:
  - Card per goal dengan progress bar animasi
  - Info `current / target`, deadline, status
- Investment Recommendation AI card:
  - `AI Generated`
  - Rekomendasi pendek dan button `Lihat strategi`
- Savings simulator tab:
  - Input `monthly saving`, `target date`
  - Output proyeksi `balance` dan `completion rate`
- Secondary cards:
  - `Expected return`, `Risk level`, `Priority score`

### 5. Profile

- Simple profile card
- Data user: nama, email, role, update terakhir
- Edit form inline
- `Logout` button
- Optional security card: `Last login`, `Two-factor`

---

## Layout Example (Blade + Bootstrap)

### Root Layout Struktur

```blade
<div class="d-flex min-vh-100 bg-soft">
    <aside class="sidebar bg-white shadow-sm border-end">
        {{-- Sidebar groups --}}
    </aside>

    <main class="flex-fill px-4 py-4">
        <header class="d-flex align-items-center justify-content-between mb-4">
            {{-- Topbar, title, mode switch --}}
        </header>

        <section class="page-header mb-4">
            <div class="card card-glass rounded-3 p-4 shadow-sm">
                {{-- Page hero / breadcrumbs --}}
            </div>
        </section>

        <section class="page-content">
            {{-- Page-specific cards and grids --}}
        </section>
    </main>
</div>
```

### Sidebar Sample

```blade
<nav class="sidebar-menu pt-4">
    <div class="menu-group mb-4">
        <p class="text-uppercase text-muted small mb-2">Main Menu</p>
        <a href="{{ route('dashboard') }}" class="nav-link active">Dashboard</a>
    </div>

    <div class="menu-group mb-4">
        <p class="text-uppercase text-muted small mb-2">Module A — Transactions</p>
        <a href="{{ route('transactions') }}" class="nav-link">Transactions</a>
        <a href="#" class="nav-link">Categories</a>
    </div>

    <div class="menu-group mb-4">
        <p class="text-uppercase text-muted small mb-2">Module B — Analysis</p>
        <a href="#" class="nav-link">Financial Summary</a>
        <a href="#" class="nav-link">Insights (AI)</a>
    </div>

    <div class="menu-group mb-4">
        <p class="text-uppercase text-muted small mb-2">Module C — Planning</p>
        <a href="#" class="nav-link">Goals</a>
        <a href="#" class="nav-link">Investment Recommendation</a>
    </div>

    <div class="menu-group mt-auto">
        <p class="text-uppercase text-muted small mb-2">Other</p>
        <a href="#" class="nav-link">Profile</a>
        <a href="#" class="nav-link text-danger">Logout</a>
    </div>
</nav>
```

### Card Style Sample

```css
.card-glass {
  background: rgba(255,255,255,0.72);
  backdrop-filter: blur(18px);
  border: 1px solid rgba(255,255,255,0.75);
}

.card-accent {
  border-left: 4px solid #34B27E;
}
```

### AI Insight Card Sample

```blade
<div class="card card-glass border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div>
                <p class="badge bg-info-subtle text-info">AI Generated</p>
                <h5 class="mb-1">Rekomendasi Keuangan</h5>
                <p class="text-muted mb-0">Wawasan AI menyoroti kategori pengeluaran tertinggi.</p>
            </div>
            <span class="text-success">+3%</span>
        </div>
        <p class="mb-0">Gunakan tabungan otomatis untuk mengurangi biaya non-esensial dan tingkatkan alokasi investasi ke 20% dari pendapatan.</p>
    </div>
</div>
```

---

## UX Prioritas

- Modul terasa seperti mini system dengan label jelas: `Transaction Module`, `Analysis Module`, `Planning Module`.
- Perpindahan antar module harus punya **transition fade / slide**.
- Semua card AI diberi badge `AI Generated` dan warna berbeda.
- Setiap module punya panel ringkas di samping untuk akses cepat.
- Gunakan spacing yang konsisten untuk menonjolkan modularity.

---

## Saran Implementasi

- Gunakan `Bootstrap 5` dengan custom utility classes.
- Atau `Tailwind CSS` dengan variable tema, dark mode, dan glassmorphism.
- Tambahkan `@layer utilities` untuk:
  - `.card-glass`
  - `.sidebar-module`
  - `.badge-ai`
  - `.page-section-title`
- Pastikan mobile: sidebar collapse ke hamburger, cards stack.

---

## Halaman Prioritas

1. `Dashboard`: global overview + module preview
2. `Transactions`: data entry + table + AI category badge
3. `Analysis`: chart + breakdown + AI insight highlight
4. `Planning`: goals cards + recommendation + simulator
5. `Profile`: user data + edit + logout

---

## Rekomendasi Struktur Blade

- `layouts/app.blade.php`: root layout with sidebar + topbar
- `components/card-summary.blade.php`
- `components/card-ai-insight.blade.php`
- `components/chart-panel.blade.php`
- `components/modal-transaction.blade.php`
- `pages/dashboard.blade.php`
- `pages/transactions.blade.php`
- `pages/analysis.blade.php`
- `pages/planning.blade.php`
- `pages/profile.blade.php`

---

## Catatan Tambahan

- `Modular monolith` bukan sekedar visual kartu: setiap module harus memiliki context, label, dan action layer sendiri.
- Gunakan `section accent` pada setiap module page untuk menegaskan batas logika.
- Untuk mobile, pertahankan sidebar ringkas dan ubah module cards menjadi stack.
