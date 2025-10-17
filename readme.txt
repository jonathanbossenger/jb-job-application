=== JB Job Application ===
Contributors: jonathanbossenger
Tags: job application, applicant, resume, recruitment, gutenberg block
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin that allows applicants to submit job applications with resume uploads through a secure, block-embedded form.

== Description ==

JB Job Application is a comprehensive WordPress plugin designed to streamline the job application process on your website. It provides a secure and user-friendly way for applicants to submit their job applications directly through your WordPress site.

= Key Features =

* **Custom User Role**: Automatic "applicant" role assignment for new user registrations
* **Gutenberg Block**: Easy-to-embed job application form block for the WordPress block editor
* **Secure Authentication**: Requires users to log in as an applicant before submitting applications
* **Resume Upload**: PDF-only resume uploads with file size validation (5MB maximum)
* **Admin Dashboard**: Dedicated interface for reviewing and managing job applications
* **Form Validation**: Complete validation for all required fields including email, phone, and file uploads
* **Security**: Built-in nonce verification, capability checks, and secure file handling
* **Secure File Storage**: Resume files are stored with UUID naming for enhanced security

= How It Works =

1. Site administrators activate the plugin and add the Job Application Form block to any page
2. Visitors register for an account (automatically assigned the "applicant" role)
3. Applicants log in and access the job application form
4. After filling out the required information and uploading their resume (PDF only), the application is submitted
5. Administrators can review all applications in the WordPress admin dashboard
6. Resume files can be securely downloaded directly from the admin interface

= Perfect For =

* Small businesses looking to collect job applications
* HR departments wanting a simple recruitment solution
* Freelancers and consultants accepting proposals
* Any organization needing a structured application process

= Security Features =

* Nonce verification on all form submissions
* User authentication and role-based access control
* File type validation (PDF only)
* File size validation (5MB maximum)
* Sanitized and validated input fields
* Secure file storage with UUID naming
* Capability-based access control throughout

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Go to Plugins → Add New
3. Search for "JB Job Application"
4. Click "Install Now" and then "Activate"
5. Enable user registration in Settings → General → "Anyone can register"

= Manual Installation =

1. Download the plugin ZIP file
2. Log in to your WordPress admin panel
3. Go to Plugins → Add New → Upload Plugin
4. Choose the downloaded ZIP file and click "Install Now"
5. Click "Activate Plugin"
6. Enable user registration in Settings → General → "Anyone can register"

= After Installation =

1. The plugin automatically creates an "Applicant" user role upon activation
2. Create or edit a page where you want to display the application form
3. Add the "Job Application Form" block using the WordPress block editor
4. Publish the page
5. Navigate to "Job Applications" in the admin menu to review submissions

== Frequently Asked Questions ==

= How do I add the job application form to my website? =

After activating the plugin, edit any page or post in the WordPress block editor. Add the "Job Application Form" block by searching for it in the block inserter. Publish the page, and the form will be available to logged-in applicants.

= What file types are accepted for resume uploads? =

The plugin only accepts PDF files for resume uploads. This ensures consistency and security. The maximum file size is 5MB.

= Do applicants need to register before submitting an application? =

Yes, applicants must register for an account and log in before submitting a job application. This helps maintain security and allows you to track who submitted each application.

= How do I view submitted applications? =

Go to the WordPress admin dashboard and click on "Job Applications" in the left sidebar. You'll see a list of all submitted applications with applicant details, submission dates, and links to download resumes.

= Can I customize the application form fields? =

The current version includes standard fields (First Name, Last Name, Email, Phone, and Resume). Customization of fields would require modifications to the plugin code.

= Where are resume files stored? =

Resume files are stored securely in the wp-content/applications directory with UUID-based filenames. This directory is protected against direct access with an index.php file that prevents directory browsing, ensuring resume files can only be accessed through the WordPress admin interface.

= Can administrators download submitted resumes? =

Yes, administrators can download resumes directly from the Job Applications admin screen. Click the "Download Resume" link next to any application or view it from the application detail page.

= What user role is assigned to new registrations? =

New user registrations are automatically assigned the "Applicant" role. This role has read access and the specific capability to submit job applications.

= Is user registration required for this plugin to work? =

Yes, user registration must be enabled in WordPress (Settings → General → "Anyone can register"). Without this setting, visitors cannot create applicant accounts.

= Can I use this plugin with my existing theme? =

Yes, the plugin is designed to work with any WordPress theme that supports the block editor (Gutenberg). The form styling is minimal and should adapt to most themes.

== Screenshots ==

1. Job Application Form block in the WordPress block editor
2. Frontend view of the job application form for logged-in applicants
3. Admin dashboard showing list of all job applications
4. Individual application details view in the admin area
5. Login/registration prompt for users who are not logged in

== Changelog ==

= 1.0.0 =
* Initial release
* Custom "Applicant" user role with automatic assignment
* Gutenberg block for job application form
* Secure PDF resume upload with 5MB limit
* Admin dashboard for managing applications
* Complete form validation and security features
* Secure file storage with UUID naming
* Resume download functionality for administrators
* User authentication and capability checks

== Upgrade Notice ==

= 1.0.0 =
Initial release of JB Job Application plugin. Install and activate to start collecting job applications on your WordPress site.
