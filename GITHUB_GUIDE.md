# GitHub Yükleme Rehberi

Bu rehber, **HowwydSheet** projesini GitHub'a yüklemek için gerekli adımları içerir.

## 1. Hazırlık

Aşağıdaki dosyaların projenizde olduğundan emin olun (Ben bunları sizin için hazırladım):

- `LICENSE.md` (Lisans dosyası)
- `README.md` (Proje açıklaması)
- `.gitignore` (Gereksiz dosyaların yüklenmesini engeller)
- `package.json` (Proje bilgileri)

## 2. Git Kurulumu ve Başlatma

Terminali açın (VS Code terminali olabilir) ve proje klasöründe olduğunuzdan emin olun.

1.  Git'i başlatın:

    ```bash
    git init
    ```

2.  Dosyaları ekleyin:

    ```bash
    git add .
    ```

3.  İlk versiyonu kaydedin (commit):
    ```bash
    git commit -m "İlk sürüm: HowwydSheet v1.0.0"
    ```

## 3. GitHub'da Depo (Repository) Oluşturma

1.  [GitHub](https://github.com) hesabınıza giriş yapın.
2.  Sağ üstteki **+** ikonuna tıklayın ve **New repository** seçeneğini seçin.
3.  **Repository name** kısmına `howwydsheet` yazın.
4.  **Description** kısmına (isteğe bağlı): `A powerful and flexible sheet library for web applications.`
5.  **Public** (Herkese açık) veya **Private** (Gizli) seçeneğini belirleyin.
6.  **Initialize this repository with:** kısmındaki kutucukları **İŞARETLEMEYİN** (Çünkü dosyaları biz hazırladık).
7.  **Create repository** butonuna tıklayın.

## 4. Projeyi GitHub'a Gönderme

GitHub'da depo oluşturduktan sonra size verilen komutlardan **"…or push an existing repository from the command line"** başlığı altındakileri kullanacağız.

1.  Uzak sunucuyu (remote) ekleyin (KULLANICI_ADI yerine kendi GitHub kullanıcı adınızı yazın):

    ```bash
    git remote add origin https://github.com/KULLANICI_ADI/howwydsheet.git
    ```

2.  Ana dalı (branch) belirleyin:

    ```bash
    git branch -M main
    ```

3.  Dosyaları yükleyin:
    ```bash
    git push -u origin main
    ```

## 5. Güncelleme Yapma

İleride kodlarda değişiklik yaptığınızda şu adımları izleyin:

1.  Değişiklikleri ekleyin:

    ```bash
    git add .
    ```

2.  Kaydedin:

    ```bash
    git commit -m "Yaptığınız değişikliğin kısa açıklaması"
    ```

3.  Gönderin:
    ```bash
    git push
    ```

---

**Not:** Eğer `git push` sırasında hata alırsanız veya giriş yapmanız istenirse, GitHub kullanıcı adınızı ve şifrenizi (veya Personal Access Token) girin.
