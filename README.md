# LEAFGUARD-TOMATO 🍅🔍

**Sistem Klasifikasi Otomatis Penyakit Daun Tomat Menggunakan Deep Learning untuk Mendukung Petani Tomat di Indonesia**

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![TensorFlow](https://img.shields.io/badge/TensorFlow-2.x-orange.svg)](https://tensorflow.org/)
[![Laravel](https://img.shields.io/badge/Laravel-11-red.svg)](https://laravel.com/)
[![Python](https://img.shields.io/badge/Python-3.8+-blue.svg)](https://python.org/)

## 📋 Daftar Isi
- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Dataset](#-dataset)
- [Instalasi](#-instalasi)
- [Penggunaan](#-penggunaan)
- [API Endpoints](#-api-endpoints)
- [Model Machine Learning](#-model-machine-learning)
- [Deployment](#-deployment)
- [Kontributor](#-kontributor)
- [Lisensi](#-lisensi)

## 🌟 Tentang Proyek

LEAFGUARD-TOMATO adalah solusi teknologi inovatif yang dirancang untuk membantu petani tomat di Indonesia mengidentifikasi penyakit pada daun tomat secara cepat dan akurat. Sistem ini menggunakan teknologi deep learning dengan arsitektur Convolutional Neural Network (CNN) untuk mengklasifikasikan 11 jenis penyakit dan kondisi daun sehat.

### 🎯 Latar Belakang Masalah
- Kerugian hasil panen tomat mencapai **40-60%** akibat penyakit tanaman (Kementerian Pertanian, 2023)
- Keterlambatan identifikasi penyakit menjadi masalah utama petani
- Keterbatasan akses ke penyuluh pertanian di daerah terpencil
- Diagnosis manual memerlukan keahlian khusus yang tidak semua petani miliki

### 🚀 Solusi yang Ditawarkan
- **Diagnosis Cepat**: Identifikasi penyakit dalam hitungan detik
- **Akurasi Tinggi**: Model dengan akurasi >90% pada kondisi optimal
- **Mudah Digunakan**: Antarmuka web responsif yang intuitif
- **Rekomendasi Praktis**: Saran penanganan spesifik untuk setiap penyakit
- **Aksesibilitas**: Dapat diakses melalui perangkat mobile

## ✨ Fitur Utama

### 1. 🔬 Modul Klasifikasi Penyakit
Mengidentifikasi 11 kategori kondisi daun tomat:
- **Early Blight** (*Alternaria solani*)
- **Late Blight** (*Phytophthora infestans*)
- **Leaf Mold** (*Fulvia fulva*)
- **Bacterial Spot** (*Xanthomonas spp.*)
- **Septoria Leaf Spot** (*Septoria lycopersici*)
- **Tomato Yellow Leaf Curl Virus**
- **Target Spot** (*Corynespora cassiicola*)
- **Tomato Mosaic Virus**
- **Spider Mites** (*Tetranychus urticae*)
- **Powdery Mildew** (*Leveillula taurica*)
- **Healthy** (Daun Sehat)

### 2. 📸 Sistem Upload Gambar
- Panduan visual untuk pengambilan foto optimal
- Dukungan format: JPG, PNG, WEBP
- Validasi kualitas gambar otomatis
- Preview real-time sebelum analisis

### 3. 🔧 Preprocessing Adaptif
- Normalisasi kontras dan brightness otomatis
- Perbaikan kualitas gambar dengan noise
- Optimasi untuk berbagai kondisi pencahayaan
- Resize dan normalisasi standar

### 4. 📊 Hasil Klasifikasi Visual
- Tampilan persentase keyakinan diagnosis
- Heatmap area terinfeksi pada daun
- Informasi detail tentang penyakit
- Visualisasi yang mudah dipahami

### 5. 💡 Rekomendasi Penanganan
- Saran spesifik untuk setiap jenis penyakit
- Rekomendasi pestisida organik/kimia
- Metode aplikasi dan dosis yang tepat
- Tindakan pencegahan berkelanjutan

### 6. 📚 Data Penyakit Komprehensif
- Informasi lengkap setiap penyakit
- Gejala dan tanda-tanda visual
- Gambar referensi berkualitas tinggi
- Faktor risiko dan cara pencegahan

### 7. 📝 Sistem Riwayat
- Penyimpanan hasil klasifikasi sebelumnya
- Tracking perkembangan kondisi tanaman
- Export data untuk dokumentasi
- Filter berdasarkan tanggal dan jenis penyakit

### 8. 📖 Panduan Penggunaan
- Tutorial interaktif step-by-step
- Tips pengambilan foto yang baik
- FAQ dan troubleshooting
- Video tutorial penggunaan

## 🛠 Teknologi yang Digunakan

### Machine Learning
- **TensorFlow 2.x** - Framework deep learning utama
- **Python 3.8+** - Bahasa pemrograman
- **NumPy** - Operasi matematika dan array
- **Pandas** - Manajemen dan analisis data
- **OpenCV** - Preprocessing gambar lanjutan
- **Pillow** - Manipulasi gambar dasar
- **Matplotlib** - Visualisasi training dan evaluasi
- **Flask** - API backend untuk model serving

### Frontend & Backend
- **Laravel 11** - Framework PHP untuk frontend dan backend
- **MySQL 8.0** - Database relasional
- **HTML5/CSS3** - Markup dan styling
- **JavaScript** - Interaktivitas frontend
- **Bootstrap/Tailwind** - Framework CSS responsif

### Deployment & DevOps
- **Docker** - Containerization
- **Railway** - Platform deployment aplikasi web
- **Hugging Face** - Hosting model machine learning
- **Git & GitHub** - Version control dan kolaborasi
- **Nginx** - Web server (production)

## 🏗 Arsitektur Sistem

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │   Backend       │    │   ML Model      │
│   (Laravel)     │◄──►│   (Laravel)     │◄──►│   (Flask API)   │
│                 │    │                 │    │                 │
│ • Upload UI     │    │ • RESTful API   │    │ • CNN Model     │
│ • Results View  │    │ • File Storage  │    │ • Preprocessing │
│ • History       │    │ • Database      │    │ • Inference     │
│ • Guides        │    │ • Authentication│    │ • Postprocess   │
└─────────────────┘    └─────────────────┘    └─────────────────┘
        │                       │                       │
        │              ┌─────────────────┐              │
        └──────────────►│    Database     │◄─────────────┘
                       │    (MySQL)      │
                       │                 │
                       │ • Users         │
                       │ • Classifications│
                       │ • Disease Info  │
                       │ • History       │
                       └─────────────────┘
```

## 📊 Dataset

### PlantVillage Dataset
- **Sumber**: [Kaggle PlantVillage Dataset](https://www.kaggle.com/datasets/arjuntejaswi/plant-village)
- **Total Gambar**: 54,000+ gambar berlabel
- **Kategori Tomat**: 11 kelas (10 penyakit + 1 sehat)
- **Resolusi**: Berbagai resolusi, dinormalisasi ke 224x224 px
- **Format**: JPG/JPEG

### Preprocessing Pipeline
1. **Resize**: Normalisasi ke 224x224 pixels
2. **Normalization**: Pixel values scaled ke [0,1]
3. **Augmentation**: 
   - Random rotation (±15°)
   - Random flip horizontal/vertical
   - Random brightness (±0.2)
   - Random zoom (±0.1)
4. **Split**: 70% training, 20% validation, 10% testing

## 🚀 Instalasi

### Prerequisites
- Python 3.8+
- PHP 8.1+
- Composer
- Node.js & npm
- MySQL 8.0+
- Docker (opsional)

### 1. Clone Repository
```bash
git clone https://github.com/your-team/leafguard-tomato.git
cd leafguard-tomato
```

### 2. Setup Backend (Laravel)
```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=leafguard_tomato
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate --seed

# Storage link
php artisan storage:link
```

### 3. Setup ML Model API
```bash
cd ml-api
pip install -r requirements.txt

# Setup environment variables
cp .env.example .env
# Configure FLASK_APP, MODEL_PATH, etc.

# Run Flask API
python app.py
```

### 4. Run Application
```bash
# Laravel development server
php artisan serve

# ML API (di terminal terpisah)
cd ml-api && python app.py
```

### 5. Docker Setup (Alternatif)
```bash
# Build dan run dengan Docker Compose
docker-compose up --build

# Access aplikasi di http://localhost:8000
```

## 💻 Penggunaan

### 1. Upload Gambar
1. Buka aplikasi di browser
2. Klik tombol "Upload Gambar" 
3. Pilih foto daun tomat (JPG/PNG/WEBP)
4. Ikuti panduan pengambilan foto yang optimal
5. Klik "Analisis Gambar"

### 2. Melihat Hasil
1. Tunggu proses klasifikasi (2-5 detik)
2. Lihat hasil diagnosis dengan persentase keyakinan
3. Baca informasi detail penyakit
4. Ikuti rekomendasi penanganan yang diberikan

### 3. Mengelola Riwayat
1. Akses menu "Riwayat"
2. Lihat semua klasifikasi sebelumnya
3. Filter berdasarkan tanggal atau jenis penyakit
4. Export data untuk dokumentasi

## 🔌 API Endpoints

### Authentication
```
POST /api/register          # Registrasi user baru
POST /api/login             # Login user
POST /api/logout            # Logout user
GET  /api/user              # Info user yang login
```

### Image Classification
```
POST /api/classify          # Upload dan klasifikasi gambar
GET  /api/classifications   # Riwayat klasifikasi user
GET  /api/classify/{id}     # Detail klasifikasi spesifik
DELETE /api/classify/{id}   # Hapus klasifikasi
```

### Disease Information
```
GET /api/diseases           # List semua penyakit
GET /api/diseases/{id}      # Detail penyakit spesifik
GET /api/diseases/{id}/treatment # Rekomendasi penanganan
```

### Example Request
```bash
curl -X POST http://localhost:8000/api/classify \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "image=@path/to/tomato_leaf.jpg" \
  -F "description=Daun tomat di kebun"
```

### Example Response
```json
{
  "status": "success",
  "data": {
    "id": 123,
    "prediction": "Early Blight",
    "confidence": 0.94,
    "description": "Daun tomat di kebun",
    "image_url": "/storage/images/123.jpg",
    "disease_info": {
      "name": "Early Blight",
      "scientific_name": "Alternaria solani",
      "symptoms": "Brown spots with concentric rings...",
      "treatment": "Apply fungicide..."
    },
    "created_at": "2025-06-11T10:30:00Z"
  }
}
```

## 🤖 Model Machine Learning

### Arsitektur CNN
```python
Model: "tomato_disease_classifier"
_________________________________________________________________
Layer (type)                 Output Shape              Param #   
=================================================================
conv2d (Conv2D)             (None, 222, 222, 32)     896       
max_pooling2d (MaxPooling2D) (None, 111, 111, 32)     0         
conv2d_1 (Conv2D)           (None, 109, 109, 64)     18496     
max_pooling2d_1 (MaxPooling2D) (None, 54, 54, 64)     0         
conv2d_2 (Conv2D)           (None, 52, 52, 128)      73856     
max_pooling2d_2 (MaxPooling2D) (None, 26, 26, 128)    0         
flatten (Flatten)           (None, 86528)             0         
dense (Dense)               (None, 512)               44302848  
dropout (Dropout)           (None, 512)               0         
dense_1 (Dense)             (None, 11)                5643      
=================================================================
Total params: 44,401,739
Trainable params: 44,401,739
Non-trainable params: 0
```

### Training Configuration
- **Optimizer**: Adam (lr=0.001)
- **Loss Function**: Categorical Crossentropy
- **Metrics**: Accuracy, Precision, Recall
- **Epochs**: 50 dengan Early Stopping
- **Batch Size**: 32
- **Validation Split**: 20%

### Performance Metrics
- **Overall Accuracy**: 94.2%
- **Precision (avg)**: 93.8%
- **Recall (avg)**: 94.1%
- **F1-Score (avg)**: 93.9%
- **Model Size**: 45.2 MB
- **Inference Time**: ~2 seconds

### Confusion Matrix (Top Classes)
```
                 Predicted
Actual    EB   LB   LM   BS   Healthy
EB        92   2    1    0    5
LB        1    94   3    1    1  
LM        0    2    96   1    1
BS        1    0    2    95   2
Healthy   3    1    0    1    95
```

## 🚀 Deployment

### Local Development
```bash
# 1. Clone dan setup project
git clone https://github.com/your-team/leafguard-tomato.git
cd leafguard-tomato

# 2. Install dependencies
composer install && npm install
pip install -r ml-api/requirements.txt

# 3. Setup database dan environment
cp .env.example .env
php artisan migrate --seed

# 4. Run services
php artisan serve          # Port 8000
cd ml-api && python app.py # Port 5000
```

### Production (Railway + Hugging Face)

#### 1. Deploy Web App ke Railway
```bash
# 1. Install Railway CLI
npm install -g @railway/cli

# 2. Login dan deploy
railway login
railway init
railway up

# 3. Set environment variables di Railway dashboard
```

#### 2. Deploy ML Model ke Hugging Face
```bash
# 1. Install HF CLI
pip install huggingface_hub

# 2. Login ke Hugging Face
huggingface-cli login

# 3. Upload model
from huggingface_hub import upload_file

upload_file(
    path_or_fileobj="model/tomato_classifier.h5",
    path_in_repo="model.h5",
    repo_id="your-username/leafguard-tomato-model",
    repo_type="model"
)
```

#### 3. Environment Variables
```env
# Laravel App
APP_NAME="LEAFGUARD-TOMATO"
APP_ENV=production
APP_URL=https://your-app.railway.app

# Database
DATABASE_URL=mysql://user:pass@host:port/db

# ML API
ML_API_URL=https://huggingface.co/your-username/leafguard-tomato-model
HF_TOKEN=your_huggingface_token

# Storage
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
```

### Docker Deployment
```dockerfile
# Dockerfile
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application
COPY . /app
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
```

```yaml
# docker-compose.yml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    environment:
      - DB_HOST=db
      - ML_API_URL=http://ml-api:5000
    depends_on:
      - db
      - ml-api
    
  db:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: leafguard_tomato
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - mysql_data:/var/lib/mysql
    
  ml-api:
    build: ./ml-api
    ports:
      - "5000:5000"
    environment:
      - MODEL_PATH=/app/model/tomato_classifier.h5

volumes:
  mysql_data:
```

## 👥 Kontributor

### Tim CC25-CF276

#### Machine Learning Team
- **Christofel A Simbolon** (MC319D5Y2058) - Universitas Sumatera Utara
  - Model Development & Training
  - Data Preprocessing & Augmentation
  - Model Optimization & Deployment

- **Henry Dwi Prana Sitepu** (MC319D5Y2229) - Universitas Sumatera Utara  
  - CNN Architecture Design
  - Performance Evaluation
  - Flask API Development

- **Andika Syarif Hidayatullah** (MC747D5Y0795) - Universitas Muhammadiyah Banjarmasin
  - Dataset Management
  - Model Testing & Validation
  - Integration with Web API

#### Frontend & Backend Team
- **Muhammad Ihsan** (FC747D5Y1120) - Universitas Muhammadiyah Banjarmasin
  - Laravel Backend Development
  - Database Design & Management
  - API Development

- **Yusuf Alfarabi Natawiyanta** (FC747D5Y1729) - Universitas Muhammadiyah Banjarmasin
  - Frontend Development
  - UI/UX Implementation  
  - Responsive Design

- **Anwar** (FC747D5Y1626) - Universitas Muhammadiyah Banjarmasin
  - System Integration
  - Testing & Quality Assurance
  - Deployment & DevOps

### Advisor
- **Muhammad Rafi Sudrajat** (MC25-152) - Bangkit Academy Mentor

## 📞 Kontak & Support

### Repository & Demo
- **GitHub**: [https://github.com/your-team/leafguard-tomato](https://github.com/your-team/leafguard-tomato)
- **Live Demo**: [https://leafguard-tomato.railway.app](https://leafguard-tomato.railway.app)
- **API Documentation**: [https://leafguard-tomato.railway.app/docs](https://leafguard-tomato.railway.app/docs)

### Tim Support
- **Email**: leafguard.tomato@gmail.com
- **WhatsApp**: +62 812-3456-7890 (Muhammad Ihsan)
- **Discord**: LeafGuard Team#1234

### Bug Reports & Feature Requests
Silakan buat issue di [GitHub Issues](https://github.com/your-team/leafguard-tomato/issues) dengan template:
- **Bug Report**: Deskripsi bug, langkah reproduksi, environment
- **Feature Request**: Deskripsi fitur, use case, mockup (jika ada)

## 📜 Lisensi

Proyek ini dilisensikan under [MIT License](LICENSE).

```
MIT License

Copyright (c) 2025 LEAFGUARD-TOMATO Team

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## 🙏 Acknowledgments

- **PlantVillage Dataset** - Dataset training utama dari Kaggle
- **Bangkit Academy 2025** - Program yang memfasilitasi pengembangan proyek
- **Kementerian Pertanian RI** - Data statistik produksi tomat Indonesia
- **Petani Lokal Kalimantan Selatan** - Insights dan feedback untuk pengembangan
- **TensorFlow Team** - Framework machine learning yang powerful
- **Laravel Community** - Framework web development yang robust

---

**LEAFGUARD-TOMATO** - *Melindungi Tanaman, Meningkatkan Hasil Panen* 🍅🛡️

*Dibuat dengan ❤️ oleh Tim CC25-CF276 untuk petani Indonesia*
