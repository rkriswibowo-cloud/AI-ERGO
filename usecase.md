# USE CASE DIAGRAM

# AI-ERGO

## AI-Assisted Ergonomic Risk Assessment System Using Nordic Body Map and Large Language Models for Personalized Workplace Recommendations

Version 1.0

---

# 1. IDENTIFIKASI AKTOR

## 1. Super Admin

Aktor dengan hak akses tertinggi yang bertanggung jawab terhadap konfigurasi sistem, manajemen organisasi, pengguna, role, permission, AI, dan monitoring seluruh aktivitas sistem.

---

## 2. Admin K3

Aktor yang bertanggung jawab terhadap pengelolaan assessment ergonomi pada organisasi yang dikelola.

---

## 3. HRD

Aktor yang bertugas melakukan monitoring kondisi pekerja dan melihat laporan ergonomi.

---

## 4. Ergonomist / Assessor

Aktor yang melakukan assessment dan validasi hasil rekomendasi AI.

---

## 5. Employee (Pekerja)

Aktor yang melakukan pengisian assessment dan melihat hasil rekomendasi.

---

# 2. USE CASE DIAGRAM OVERVIEW

```text
                           +------------------+
                           |   Super Admin    |
                           +------------------+
                                   |
        -----------------------------------------------------
        |           |           |          |         |       |
        v           v           v          v         v       v
    Manage      Manage      Manage      Manage   Manage  Monitor
 Companies       Users       Roles        AI     Setting  System
                               &
                          Permissions

                                   |
                                   |
                                   v

+------------------+      +------------------+
|    Admin K3      |      |       HRD        |
+------------------+      +------------------+
          |                         |
          |                         |
          v                         v

   Manage Employee          View Dashboard
   Manage Assessment        View Statistics
   Generate AI              View Reports
   Export Reports           Export Reports

          |
          |
          v

+------------------+
|   Ergonomist     |
+------------------+

      |
      |
      v

 Create Assessment
 Validate AI Result
 Add Recommendation

      |
      |
      v

+------------------+
|    Employee      |
+------------------+

      |
      |
      v

 Fill Assessment
 View Result
 View Recommendation
 View History
```

---

# 3. USE CASE SUPER ADMIN

## UC-SA-01 Login

Deskripsi:
Super Admin masuk ke dalam sistem menggunakan akun yang valid.

---

## UC-SA-02 Manage Companies

Deskripsi:
Mengelola data organisasi/perusahaan.

Aktivitas:

* Tambah organisasi
* Edit organisasi
* Hapus organisasi
* Aktivasi organisasi

---

## UC-SA-03 Manage Users

Deskripsi:
Mengelola seluruh akun pengguna.

Aktivitas:

* Tambah user
* Edit user
* Nonaktifkan user
* Reset password

---

## UC-SA-04 Manage Roles

Deskripsi:
Mengelola role sistem.

Aktivitas:

* Tambah role
* Edit role
* Hapus role

---

## UC-SA-05 Manage Permissions

Deskripsi:
Mengelola permission setiap role.

---

## UC-SA-06 Manage AI Settings

Deskripsi:
Mengatur konfigurasi AI.

Aktivitas:

* Gemini API Key
* Groq API Key
* AI Model
* Prompt Template

---

## UC-SA-07 View Global Dashboard

Deskripsi:
Melihat seluruh statistik sistem.

---

## UC-SA-08 View Audit Log

Deskripsi:
Melihat aktivitas seluruh pengguna.

---

## UC-SA-09 Backup Database

Deskripsi:
Melakukan backup database.

---

## UC-SA-10 Restore Database

Deskripsi:
Mengembalikan database dari file backup.

---

# 4. USE CASE ADMIN K3

## UC-AK3-01 Login

Masuk ke sistem.

---

## UC-AK3-02 Manage Employees

Aktivitas:

* Tambah pekerja
* Edit pekerja
* Hapus pekerja
* Import Excel

---

## UC-AK3-03 Manage Assessment

Aktivitas:

* Buat assessment
* Edit assessment
* Lihat assessment

