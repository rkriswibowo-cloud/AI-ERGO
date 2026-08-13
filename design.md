# DESIGN DOCUMENT

# AI-ERGO

## AI-Assisted Ergonomic Risk Assessment System Using Nordic Body Map and Large Language Models for Personalized Workplace Recommendations

**Version:** 1.0
**Status:** Final Design
**Technology Stack:** PHP Native, MySQL, Bootstrap 5, Gemini API / Groq API

---

# 1. TUJUAN DOKUMEN

Dokumen ini menjelaskan rancangan teknis sistem AI-ERGO yang akan digunakan sebagai acuan pengembangan aplikasi, pembuatan database, implementasi fitur, serta penyusunan dokumentasi penelitian.

---

# 2. ARSITEKTUR SISTEM

## High Level Architecture

```text
+-----------------------+
|      Web Browser      |
+-----------+-----------+
            |
            v
+-----------------------+
|      PHP Native       |
|  Application Layer    |
+-----------+-----------+
            |
            +-------------------+
            |                   |
            v                   v
+----------------+     +----------------+
|     MySQL      |     | Gemini / Groq |
|    Database    |     |      API       |
+----------------+     +----------------+
```

---

# 3. ARSITEKTUR APLIKASI

## Layer Architecture

```text
Presentation Layer
│
├── Login
├── Dashboard
├── Assessment
├── Reporting
└── Administration

Business Layer
│
├── Authentication Engine
├── Role Permission Engine
├── Assessment Engine
├── Risk Scoring Engine
├── Rule Engine
├── AI Recommendation Engine
└── Reporting Engine

Data Layer
│
├── MySQL Database
├── File Storage
└── Activity Log
```

---

# 4. STRUKTUR FOLDER PROJECT

```text
ai-ergo/
│
├── app/
│   ├── controllers/
│   ├── models/
│   ├── services/
│   ├── middleware/
│   ├── helpers/
│   └── validators/
│
├── config/
│   ├── database.php
│   ├── app.php
│   ├── ai.php
│   └── permissions.php
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   ├── images/
│   │   └── uploads/
│   │
│   └── index.php
│
├── resources/
│   ├── views/
│   ├── templates/
│   └── reports/
│
├── storage/
│   ├── logs/
│   ├── exports/
│   └── backups/
│
├── routes/
│   ├── web.php
│   └── api.php
│
└── vendor/
```

---

# 5. MODUL SISTEM

## 5.1 Authentication Module

### Fungsi

* Login
* Logout
* Session Management
* Forgot Password
* Change Password

### Role

* Super Admin
* Admin K3
* HRD
* Ergonomist
* Employee

---

## 5.2 User Management Module

### Fitur

* CRUD User
* Assign Role
* Reset Password
* User Status

---

## 5.3 Company Management Module

### Fitur

* CRUD Perusahaan
* Multi Organization
* Aktivasi Organisasi

---

## 5.4 Department Management Module

### Fitur

* CRUD Departemen
* Relasi Perusahaan

---

## 5.5 Position Management Module

### Fitur

* CRUD Jabatan

---

## 5.6 Employee Management Module

### Fitur

* CRUD Pekerja
* Import Excel
* Export Excel

### Data Pekerja

* NIK/NIP
* Nama
* Gender
* Umur
* Tinggi Badan
* Berat Badan
* Masa Kerja

---

## 5.7 Assessment Module

### Fungsi

Melakukan penilaian ergonomi menggunakan Nordic Body Map.

### Workflow

```text
Pilih Pekerja
    ↓
Input Profil Pekerjaan
    ↓
Isi Nordic Body Map
    ↓
Simpan Assessment
```

---

# 6. NORDIC BODY MAP ENGINE

## Total Area Tubuh

28 Bagian Tubuh

### Skala Penilaian

| Nilai | Keterangan   |
| ----- | ------------ |
| 0     | Tidak Sakit  |
| 1     | Agak Sakit   |
| 2     | Sakit        |
| 3     | Sangat Sakit |

### Output

* Total Skor
* Area Dominan
* Tingkat Risiko

---

# 7. RISK SCORING ENGINE

## Formula

```text
Total Score = Σ seluruh skor NBM
```

## Risk Category

| Score   | Category      |
| ------- | ------------- |
| 0 - 20  | Rendah        |
| 21 - 41 | Sedang        |
| 42 - 62 | Tinggi        |
| >62     | Sangat Tinggi |

Konfigurasi dapat diubah melalui System Settings.

---

# 8. RULE ENGINE

## Tujuan

