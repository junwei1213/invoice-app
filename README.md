# Invoice Management System

A full-stack Invoice Management application built with **Laravel 11** and **Vue.js 3**. This project demonstrates the ability to handle complex form data, database relationships, and modern frontend interactions.

## 🛠 Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Vue.js 3 (Composition API)
- **Glue:** Inertia.js (SPA experience)
- **Database:** MySQL
- **Styling:** Tailwind CSS
- **Authentication:** Laravel Breeze

## ✨ Key Features

- **User Authentication:** Secure login and registration.
- **Dynamic Invoice Creation:**
  - Add/Remove multiple line items dynamically using Vue.js.
  - Real-time client-side calculation of subtotals and grand total.
- **Data Integrity:** Uses `DB::transaction` to ensure invoices and line items are saved atomically.
- **Validation:** Robust server-side validation for all inputs.
- **Inertia.js:** Seamless single-page application experience without the complexity of an API.

## 🚀 Installation & Setup

Follow these steps to get the project running on your local machine.

### 1. Clone the repository
```bash
git clone <YOUR_GITHUB_REPO_LINK_HERE>
cd invoice-app
```
