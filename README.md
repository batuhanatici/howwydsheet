# HowwydSheet

**HowwydSheet**, modern web uygulamaları için geliştirilmiş, esnek, hafif ve özelleştirilebilir bir "bottom sheet" (alt sayfa) ve modal kütüphanesidir. **Batuhan ATICI** tarafından **HOWWYD** adına geliştirilmiştir.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Version](https://img.shields.io/badge/version-1.0.0-green.svg)

## Özellikler

- 🚀 **Hafif ve Hızlı:** Gereksiz kod yükü olmadan yüksek performans.
- 🎨 **Tamamen Özelleştirilebilir:** CSS ve JS ile kolayca stil ve davranış değişikliği.
- 📱 **Mobil Uyumlu:** Dokunmatik sürükleme (drag) hareketlerini destekler.
- 🌙 **Karanlık Mod Desteği:** Sistem temasını algılar veya manuel ayarlanabilir.
- 🔒 **Kilitlenebilir Mod:** Kullanıcının kapatmasını engelleyen özel modlar.
- 📜 **Scroll Spy:** İçerik kaydırıldığında başlıkları otomatik izleme.

## Kurulum

Projeyi klonlayın veya indirin:

```bash
git clone https://github.com/batuhanatici/howwydsheet.git
```

Veya NPM üzerinden (Eğer yayınlandıysa):

```bash
npm install howwydsheet
```

## Kullanım

### HTML

```html
<link rel="stylesheet" href="howwydsheet.css" />
<script src="howwydsheet.js"></script>

<div id="mySheet" class="howwyd-sheet">
  <div class="sheet-content">
    <h1>Merhaba Dünya</h1>
    <p>Bu bir HowwydSheet örneğidir.</p>
  </div>
</div>
```

### JavaScript

```javascript
// Sheet'i başlat
const sheet = new HowwydSheet("mySheet");

// Aç
sheet.open();

// Kapat
sheet.close();
```

## Lisans

Bu proje [MIT Lisansı](LICENSE.md) ile lisanslanmıştır.

Copyright (c) 2025 HOWWYD (Created by Batuhan ATICI)
