# JB Job Application Plugin - Usage Guide

## Quick Start

### Step 1: Install and Activate
1. Upload the plugin to your WordPress site
2. Activate through the WordPress admin panel
3. The plugin automatically creates the "applicant" user role

### Step 2: Enable User Registration
Go to **Settings → General** and check "Anyone can register"

### Step 3: Add the Form to a Page
1. Create or edit a page
2. Click the "+" button to add a block
3. Search for "Job Application Form"
4. Insert the block
5. Publish the page

### Step 4: Test the Workflow

#### As an Applicant:
1. **Register**: Go to `/wp-login.php?action=register`
2. **Login**: Use your credentials
3. **Navigate** to the page with the job application form
4. **Fill out** the form:
   - First Name (required)
   - Last Name (required)
   - Email (required)
   - Phone (required)
   - Resume PDF (required, max 5MB)
5. **Submit** and see the success message

#### As an Administrator:
1. **Navigate** to "Job Applications" in the admin menu
2. **View** all submissions in a table format
3. **Click** on an application to see full details
4. **Download** resumes directly from the admin interface

## Features in Detail

### Authentication & Authorization
- Users must be logged in to see the form
- Only users with "applicant" or "administrator" role can submit
- Non-logged-in users see login/register links
- Users with wrong role see an appropriate message

### Form Validation
- All fields are required
- Email format validation
- PDF file type validation
- 5MB file size limit
- Server-side validation for security

### Admin Dashboard
- Custom post type "job_application"
- Custom columns showing applicant info
- Meta box with full application details
- Direct download links for resumes
- Cannot be created manually (only through form submission)

### Security Features
- WordPress nonce verification
- User capability checks
- Sanitized and validated inputs
- Secure file upload handling
- Direct file access prevention

## Customization

### Change Maximum File Size
Edit line in `jb-job-application.php`:
```php
if ($_FILES['jb_resume']['size'] > 5 * 1024 * 1024) {
```
Change `5` to desired size in MB.

### Add More Form Fields
1. Add HTML input in `jb_job_app_render_form_block()`
2. Add validation in `jb_job_app_handle_submission()`
3. Add meta field save with `update_post_meta()`
4. Display in `jb_job_app_render_meta_box()`

### Styling
Modify `assets/css/frontend.css` for form styles.

## Troubleshooting

### Form Not Appearing
- Ensure you're logged in
- Check if user has "applicant" or "administrator" role
- Verify plugin is activated

### File Upload Fails
- Check file is PDF format
- Ensure file is under 5MB
- Verify upload directory permissions

### Applications Not Showing in Admin
- Check if form was submitted successfully
- Look for success message after submission
- Verify you're logged in as administrator

## Database Schema

### Post Type: job_application
- Post Title: Applicant's full name
- Post Author: User ID of submitter
- Post Status: publish

### Meta Fields:
- `_jb_first_name`: First name
- `_jb_last_name`: Last name
- `_jb_email`: Email address
- `_jb_phone`: Phone number
- `_jb_resume_url`: URL to uploaded PDF
- `_jb_submitted_date`: Submission timestamp

## Support

For issues or questions, please create an issue on the GitHub repository.
