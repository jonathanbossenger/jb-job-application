=== JB Job Application ===
Contributors: jonathanbossenger
Tags: job application, resume upload, user role, gutenberg block, job management
Requires at least: 5.8
Tested up to: 6.4
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin that allows applicants to submit job applications with resume uploads through a secure, block-embedded form.

== Description ==

A WordPress plugin that allows applicants to submit job applications with resume uploads through a secure, block-embedded form.

= Features =

* **Custom User Role**: Automatic "applicant" role assignment for new registrations
* **Gutenberg Block**: Easy-to-embed job application form block
* **Secure Authentication**: Requires login as an applicant to submit applications
* **Resume Upload**: PDF-only resume uploads with file size validation (5MB max)
* **Admin Dashboard**: Dedicated interface for reviewing and managing applications
* **Form Validation**: Complete validation for all required fields
* **Security**: Nonce verification, capability checks, and secure file handling

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/jb-job-application/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Enable user registration in WordPress Settings → General → "Anyone can register"

== Usage ==

= For Site Administrators =

1. **Activate the Plugin**: The plugin will automatically create an "Applicant" user role
2. **Add Form to Page**: 
   * Create or edit a page
   * Add the "Job Application Form" block
   * Publish the page
3. **Review Applications**:
   * Go to "Job Applications" in the WordPress admin menu
   * View all submitted applications
   * Click on an application to see full details
   * Download resumes directly from the admin interface

= For Applicants =

1. **Register**: Create an account (automatically assigned "applicant" role)
2. **Login**: Access the site with your credentials
3. **Submit Application**:
   * Navigate to the page with the job application form
   * Fill in all required fields:
     - First Name
     - Last Name
     - Email
     - Phone
     - Resume (PDF only, max 5MB)
   * Click "Submit Application"
4. **Confirmation**: See success message after submission

== Custom Post Type ==

The plugin creates a `job_application` custom post type to store submissions with the following metadata:
* First Name
* Last Name
* Email
* Phone
* Resume URL
* Submission Date

== User Role ==

The plugin creates an "applicant" role with the following capabilities:
* `read` - Basic WordPress read capability
* `submit_job_application` - Custom capability for submitting applications

== Security Features ==

* Nonce verification on form submission
* User authentication and role checks
* File type validation (PDF only)
* File size validation (5MB maximum)
* Sanitized input fields
* Capability-based access control

== Requirements ==

* WordPress 5.8 or higher
* PHP 7.4 or higher
* User registration enabled

== Changelog ==

= 1.0.0 =
* Initial release
* Custom applicant user role
* Gutenberg job application form block
* Secure resume upload functionality
* Admin dashboard for managing applications
* Form validation and security features