Membuat konteks sebelum dikirim ke LLM.

### Contoh Rule

#### Rule 1

```text
IF
Leher >= 2

THEN
Keluhan dominan pada leher
```

#### Rule 2

```text
IF
Punggung >= 2

THEN
Keluhan dominan pada punggung
```

#### Rule 3

```text
IF
Duduk > 6 Jam

THEN
Risiko sedentary working
```

---

# 9. AI RECOMMENDATION ENGINE

## Workflow

```text
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
Recommendation
```

---

## Context Builder

Menggabungkan:

### Profil Pekerja

* Umur
* Gender
* Tinggi badan
* Berat badan

### Profil Pekerjaan

* Jenis pekerjaan
* Jam duduk
* Jam berdiri
* Shift

### Hasil Assessment

* Total skor
* Risiko
* Area dominan

---

## Prompt Template

```text
Anda adalah seorang ahli ergonomi profesional.

Data Pekerja:
- Umur: {age}
- Gender: {gender}
- Pekerjaan: {job_type}

Karakteristik Kerja:
- Duduk: {sitting_hours}
- Berdiri: {standing_hours}

Hasil Nordic Body Map:
{nbm_result}

Tingkat Risiko:
{risk_level}

Berikan:

1. Analisis kondisi ergonomi.
2. Faktor risiko utama.
3. Rekomendasi perbaikan postur.
4. Rekomendasi aktivitas peregangan.
5. Rekomendasi peralatan ergonomi.
6. Tindakan preventif.
```

---

# 10. REPORTING ENGINE

## Individual Report

Isi:

* Profil pekerja
* Hasil assessment
* Grafik
* Rekomendasi AI

---

## Organizational Report

Isi:

* Jumlah pekerja
* Distribusi risiko
* Area dominan
* Tren bulanan

---

## Export Format

### PDF

Menggunakan:

* DomPDF

### Excel

Menggunakan:

* PhpSpreadsheet

---

# 11. DASHBOARD DESIGN

## Super Admin Dashboard

### KPI

* Total Organisasi
* Total User
* Total Assessment
* Total AI Request

### Charts

* Assessment Trend
* Risk Distribution
* Top Body Complaints

---

## Organization Dashboard

### KPI

* Total Employee
* Total Assessment
* High Risk Employee
* Critical Risk Employee

---

# 12. MENU STRUCTURE

```text
Dashboard
│
├── Master Data
│   ├── Companies
│   ├── Departments
│   ├── Positions
│   └── Employees
│
├── Assessment
│   ├── New Assessment
│   ├── Assessment History
│   └── Nordic Body Map
│
├── AI Analysis
│   ├── Generate Recommendation
│   └── Recommendation History
│
├── Reports
│   ├── Individual Report
│   ├── Organization Report
│   ├── Export PDF
│   └── Export Excel
│
├── Administration
│   ├── Users
│   ├── Roles
│   ├── Permissions
│   ├── System Settings
│   ├── AI Settings
│   └── Audit Logs
│
└── Profile
```

---

# 13. SECURITY DESIGN

## Authentication

* Password Hashing (bcrypt)
* Session Validation
* Session Timeout

---

## Authorization

Role-Based Access Control (RBAC)

### Tables

```text
roles
permissions
role_permissions
user_roles
```

---

## Activity Log

Mencatat:

* Login
* Logout
* Create
* Update
* Delete
* Export
* AI Request

---

# 14. BACKUP DESIGN

## Database Backup

### Manual Backup

Super Admin dapat melakukan backup kapan saja.

### Scheduled Backup

* Harian
* Mingguan
* Bulanan

Lokasi:

```text
/storage/backups/
```

---

# 15. PERFORMANCE TARGET

| Parameter         | Target     |
| ----------------- | ---------- |
| Login             | < 2 Detik  |
| Dashboard         | < 3 Detik  |
| Assessment Save   | < 2 Detik  |
| AI Recommendation | < 10 Detik |
| PDF Export        | < 5 Detik  |

---

# 16. FUTURE ROADMAP

## Version 1.5

* Advanced Analytics
* Risk Benchmark

## Version 2.0

* RULA Assessment
* REBA Assessment

## Version 3.0

* Computer Vision Ergonomics
* Pose Detection
* Real-Time Ergonomic Monitoring

---

# DESIGN PRINCIPLE

1. Simple and Easy to Use.
2. Multi Organization Ready.
3. Research Oriented.
4. AI Ready Architecture.
5. Modular Development.
6. Scalable and Maintainable.
7. Security First.
