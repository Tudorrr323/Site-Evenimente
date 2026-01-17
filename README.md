# Ticketa - Platformă de Management Evenimente și Bilete 🎟️

> **Proiect de Practică**
>
> Această aplicație a fost realizată în perioada de practică de vară, **Iulie 2025**, în cadrul companiei **StillCo**.

---

## 📖 Descriere

**Ticketa** este o aplicație web completă dedicată descoperirii, rezervării și gestionării biletelor pentru diverse tipuri de evenimente (concerte, filme, teatru, conferințe). Aplicația oferă o interfață modernă pentru utilizatori și un panou de administrare pentru organizatori.

Punctul forte al aplicației este sistemul automatizat de generare a biletelor în format **PDF**, care include datele evenimentului și un **Cod QR unic** pentru validare la intrare.

---

## 📸 Galerie Foto & Demo

Mai jos sunt prezentate interfața aplicației și funcționalitățile principale:

### 1. Interfața Principală și Evenimente
Pagina de pornire oferă acces rapid la evenimente populare și funcții de căutare.
![Home Page](Poze%20Site/image.png)

### 2. Detalii Eveniment & Categorii
Utilizatorii pot naviga prin categorii și vizualiza detalii despre evenimente.
![Event Details](Poze%20Site/image%20(1).png)

### 3. Coșul de Cumpărături și Checkout
Procesul de achiziție este simplificat, oferind un rezumat clar al comenzii.
![Cart](Poze%20Site/image%20(2).png)

### 4. Biletele Mele (Dashboard)
Utilizatorii își pot vedea istoricul comenzilor și pot descărca biletele.
![My Tickets](Poze%20Site/image%20(3).png)

### 5. Generare Bilet PDF (Demo)
Sistemul generează un fișier PDF securizat pentru fiecare comandă. Mai jos puteți vedea structura biletului generat, inclusiv codul QR pentru scanare.

![Ticket Preview](Poze%20Site/Screenshot%202026-01-17%20201629.png)

📄 **Descarcă Exemplu Bilet:** [Vezi fișierul PDF complet](Poze%20Site/bilet_comanda_93.pdf)

---

## 🚀 Funcționalități Cheie

### 👤 Pentru Utilizatori (Clienți)
*   **Autentificare Securizată:** Login, Sign-up, Resetare parolă.
*   **Căutare Avansată:** Filtrare după nume, oraș, dată (folosind calendar integrat).
*   **Coș de Cumpărături:** Gestionarea biletelor înainte de plată.
*   **My Tickets:** Vizualizarea biletelor achiziționate.
*   **Download PDF:** Generare on-the-fly a biletelor cu cod QR unic (folosind biblioteca FPDF și PHP QR Code).

### 👔 Pentru Organizatori & Manageri
*   **Creare Evenimente:** Adăugarea de evenimente noi cu detalii complete (locație, dată, imagine, descriere).
*   **Gestionare Bilete:** Definirea tipurilor de bilete (VIP, Standard, etc.) și a stocurilor.
*   **Dashboard:** Administrarea evenimentelor proprii.

---

## 🛠️ Tehnologii Utilizate

Aplicația este construită folosind o arhitectură clasică LAMP (Linux/Windows, Apache, MySQL, PHP).

*   **Backend:** PHP (Vanilla)
*   **Frontend:** HTML5, CSS3 (Responsive), JavaScript (Vanilla)
*   **Bază de date:** MySQL
*   **Biblioteci Externe:**
    *   **FPDF:** Pentru generarea documentelor PDF.
    *   **PHP QR Code:** Pentru generarea codurilor QR unice pe bilete.
    *   **FontAwesome:** Pentru iconițe.
    *   **Flatpickr:** Pentru selecția datelor calendaristice.

---

## 📂 Structura Proiectului

Proiectul a fost organizat modular pentru a asigura mentenanța ușoară:

```text
/
├── assets/             # Resurse statice
│   ├── css/            # Fișiere de stil (style.css)
│   ├── img/            # Imagini evenimente și logo
│   └── js/             # Scripturi JavaScript
├── auth/               # Module de autentificare (login, signup)
├── fpdf/               # Biblioteca FPDF și scripturi conexe
├── includes/           # Scripturi backend (conexiune BD, logică PDF)
├── organizer/          # Pagini dedicate organizatorilor
├── pages/              # Pagini publice (about, cart, profile)
├── sql/                # Scripturi de import bază de date
├── temp/               # Director temporar pentru generarea QR
└── index.php           # Punctul de intrare în aplicație
```

---

## ⚙️ Instalare și Configurare

1.  **Cerințe:** XAMPP (sau un server similar cu Apache/PHP/MySQL).
2.  **Configurare:**
    *   Asigurați-vă că extensia `gd` este activată în `php.ini`.
    *   Importați fișierul `sql/site_evenimente.sql` în PHPMyAdmin.
    *   Configurați conexiunea la baza de date în `includes/dbh.inc.php`.
3.  **Rulare:**
    *   Copiați fișierele în folderul `htdocs`.
    *   Accesați `http://localhost/Site-Evenimente`.

---

© 2025 Ticketa. Dezvoltat la **StillCo**.
