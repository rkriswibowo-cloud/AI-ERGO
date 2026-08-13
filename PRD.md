# PRODUCT REQUIREMENTS DOCUMENT (PRD)

# AI-ERGO

## AI-Assisted Ergonomic Risk Assessment System Using Nordic Body Map and Large Language Models for Personalized Workplace Recommendations

**Version:** 1.0
**Document Status:** Final Draft
**Platform:** Web Application
**Architecture:** PHP Native + MySQL + Bootstrap 5 + Gemini API/Groq API
**Target Publication:** SINTA 2-4 / International Conference / Scopus Q3-Q4

---

# 1. EXECUTIVE SUMMARY

AI-ERGO adalah sistem informasi berbasis web yang dirancang untuk melakukan penilaian risiko ergonomi pekerja menggunakan metode Nordic Body Map (NBM) serta menghasilkan rekomendasi perbaikan ergonomi yang dipersonalisasi dengan bantuan Large Language Model (LLM).

Sistem ini membantu organisasi, perusahaan, institusi pendidikan, rumah sakit, dan peneliti dalam mengidentifikasi risiko Musculoskeletal Disorders (MSDs), memonitor kondisi ergonomi pekerja, dan memberikan rekomendasi yang lebih kontekstual berdasarkan karakteristik individu dan pekerjaan.

---

# 2. LATAR BELAKANG

Keluhan Musculoskeletal Disorders (MSDs) merupakan salah satu penyebab utama penurunan produktivitas dan gangguan kesehatan kerja. Metode Nordic Body Map banyak digunakan untuk mengidentifikasi keluhan pada bagian tubuh pekerja, namun hasilnya umumnya hanya berupa skor yang memerlukan interpretasi pakar ergonomi.

Permasalahan yang sering ditemukan:

* Assessment masih dilakukan secara manual.
* Rekapitulasi membutuhkan waktu lama.
* Tidak tersedia rekomendasi otomatis.
* Interpretasi membutuhkan tenaga ahli ergonomi.
* Sulit melakukan monitoring risiko secara berkala.
* Tidak ada sistem pendukung keputusan yang terintegrasi.

AI-ERGO hadir untuk mengotomatisasi proses assessment, analisis, pelaporan, dan pemberian rekomendasi ergonomi menggunakan teknologi Artificial Intelligence.

---

# 3. TUJUAN PRODUK

## Tujuan Utama

Membangun sistem yang mampu:

1. Melakukan assessment risiko ergonomi secara digital.
2. Menghitung skor Nordic Body Map secara otomatis.
3. Mengidentifikasi area tubuh dengan risiko tertinggi.
4. Menyediakan dashboard analitik ergonomi.
5. Menghasilkan rekomendasi ergonomi berbasis AI.
6. Menyediakan laporan yang mudah dipahami oleh manajemen.

## Tujuan Penelitian

1. Mengintegrasikan Nordic Body Map dengan Large Language Model.
2. Mengembangkan framework rekomendasi ergonomi berbasis AI.
3. Mengukur tingkat kesesuaian rekomendasi AI dengan pakar ergonomi.
4. Mengukur usability sistem menggunakan SUS (System Usability Scale).

---

# 4. TARGET PENGGUNA

## Primary Users

### Pekerja

Melakukan self-assessment kondisi ergonomi.

### Tim K3

Melakukan monitoring kesehatan kerja.

### HRD

Memantau kondisi pekerja dan risiko ergonomi.

### Ergonomist

Melakukan validasi hasil assessment dan rekomendasi.

---

## Secondary Users

### Peneliti

Menggunakan data assessment untuk penelitian.

### Manajemen

Mengambil keputusan berdasarkan laporan ergonomi.

---

# 5. RUANG LINGKUP SISTEM

## In Scope (Versi 1.0)

### Assessment Ergonomi

* Nordic Body Map
* Penilaian risiko otomatis
* Riwayat assessment

### AI Recommendation

* Integrasi Gemini API
* Integrasi Groq API
* Personalized recommendation

