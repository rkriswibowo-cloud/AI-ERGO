# ENTITY RELATIONSHIP DIAGRAM (ERD)

# AI-ERGO

## AI-Assisted Ergonomic Risk Assessment System Using Nordic Body Map and Large Language Models for Personalized Workplace Recommendations

Version: 1.0

---

# 1. OVERVIEW

AI-ERGO menggunakan arsitektur database relasional dengan pendekatan:

* Multi Organization
* Role Based Access Control (RBAC)
* Assessment Engine
* AI Recommendation Engine
* Audit Logging
* System Configuration

Total Entitas Utama:

1. companies
2. departments
3. positions
4. users
5. roles
6. permissions
7. role_permissions
8. user_roles
9. employees
10. job_profiles
11. assessments
12. assessment_details
13. ai_recommendations
14. settings
15. activity_logs

---

# 2. CONCEPTUAL ERD

```text
COMPANIES
    │
    ├── DEPARTMENTS
    │
    ├── POSITIONS
    │
    ├── USERS
    │
    └── EMPLOYEES
            │
            ├── JOB_PROFILES
            │
            └── ASSESSMENTS
                    │
                    ├── ASSESSMENT_DETAILS
                    │
                    └── AI_RECOMMENDATIONS

USERS
    │
    └── USER_ROLES
            │
            └── ROLES
                    │
                    └── ROLE_PERMISSIONS
                            │
                            └── PERMISSIONS

USERS
    │
    └── ACTIVITY_LOGS

SETTINGS
```

---

# 3. LOGICAL ERD

## companies

| Field      | Type      |
| ---------- | --------- |
| id         | BIGINT PK |
| name       | VARCHAR   |
| address    | TEXT      |
| phone      | VARCHAR   |
| email      | VARCHAR   |
| logo       | VARCHAR   |
| status     | ENUM      |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

---

## departments

| Field       | Type      |
| ----------- | --------- |
| id          | BIGINT PK |
| company_id  | BIGINT FK |
| name        | VARCHAR   |
| description | TEXT      |
| created_at  | TIMESTAMP |
| updated_at  | TIMESTAMP |

Relasi:

```text
Company 1 ---- N Department
```

---

## positions

| Field       | Type      |
| ----------- | --------- |
| id          | BIGINT PK |
| company_id  | BIGINT FK |
| name        | VARCHAR   |
| description | TEXT      |
| created_at  | TIMESTAMP |
| updated_at  | TIMESTAMP |

Relasi:

```text
Company 1 ---- N Position
```

---

## users

| Field      | Type           |
| ---------- | -------------- |
| id         | BIGINT PK      |
| company_id | BIGINT FK NULL |
| name       | VARCHAR        |
| email      | VARCHAR        |
| password   | VARCHAR        |
| status     | ENUM           |
| last_login | DATETIME       |
| created_at | TIMESTAMP      |
| updated_at | TIMESTAMP      |

Keterangan:

* Super Admin boleh memiliki company_id = NULL

---

## roles

| Field       | Type      |
| ----------- | --------- |
| id          | BIGINT PK |
| name        | VARCHAR   |
| description | TEXT      |

Data Awal:

* Super Admin
* Admin K3
* HRD
* Ergonomist
* Employee

---

## permissions

| Field  | Type      |
| ------ | --------- |
| id     | BIGINT PK |
| name   | VARCHAR   |
| module | VARCHAR   |

Contoh:

* company.create
* company.update
* assessment.create
* assessment.view
* report.export

---

## role_permissions

| Field         | Type      |
| ------------- | --------- |
| id            | BIGINT PK |
| role_id       | BIGINT FK |
| permission_id | BIGINT FK |

---

## user_roles

| Field   | Type      |
| ------- | --------- |
| id      | BIGINT PK |
| user_id | BIGINT FK |
| role_id | BIGINT FK |

---

# 4. EMPLOYEE MODULE

## employees

| Field            | Type      |
| ---------------- | --------- |
| id               | BIGINT PK |
| company_id       | BIGINT FK |
| department_id    | BIGINT FK |
| position_id      | BIGINT FK |
| employee_number  | VARCHAR   |
| name             | VARCHAR   |
| gender           | ENUM      |
| birth_date       | DATE      |
| age              | INT       |
| height           | DECIMAL   |
| weight           | DECIMAL   |
| years_of_service | INT       |
| phone            | VARCHAR   |
| email            | VARCHAR   |
| status           | ENUM      |
| created_at       | TIMESTAMP |
| updated_at       | TIMESTAMP |

Relasi:

```text
Company     1 ---- N Employee
Department  1 ---- N Employee
Position    1 ---- N Employee
```

---

## job_profiles

