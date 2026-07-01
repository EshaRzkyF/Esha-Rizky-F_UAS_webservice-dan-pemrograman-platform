# Contributing to FinTrack

Terima kasih atas minat Anda untuk berkontribusi pada FinTrack! Dokumentasi ini menjelaskan cara berkontribusi dengan cara yang paling bermanfaat dan sesuai dengan standar proyek.

## 📋 Code of Conduct

Proyek ini mematuhi Code of Conduct yang ramah untuk semua kontributor. Dengan berpartisipasi, Anda diharapkan mematuhi standar ini.

## 🐛 Melaporkan Bug

Sebelum membuat bug report, periksa issue list karena Anda mungkin menemukan bug yang sudah dilaporkan. Jika Anda menemukan bug yang belum dilaporkan:

1. **Gunakan judul yang deskriptif**
2. **Berikan deskripsi jelas** tentang apa yang tidak berfungsi
3. **Sertakan contoh spesifik** untuk mendemonstrasikan langkah-langkahnya
4. **Jelaskan perilaku yang Anda lihat** dan **hasil yang Anda harapkan**
5. **Sertakan screenshot** jika relevan
6. **Cantumkan environment** (OS, PHP version, Laravel version, etc.)

## ✨ Mengusulkan Enhancement

Enhancement suggestions juga diterima dengan baik! Untuk menyarankan enhancement:

1. **Gunakan judul yang jelas dan deskriptif**
2. **Berikan deskripsi detail** dari saran yang diusulkan
3. **Berikan contoh spesifik** tentang cara menjadi lebih baik
4. **Jelaskan mengapa enhancement ini akan berguna**
5. **Sebutkan alternatif** yang Anda pertimbangkan

## 🔧 Pull Request Process

1. **Fork** repository dan buat branch dari `main`
   ```bash
   git checkout -b feature/AmazingFeature
   ```

2. **Buat commit yang jelas dan deskriptif**
   ```bash
   git commit -m 'Add: Deskripsi feature yang jelas'
   ```

3. **Push** ke branch Anda
   ```bash
   git push origin feature/AmazingFeature
   ```

4. **Buka Pull Request** dengan:
   - Deskripsi jelas tentang perubahan
   - Link ke issue yang relevan (jika ada)
   - Screenshot untuk UI changes
   - Hasil test lokal

5. **Review Process**:
   - Code review oleh maintainer
   - Mungkin ada komentar untuk perbaikan
   - Setelah approve, PR akan di-merge

## 📝 Coding Standards

### PHP/Laravel
- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard
- Gunakan meaningful variable names
- Tambahkan PHPDoc comments untuk methods
- Implement type hints
- Maksimal 120 characters per line

Contoh:
```php
/**
 * Calculate total income untuk user
 *
 * @param int $userId
 * @return decimal
 */
public function calculateTotalIncome(int $userId): float
{
    return Transaction::where('user_id', $userId)
        ->where('type', 'income')
        ->sum('amount');
}
```

### JavaScript/Vue
- Follow [Airbnb JavaScript Style Guide](https://github.com/airbnb/javascript)
- Gunakan kebab-case untuk filenames
- Gunakan camelCase untuk variables dan functions
- Tambahkan JSDoc untuk reusable functions

### Database Migrations
- Gunakan descriptive migration names
- Setiap migration hanya untuk satu task
- Selalu sertakan rollback migration

## 🧪 Testing Requirements

Untuk contribution acceptance:
1. **Tulis tests** untuk fitur baru
2. **Update existing tests** jika ada changes
3. **Ensure all tests pass** sebelum PR
   ```bash
   composer test
   ```

## 📚 Documentation

Jika Anda menambahkan fitur baru:
1. **Update README.md** jika relevan
2. **Tambahkan API documentation** untuk endpoints baru
3. **Update CHANGELOG** dengan changes
4. **Sertakan inline comments** untuk logic kompleks

## 🎯 Development Workflow

```bash
# Setup environment
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate

# Start development
composer dev

# Run tests
composer test

# Create feature
git checkout -b feature/my-feature
# ... make changes ...
git commit -m 'Add: my feature'
git push origin feature/my-feature

# Submit PR on GitHub
```

## ✅ Checklist sebelum Submit PR

- [ ] Code follows style guidelines
- [ ] Telah menjalankan `composer test` dengan sukses
- [ ] Menambahkan tests untuk fitur baru
- [ ] Dokumentasi sudah diupdate
- [ ] Git history clean dan meaningful
- [ ] Tidak ada merge conflicts
- [ ] PR description jelas dan detail

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vue.js Documentation](https://vuejs.org/guide/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [PHPUnit Testing](https://phpunit.de/)

## 📞 Contact

- **Issues**: [GitHub Issues](https://github.com/yourusername/uas/issues)
- **Email**: support@fintrack.dev
- **Discussion**: [GitHub Discussions](https://github.com/yourusername/uas/discussions)

---

**Setiap contribution, sekecil apapun, sangat dihargai! 💚**