### Dashboard

* Monitoring risiko
* Statistik ergonomi
* Grafik keluhan tubuh

### Reporting

* PDF
* Excel
* Grafik

### User Management

* Multi Role
* Multi User
* Role Permission

### Multi Organization

* Multi perusahaan
* Multi instansi
* Multi fakultas/departemen

---

## Out of Scope (Versi 1.0)

* Mobile App
* Computer Vision
* Pose Detection
* IoT Sensor
* Wearable Device
* RULA
* REBA

---

# 6. ROLE DAN HAK AKSES

## 6.1 Super Admin

Hak akses tertinggi.

### Fitur

* Kelola seluruh pengguna
* Kelola role
* Kelola permission
* Kelola perusahaan
* Kelola departemen
* Kelola master data
* Kelola kategori risiko
* Kelola AI Prompt
* Kelola API Key
* Kelola konfigurasi sistem
* Monitoring seluruh assessment
* Melihat seluruh laporan
* Audit log
* Backup database
* Restore database

### Scope Data

Semua data sistem.

---

## 6.2 Admin Organisasi / Admin K3

### Fitur

* Kelola pekerja
* Kelola assessment
* Kelola laporan
* Monitoring risiko
* Generate rekomendasi AI
* Export PDF
* Export Excel

### Scope Data

Data organisasi sendiri.

---

## 6.3 HRD

### Fitur

* Monitoring pekerja
* Melihat hasil assessment
* Dashboard statistik
* Export laporan

### Scope Data

Data organisasi sendiri.

---

## 6.4 Ergonomist / Assessor

### Fitur

* Melakukan assessment
* Validasi hasil AI
* Menambahkan rekomendasi manual
* Melihat histori assessment

### Scope Data

Assessment yang ditugaskan.

---

## 6.5 Pekerja

### Fitur

* Mengisi assessment
* Melihat hasil assessment
* Melihat rekomendasi AI
* Melihat histori pribadi

### Scope Data

Data pribadi.

---

# 7. MODUL SISTEM

## 7.1 Dashboard

### KPI Cards

* Total Organisasi
* Total Pekerja
* Total Assessment
* Risiko Rendah
* Risiko Sedang
* Risiko Tinggi
* Risiko Sangat Tinggi

### Visualisasi

* Pie Chart Risiko
* Bar Chart Keluhan Tubuh
* Trend Assessment Bulanan
* Trend Risiko Tahunan

---

## 7.2 Master Data

### Companies

* Nama Organisasi
* Alamat
* Kontak

### Departments

* Nama Departemen
* Kode

### Positions

* Nama Jabatan

### Employees

* NIK/NIP
* Nama
* Jenis Kelamin
* Umur
* Tinggi Badan
* Berat Badan
* Masa Kerja
* Departemen
* Jabatan

---

## 7.3 Assessment Ergonomi

### Informasi Pekerjaan

* Jenis Pekerjaan
* Lama Duduk
* Lama Berdiri
* Lama Penggunaan Komputer
* Shift Kerja
* Durasi Kerja Harian

### Nordic Body Map

Jumlah pertanyaan:

* 28 bagian tubuh

Skala:

| Nilai | Keterangan   |
| ----- | ------------ |
| 0     | Tidak Sakit  |
| 1     | Agak Sakit   |
| 2     | Sakit        |
| 3     | Sangat Sakit |

Output:

* Total skor
* Tingkat risiko
* Area tubuh dominan

---

## 7.4 Risk Scoring Engine

### Perhitungan

Total seluruh skor NBM.

### Kategori Risiko

| Skor    | Risiko        |
| ------- | ------------- |
| 0 - 20  | Rendah        |
| 21 - 41 | Sedang        |
| 42 - 62 | Tinggi        |
| > 62    | Sangat Tinggi |

Parameter dapat diubah oleh Super Admin.

---

## 7.5 AI Recommendation Engine

### Input

* Data pekerja
* Karakteristik pekerjaan
* Hasil NBM
* Area tubuh dominan
* Tingkat risiko

