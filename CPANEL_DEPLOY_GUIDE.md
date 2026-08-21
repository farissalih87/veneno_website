# 🚀 Veneno Auto Care — cPanel Shared Hosting Deployment Guide (veneno.ae)

This guide walks you through deploying the complete, production-ready **Veneno Auto Care Platform** to your cPanel Shared Hosting on **veneno.ae**.

---

## 📦 What is in the Deployment Zip?
The archive `veneno-ae-cpanel-deploy.zip` contains:
- ✅ **Full Laravel 12 Backend & Core Files**
- ✅ **Complete PHP `vendor/` Directory** (Pre-installed & optimized — no SSH/Composer command needed on hosting)
- ✅ **Compiled Production Frontend Bundles (`public/build`)** (Vue 3 + Tailwind v4 + Inertia.js)
- ✅ **High-Resolution Media & Assets** (`public/images/`, `public/videos/`, icons, before/after graphics)
- ✅ **Security-Hardened `.htaccess`** at the root (Auto-routes web traffic to `public/` & protects sensitive system files)
- ✅ **Performance-Optimized `public/.htaccess`** (Gzip compression & browser asset caching)
- ✅ **Pre-configured Production Environment** (`.env.production`)
- ✅ **One-Click Database Import File** (`database/veneno_database_schema_and_seed.sql`)

---

## 🛠️ Step-by-Step Deployment Instructions

### Step 1: Upload & Extract the Zip
1. Log into your **cPanel Account** (e.g. `https://veneno.ae:2083` or your hosting cPanel URL).
2. Click on **File Manager**.
3. Navigate to `public_html` (or your domain's document root folder, e.g., `public_html/veneno.ae`).
4. Click **Upload** at the top toolbar and select **`veneno-ae-cpanel-deploy.zip`**.
5. Once the upload hits 100% (green bar), return to File Manager.
6. Right-click **`veneno-ae-cpanel-deploy.zip`** and click **Extract** -> **Extract Files**.
7. *(Optional)* Delete the uploaded `.zip` file to save disk space.

---

### Step 2: Create MySQL Database & Import Data
1. In cPanel, go to **MySQL® Databases** (or **MySQL® Database Wizard**).
2. **Create New Database**: e.g., `cpaneluser_venenodb`.
3. **Create New Database User**: e.g., `cpaneluser_venenouser` with a strong password.
4. **Add User to Database**: Check **ALL PRIVILEGES** and click **Make Changes**.
5. Return to cPanel home and open **phpMyAdmin**.
6. Select your new database (`cpaneluser_venenodb`) on the left sidebar.
7. Click the **Import** tab at the top.
8. Click **Choose File** and select `database/veneno_database_schema_and_seed.sql` (found inside your extracted files).
9. Click **Go** / **Import** at the bottom.
   > 🎉 All tables, roles, admin accounts, service packages, and initial seed data are now installed!

---

### Step 3: Configure `.env`
1. In cPanel **File Manager**, make sure **Show Hidden Files (dotfiles)** is enabled in File Manager Settings (top right gear icon).
2. Look for the file named **`.env.production`**.
3. Rename or copy `.env.production` to **`.env`** (or edit the existing `.env`).
4. Right-click **`.env`** and click **Edit**.
5. Update the Database section with your cPanel database details:

```env
APP_NAME="Veneno Auto Care"
APP_ENV=production
APP_KEY=base64:UMrqzRkezfDUiQTML1SNJl49wDpzU7eC3qgFtT9HLkM=
APP_DEBUG=false
APP_URL=https://veneno.ae

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cpaneluser_venenodb
DB_USERNAME=cpaneluser_venenouser
DB_PASSWORD=YourStrongDatabasePasswordHere

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public
```
6. Click **Save Changes**.

---

### Step 4: Verify Folder Permissions
Ensure the following directories have write permissions (Permission **`755`** or **`775`**):
- `storage/` (and all its subfolders: `storage/framework/`, `storage/logs/`, `storage/app/`)
- `bootstrap/cache/`

*(In cPanel File Manager, right-click on the folder -> Change Permissions -> ensure Read & Write are checked for User/Group).*

---

### Step 5: Enable SSL (HTTPS)
1. In cPanel, search for **SSL/TLS Status** or **Let's Encrypt SSL**.
2. Run AutoSSL for `veneno.ae` and `www.veneno.ae` to ensure secure HTTPS lock.

---

## 🔑 Default Login Credentials

| Role | Email | Password | Access Portal |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@venenoautocare.com` | `password` | `/dashboard` (Full CRM, Financials, Staff, Inquiries) |
| **Operations Manager** | `manager@venenoautocare.com` | `password` | `/dashboard` (Bookings, Campaigns, Inquiries) |
| **Master Detailer** | `marcus@venenoautocare.com` | `password` | `/technician-portal` (Bay Workflow Tracker) |
| **VIP Customer Demo** | `alex@example.com` | `password` | `/customer-portal` (VIP Tier, Vehicle Registry) |

> ⚠️ *Note: After initial login, please change the admin password in your profile settings or CRM dashboard.*

---

## 🌐 Key URLs
- **Main Storefront:** `https://veneno.ae/`
- **Arabic Version:** `https://veneno.ae/ar`
- **VIP Customer Portal:** `https://veneno.ae/customer-portal`
- **Technician Bay Floor:** `https://veneno.ae/technician-portal`
- **CRM Admin Dashboard:** `https://veneno.ae/dashboard`
- **Staff Login:** `https://veneno.ae/login`
