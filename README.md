# Hyper Teknoloji Backend – Teknik Değerlendirme Uygulaması

Bu proje, Hyper Teknoloji tarafından gönderilen teknik değerlendirme görevi kapsamında geliştirilmiş basit bir ürün listeleme ve sepet yönetimi uygulamasıdır.

Backend tarafı **Laravel**, frontend tarafı **React + Vite** kullanılarak geliştirilmiştir.

---

## 🚀 Kurulum ve Çalıştırma

### 1. Repository'yi klonlayın

```bash
git clone https://github.com/tamererdogan/hyperteknoloji-backend
```

### 2. Proje dizinine geçin

```bash
cd hyperteknoloji-backend
```

### 3. .env dosyasını oluşturun

```bash
.env.example dosyasının kopyasını .env adında oluşturun yada .env.example dosyasının ismini .env olarak değiştirin.
```

### 4. .env değişkenlerini düzenleyin

```bash
- HYPER_API_BASE_URL değerine Hyper Teknoloji API’sinin ana URL bilgisi girilmelidir.
- HYPER_API_TOKEN değerine Hyper Teknoloji API’sine erişim için kullanılan Bearer Token girilmelidir.
- HYPER_API_CACHE_TTL değerini Hyper Teknoloji API’den gelen ürün verilerinin backend tarafında kaç saniye boyunca cache’te tutulacağını belirler. Performans artırmak ve gereksiz API çağrılarını azaltmak için istenen değere getirilebilir.

NOT: SESSION_DRIVER=database ve CACHE_STORE=database değerleri için veritabanı bağlantısı gerekmektedir. Veritabanı bağlantısı ile uğraşmak istenmez ise SESSION_DRIVER=file ve CACHE_STORE=file şeklinde düzenlenebilir.

Örnek:
SESSION_DRIVER=file
CACHE_STORE=file
HYPER_API_BASE_URL=https://api.hyperteknoloji.com.tr
HYPER_API_TOKEN=bearer-token-here
HYPER_API_CACHE_TTL=3600
```

### 5. App key oluşturun

```bash
php artisan key:generate
```

### 6. Proje bağımlılıklarını indirin

```bash
composer install
```

### 7. Projeyi başlatın

```bash
php artisan serve
```

Uygulama varsayılan olarak http://localhost:8000 adresinde çalışır.

## 📌 Cache Stratejisi

- Cache stratejisi olarak time-based bir yaklaşım yürütülmüştür.
- Ürün listeleme endpoint'i sayfa bazlı olarak cache'lenmiştir.
- Cache key formatı:

  ```bash
  hyper_products_page_{$page}_per_{$perPage}
  ```

- Cache süresi .env üzerinden ayarlanabilirdir.
- Cache mekanizması olarak Cache::remember() kullanılmıştır.
- Cache invalidation kısmında ise API'den alınan veriler belirtilen süre boyunca değişmeyeceği yada değişse bile kritik önem arz etmeyeceği varsayılmıştır.
- Gelişmiş bir invalidation için Hyper Teknoloji API tarafından sistemimize gelecek ürün güncelleme/silme eventleri oluşturulup belirli page cache’leri temizlenebilir.
