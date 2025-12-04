# HowwydSheet

**HowwydSheet**, modern web uygulamaları için geliştirilmiş, **Alpine.js tabanlı**, esnek, hafif ve özelleştirilebilir bir "bottom sheet" (alt sayfa) ve modal kütüphanesidir. Mobil öncelikli tasarımı ve yumuşak geçişleri ile native uygulama hissi verir.

**Batuhan ATICI** tarafından **HOWWYD** adına geliştirilmiştir.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Version](https://img.shields.io/badge/version-2.0.0-green.svg)
![Size](https://img.shields.io/badge/size-<5kb-orange.svg)

## Özellikler

- 🚀 **Alpine.js Gücü:** Alpine.js ekosistemiyle tam uyumlu, reaktif yapı.
- 📱 **Mobil Uyumlu:** Dokunmatik sürükleme (drag) hareketlerini ve ivmeyi destekler.
- 🎨 **Tamamen Özelleştirilebilir:** Başlangıç yüksekliği, kilitlenebilirlik ve kırılma noktaları ayarlanabilir.
- 🔒 **Kilitlenebilir Mod:** Kullanıcının kapatmasını engelleyen (persistent) modlar.
- ⚡ **Yüksek Performans:** `requestAnimationFrame` ile optimize edilmiş animasyonlar.
- 🌙 **Karanlık Mod:** Sistem temasını algılar ve uyum sağlar.

## Kurulum

HowwydSheet'i projenize dahil etmenin en hızlı yolu CDN kullanmaktır.

### CDN Bağlantıları

Projenizin `<head>` etiketleri arasına CSS dosyasını, `<body>` kapanış etiketinden hemen önce ise JS dosyalarını ekleyin.

> **Not:** HowwydSheet, çalışmak için **Alpine.js** kütüphanesine ihtiyaç duyar.

```html
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.howwyd.com/sheet/v2/index.css" />

<!-- JS (Alpine.js ve HowwydSheet) -->
<script
  defer
  src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
></script>
<script src="https://cdn.howwyd.com/sheet/v2/index.js"></script>
```

## Kullanım

HowwydSheet, Alpine.js'in `x-data` direktifi ile başlatılır. Aşağıda temel bir kullanım örneği verilmiştir.

### Temel Yapı

```html
<!-- Sheet Kontrolcüsü (Dışarıdan açmak için) -->
<!-- Not: Genellikle global bir store veya event ile tetiklenir, ancak burada scope içinde gösterilmiştir. -->
<div x-data="{ sheetOpen: false }">
  <button @click="$dispatch('open-sheet')">Sheet'i Aç</button>

  <!-- HowwydSheet Bileşeni -->
  <div
    x-data="howwydSheet({ initialSize: '50%' })"
    @open-sheet.window="show()"
    class="howwyd-sheet-wrapper"
  >
    <!-- Arka Plan (Overlay) -->
    <div
      x-show="isVisible"
      x-transition.opacity
      @click="hide()"
      class="sheet-overlay"
    ></div>

    <!-- Sheet İçeriği -->
    <div
      x-show="isVisible"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="translate-y-full"
      x-transition:enter-end="translate-y-0"
      x-transition:leave="transition ease-in duration-300"
      x-transition:leave-start="translate-y-0"
      x-transition:leave-end="translate-y-full"
      :style="sheetStyle"
      class="sheet-container"
    >
      <!-- Sürükleme Kolu (Handle) -->
      <div
        class="sheet-header"
        @touchstart="startDrag"
        @touchmove.window="onDrag"
        @touchend.window="endDrag"
      >
        <div class="sheet-handle"></div>
      </div>

      <!-- İçerik -->
      <div class="sheet-content">
        <h2>Merhaba Dünya</h2>
        <p>Bu, Alpine.js ile güçlendirilmiş bir HowwydSheet örneğidir.</p>
        <button @click="hide()">Kapat</button>
      </div>
    </div>
  </div>
</div>
```

## Konfigürasyon Seçenekleri

`howwydSheet` fonksiyonuna bir obje olarak aşağıdaki ayarları geçebilirsiniz:

| Seçenek            | Tip                  | Varsayılan                      | Açıklama                                                            |
| ------------------ | -------------------- | ------------------------------- | ------------------------------------------------------------------- |
| `initialSize`      | `string` \| `number` | `'50%'`                         | Sheet açıldığında kaplayacağı yükseklik (`%` veya `px`).            |
| `minSize`          | `string` \| `number` | `'25%'`                         | Minimum küçülme boyutu.                                             |
| `maxSize`          | `string` \| `number` | `'100%'`                        | Maksimum büyüme boyutu.                                             |
| `lockable`         | `boolean`            | `false`                         | `true` ise kullanıcı sürükleyerek veya dışarı tıklayarak kapatamaz. |
| `fullscreenOnInit` | `boolean`            | `false`                         | `true` ise açıldığında doğrudan tam ekran olur.                     |
| `breakpoints`      | `object`             | `{ min: 25, mid: 50, max: 75 }` | Sürükleme bırakıldığında yapışacağı (snap) noktalar.                |

### Örnek Konfigürasyon

```html
<div
  x-data="howwydSheet({ 
    initialSize: '60%', 
    lockable: true, 
    breakpoints: { min: 30, mid: 60, max: 90 } 
})"
>
  ...
</div>
```

## Metodlar ve Değişkenler

Bileşen scope'u içinde kullanabileceğiniz özellikler:

- **`show()`**: Sheet'i açar.
- **`hide(force = false)`**: Sheet'i kapatır. `lockable` true ise `force` parametresi `true` olmalıdır.
- **`toggle()`**: Açık/Kapalı durumunu değiştirir.
- **`isVisible`**: Sheet'in görünürlük durumu (boolean).
- **`isFull`**: Sheet'in tam ekran olup olmadığı (boolean).

## Geliştirme ve Katkı

Projeyi yerel ortamınızda geliştirmek için:

1.  Depoyu klonlayın:
    ```bash
    git clone https://github.com/batuhanatici/howwydsheet.git
    ```
2.  Bağımlılıkları yükleyin:
    ```bash
    npm install
    ```
3.  Geliştirme sunucusunu başlatın (Tailwind vb. için):
    ```bash
    npm run dev
    ```

## Lisans

Bu proje [MIT Lisansı](LICENSE.md) ile lisanslanmıştır.

Copyright (c) 2025 HOWWYD (Created by Batuhan ATICI)
