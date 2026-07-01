# FinTrack Security Policy

## Reporting Security Vulnerabilities

Keamanan adalah prioritas utama kami. Jika Anda menemukan vulnerability, **jangan buka public issue**. 

Silakan laporkan ke **security@fintrack.dev** dengan:
- Deskripsi vulnerability
- Steps untuk mereproduksi
- Potential impact
- Suggested fix (jika ada)

Kami akan merespons dalam **48 jam** dan bekerja dengan Anda untuk menyelesaikan issue.

## Supported Versions

Kami menyediakan security updates untuk:
- **Latest minor version** - Full support
- **Previous minor versions** - Critical fixes only
- **Older versions** - No support

| Version | Status |
|---------|--------|
| 1.0.x   | ✅ Supported |
| 0.9.x   | ⚠️ Critical only |
| < 0.9   | ❌ Not supported |

## Dependencies

Kami secara rutin mengupdate dependencies untuk security patches. Jika Anda menemukan CVE:

1. Update dependencies: `composer update`
2. Report issue jika tidak ter-patch

## Best Practices

Untuk users, pastikan:
- [ ] Gunakan HTTPS di production
- [ ] Keep `.env` file private (di `.gitignore`)
- [ ] Update PHP/Laravel secara regular
- [ ] Gunakan strong passwords
- [ ] Enable 2FA jika available
- [ ] Rotate API keys regularly

## Disclosure Timeline

- **Day 1**: Report received, initial assessment
- **Day 3**: Confirmation dan timeline fix
- **Day 7**: Security patch released (biasanya)
- **Day 14**: Public disclosure (setelah patch release)

---

**Terima kasih atas membantu kami menjaga FinTrack tetap aman! 🔒**