---

## UC-AK3-04 Generate AI Recommendation

Deskripsi:
Menghasilkan rekomendasi ergonomi menggunakan AI.

---

## UC-AK3-05 View Dashboard

Deskripsi:
Melihat dashboard organisasi.

---

## UC-AK3-06 Export Report

Aktivitas:

* Export PDF
* Export Excel

---

# 5. USE CASE HRD

## UC-HRD-01 Login

Masuk ke sistem.

---

## UC-HRD-02 View Dashboard

Melihat kondisi ergonomi organisasi.

---

## UC-HRD-03 View Assessment Result

Melihat hasil assessment pekerja.

---

## UC-HRD-04 View AI Recommendation

Melihat rekomendasi AI.

---

## UC-HRD-05 Export Report

Mengekspor laporan.

---

# 6. USE CASE ERGONOMIST

## UC-ERG-01 Login

Masuk ke sistem.

---

## UC-ERG-02 Create Assessment

Melakukan assessment pekerja.

---

## UC-ERG-03 View Assessment

Melihat hasil assessment.

---

## UC-ERG-04 Validate AI Recommendation

Memvalidasi rekomendasi yang dihasilkan AI.

---

## UC-ERG-05 Add Manual Recommendation

Menambahkan rekomendasi dari pakar.

---

## UC-ERG-06 Compare AI vs Expert

Membandingkan rekomendasi AI dengan rekomendasi pakar.

---

# 7. USE CASE EMPLOYEE

## UC-EMP-01 Login

Masuk ke sistem.

---

## UC-EMP-02 Fill Nordic Body Map

Mengisi kuesioner Nordic Body Map.

---

## UC-EMP-03 Submit Assessment

Mengirim hasil assessment.

---

## UC-EMP-04 View Result

Melihat hasil assessment.

---

## UC-EMP-05 View AI Recommendation

Melihat rekomendasi ergonomi yang dihasilkan AI.

---

## UC-EMP-06 View Assessment History

Melihat histori assessment pribadi.

---

# 8. DETAILED USE CASE

## Use Case: Generate AI Recommendation

### Actor

* Admin K3
* Ergonomist

### Preconditions

* Assessment telah selesai.
* Data pekerja tersedia.

### Main Flow

1. User membuka detail assessment.
2. User memilih Generate Recommendation.
3. Sistem mengambil data pekerja.
4. Sistem mengambil hasil Nordic Body Map.
5. Sistem menjalankan Rule Engine.
6. Sistem membangun Context Builder.
7. Sistem mengirim prompt ke Gemini/Groq.
8. AI menghasilkan rekomendasi.
9. Sistem menyimpan hasil rekomendasi.
10. Sistem menampilkan hasil.

### Post Conditions

* Rekomendasi AI tersimpan.

---

## Use Case: Fill Nordic Body Map

### Actor

Employee

### Preconditions

* Employee sudah login.

### Main Flow

1. Employee membuka menu Assessment.
2. Sistem menampilkan 28 bagian tubuh.
3. Employee memilih tingkat keluhan.
4. Employee menyimpan assessment.
5. Sistem menghitung skor.
6. Sistem menentukan tingkat risiko.
7. Sistem menyimpan hasil.

### Post Conditions

* Assessment tersimpan di database.

---

# 9. USE CASE RELATIONSHIP

```text
Login
  |
  +----> Fill Assessment
                |
                +----> Calculate Risk Score
                                |
                                +----> Generate AI Recommendation
                                                |
                                                +----> Validate Recommendation
                                                                |
                                                                +----> Generate Report
```

---

# 10. USE CASE SUMMARY

| Actor       | Total Use Case |
| ----------- | -------------- |
| Super Admin | 10             |
| Admin K3    | 6              |
| HRD         | 5              |
| Ergonomist  | 6              |
| Employee    | 6              |

Total Use Case Sistem: 33

Dokumen ini menjadi dasar untuk pembuatan Activity Diagram, Sequence Diagram, Class Diagram, dan implementasi modul pada fase pengembangan AI-ERGO.