| Field          | Type      |
| -------------- | --------- |
| id             | BIGINT PK |
| employee_id    | BIGINT FK |
| job_type       | VARCHAR   |
| sitting_hours  | DECIMAL   |
| standing_hours | DECIMAL   |
| computer_hours | DECIMAL   |
| shift_type     | VARCHAR   |
| work_duration  | DECIMAL   |
| created_at     | TIMESTAMP |
| updated_at     | TIMESTAMP |

Relasi:

```text
Employee 1 ---- N Job Profile
```

Catatan:

Satu pekerja dapat memiliki beberapa profil pekerjaan historis.

---

# 5. ASSESSMENT MODULE

## assessments

| Field              | Type      |
| ------------------ | --------- |
| id                 | BIGINT PK |
| employee_id        | BIGINT FK |
| assessor_id        | BIGINT FK |
| assessment_date    | DATE      |
| total_score        | INT       |
| risk_level         | ENUM      |
| dominant_body_area | VARCHAR   |
| notes              | TEXT      |
| created_at         | TIMESTAMP |
| updated_at         | TIMESTAMP |

Relasi:

```text
Employee 1 ---- N Assessment
User     1 ---- N Assessment
```

---

## assessment_details

| Field          | Type      |
| -------------- | --------- |
| id             | BIGINT PK |
| assessment_id  | BIGINT FK |
| body_part_code | VARCHAR   |
| body_part_name | VARCHAR   |
| score          | TINYINT   |
| created_at     | TIMESTAMP |

Relasi:

```text
Assessment 1 ---- N Assessment Detail
```

---

# 6. AI MODULE

## ai_recommendations

| Field               | Type      |
| ------------------- | --------- |
| id                  | BIGINT PK |
| assessment_id       | BIGINT FK |
| ai_provider         | VARCHAR   |
| ai_model            | VARCHAR   |
| prompt_text         | LONGTEXT  |
| recommendation_text | LONGTEXT  |
| generated_at        | DATETIME  |
| created_at          | TIMESTAMP |

Relasi:

```text
Assessment 1 ---- N AI Recommendation
```

Catatan:

Menyimpan histori rekomendasi apabila di-generate ulang menggunakan model AI berbeda.

---

# 7. SYSTEM SETTINGS

## settings

| Field         | Type      |
| ------------- | --------- |
| id            | BIGINT PK |
| setting_group | VARCHAR   |
| setting_key   | VARCHAR   |
| setting_value | LONGTEXT  |
| description   | TEXT      |

Contoh:

```text
APP_NAME
APP_LOGO
GEMINI_API_KEY
GROQ_API_KEY
AI_MODEL
RISK_THRESHOLD
```

---

# 8. AUDIT TRAIL

## activity_logs

| Field       | Type      |
| ----------- | --------- |
| id          | BIGINT PK |
| user_id     | BIGINT FK |
| module      | VARCHAR   |
| action      | VARCHAR   |
| description | TEXT      |
| ip_address  | VARCHAR   |
| user_agent  | TEXT      |
| created_at  | TIMESTAMP |

Relasi:

```text
User 1 ---- N Activity Log
```

---

# 9. PHYSICAL ERD

```text
companies
│
├── departments
│
├── positions
│
├── users
│     │
│     ├── user_roles
│     │       │
│     │       └── roles
│     │               │
│     │               └── role_permissions
│     │                       │
│     │                       └── permissions
│     │
│     └── activity_logs
│
└── employees
      │
      ├── job_profiles
      │
      └── assessments
              │
              ├── assessment_details
              │
              └── ai_recommendations
```

---

# 10. RELATIONSHIP SUMMARY

| Parent      | Child              | Relationship |
| ----------- | ------------------ | ------------ |
| companies   | departments        | 1 : N        |
| companies   | positions          | 1 : N        |
| companies   | users              | 1 : N        |
| companies   | employees          | 1 : N        |
| departments | employees          | 1 : N        |
| positions   | employees          | 1 : N        |
| users       | user_roles         | 1 : N        |
| roles       | user_roles         | 1 : N        |
| roles       | role_permissions   | 1 : N        |
| permissions | role_permissions   | 1 : N        |
| employees   | job_profiles       | 1 : N        |
| employees   | assessments        | 1 : N        |
| users       | assessments        | 1 : N        |
| assessments | assessment_details | 1 : N        |
| assessments | ai_recommendations | 1 : N        |
| users       | activity_logs      | 1 : N        |

---

# DATABASE ESTIMATION

## Version 1.0

Jumlah Tabel: 15

Estimasi Record:

* Employees : 10.000+
* Assessments : 100.000+
* Assessment Details : 2.800.000+
* AI Recommendations : 100.000+

Struktur ini sudah siap untuk:

* Multi Organisasi
* Multi Role
* Nordic Body Map
* AI Recommendation
* Audit Trail
* Reporting
* Pengembangan RULA & REBA pada versi berikutnya tanpa perubahan struktur besar.