### Workflow

Assessment

↓

Risk Scoring

↓

Rule Engine

↓

Context Builder

↓

Gemini/Groq API

↓

Recommendation Generator

↓

Save Result

### Output

#### Rekomendasi Postur

Contoh:

* Posisi monitor
* Posisi kursi
* Posisi keyboard

#### Rekomendasi Aktivitas

Contoh:

* Stretching
* Microbreak
* Walking break

#### Rekomendasi Peralatan

Contoh:

* Ergonomic chair
* Footrest
* Monitor stand

#### Rekomendasi Preventif

Contoh:

* Jadwal peregangan
* Rotasi pekerjaan
* Edukasi ergonomi

---

## 7.6 Reporting

### Individual Report

Berisi:

* Profil pekerja
* Hasil assessment
* Grafik
* Rekomendasi AI

### Organization Report

Berisi:

* Statistik risiko
* Area tubuh dominan
* Tren assessment
* Analisis risiko organisasi

### Export

* PDF
* Excel

---

## 7.7 User Management

### Users

### Roles

### Permissions

### User Assignment

---

## 7.8 System Settings

### General Settings

* Nama aplikasi
* Logo
* Favicon

### AI Settings

* Gemini API Key
* Groq API Key
* Model AI
* Temperature

### Risk Settings

* Risk Threshold
* Assessment Configuration

---

## 7.9 Audit Log

Mencatat seluruh aktivitas:

* Login
* Logout
* Tambah data
* Edit data
* Hapus data
* Generate AI
* Export laporan

---

# 8. DATABASE UTAMA

## companies

* id
* name
* address
* phone
* email

## departments

* id
* company_id
* name

## positions

* id
* company_id
* name

## users

* id
* company_id
* name
* email
* password

## roles

* id
* name

## permissions

* id
* name

## role_permissions

* id
* role_id
* permission_id

## user_roles

* id
* user_id
* role_id

## employees

* id
* company_id
* department_id
* position_id
* employee_number
* name
* gender
* age
* height
* weight
* years_of_service

## job_profiles

* id
* employee_id
* job_type
* sitting_hours
* standing_hours
* computer_hours
* shift_type

## assessments

* id
* employee_id
* assessment_date
* total_score
* risk_level

## assessment_details

* id
* assessment_id
* body_part
* score

## ai_recommendations

* id
* assessment_id
* ai_model
* prompt
* recommendation

## settings

* id
* setting_key
* setting_value

## activity_logs

* id
* user_id
* activity
* module
* ip_address
* created_at

---

# 9. NON-FUNCTIONAL REQUIREMENTS

## Performance

* Page Load < 3 Detik
* AI Response < 10 Detik

## Security

* Password Hashing
* Session Management
* CSRF Protection
* XSS Protection
* Activity Logging

## Scalability

* Mendukung multi organisasi
* Mendukung >10.000 assessment

## Compatibility

* Chrome
* Firefox
* Edge
* Safari
* Mobile Browser

---

# 10. KPI KEBERHASILAN

| KPI                     | Target     |
| ----------------------- | ---------- |
| Akurasi Scoring         | > 95%      |
| Kesesuaian dengan Pakar | > 80%      |
| SUS Score               | > 75       |
| Kepuasan Pengguna       | > 80%      |
| Waktu Assessment        | < 10 Menit |
| AI Response Time        | < 10 Detik |

---

# 11. ROADMAP PENGEMBANGAN

## V1.0

* Nordic Body Map
* Dashboard
* Reporting
* Gemini Integration
* Multi Role
* Multi Organization

## V1.5

* Advanced Analytics
* Excel Export
* Benchmark Report

## V2.0

* RULA Assessment
* REBA Assessment
* Comparative Analysis

## V3.0

* Computer Vision Ergonomics
* AI Pose Detection
* Real-Time Ergonomic Monitoring

---

# TAGLINE

**AI-ERGO**

### Smart Ergonomic Assessment and Personalized Workplace Recommendations Powered by Artificial Intelligence
