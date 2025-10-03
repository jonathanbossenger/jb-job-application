# Quick Start Guide

Get the JB Job Application plugin up and running in 5 minutes!

## Prerequisites

✓ WordPress 5.8 or higher
✓ PHP 7.4 or higher
✓ Admin access to WordPress

## Installation (3 Steps)

### Step 1: Install the Plugin

**Option A: Upload ZIP**
1. Download or create a ZIP of this repository
2. Go to WordPress Admin → Plugins → Add New
3. Click "Upload Plugin"
4. Choose the ZIP file
5. Click "Install Now"
6. Click "Activate Plugin"

**Option B: Manual Installation**
1. Copy the `jb-job-application` folder to `wp-content/plugins/`
2. Go to WordPress Admin → Plugins
3. Find "JB Job Application"
4. Click "Activate"

### Step 2: Enable User Registration

1. Go to **Settings → General**
2. Check the box: **"Anyone can register"**
3. Click **"Save Changes"**

### Step 3: Add Form to a Page

1. **Create or edit a page**
2. **Click the "+" button** to add a block
3. **Search for**: "Job Application Form"
4. **Click** to insert the block
5. **Publish** the page

## That's it! 🎉

Your job application system is now live!

## Test the System

### As an Applicant:

1. **Log out** of WordPress admin
2. **Register a new account** at `/wp-login.php?action=register`
   - Username: testapplicant
   - Email: test@example.com
3. **Log in** with your new account
4. **Visit the page** with the application form
5. **Fill out the form**:
   - First Name: John
   - Last Name: Doe
   - Email: john@example.com
   - Phone: 555-1234
   - Resume: Upload a PDF file
6. **Click "Submit Application"**
7. **See the success message**

### As an Administrator:

1. **Log in** to WordPress admin
2. **Click "Job Applications"** in the left menu
3. **See the submitted application** in the list
4. **Click on the application** to view details
5. **Download the resume**

## Common URLs

- **Registration**: `/wp-login.php?action=register`
- **Login**: `/wp-login.php`
- **Admin Applications**: `/wp-admin/edit.php?post_type=job_application`

## Troubleshooting

**Form not showing?**
→ Make sure you're logged in as an applicant

**Can't submit application?**
→ Check that user registration is enabled

**File upload fails?**
→ Ensure file is PDF and under 5MB

## Next Steps

✓ Customize the form styling in `assets/css/frontend.css`
✓ Review submissions in the admin dashboard
✓ Read the full documentation in `README.md`

## Need Help?

📖 **Full Documentation**: See `README.md`
🔧 **Installation Guide**: See `INSTALLATION.md`
📊 **Usage Guide**: See `USAGE.md`
🏗️ **Architecture**: See `ARCHITECTURE.md`

## Features Included

✅ Custom "applicant" user role
✅ Gutenberg block integration
✅ Personal info form fields
✅ PDF resume upload (5MB max)
✅ Secure file validation
✅ Admin review dashboard
✅ Role-based access control
✅ Form validation & security
✅ Success/error messages
✅ Responsive design

**Enjoy your new job application system!** 🚀
