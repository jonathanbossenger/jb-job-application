# Plugin Architecture

## Component Overview

```
┌─────────────────────────────────────────────────────────────┐
│                    WordPress Installation                    │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌───────────────────────────────────────────────────┐     │
│  │         JB Job Application Plugin                 │     │
│  ├───────────────────────────────────────────────────┤     │
│  │                                                   │     │
│  │  ┌─────────────┐  ┌──────────────┐  ┌─────────┐ │     │
│  │  │   Custom    │  │   Gutenberg  │  │  Admin  │ │     │
│  │  │  User Role  │  │    Block     │  │  Panel  │ │     │
│  │  │             │  │              │  │         │ │     │
│  │  │ "applicant" │  │  Form Block  │  │  List   │ │     │
│  │  └─────────────┘  └──────────────┘  │  Detail │ │     │
│  │                                      └─────────┘ │     │
│  │                                                   │     │
│  │  ┌────────────────────────────────────────────┐  │     │
│  │  │      Custom Post Type                      │  │     │
│  │  │      "job_application"                     │  │     │
│  │  │                                           │  │     │
│  │  │  Meta Fields:                             │  │     │
│  │  │  - _jb_first_name                         │  │     │
│  │  │  - _jb_last_name                          │  │     │
│  │  │  - _jb_email                              │  │     │
│  │  │  - _jb_phone                              │  │     │
│  │  │  - _jb_resume_url                         │  │     │
│  │  │  - _jb_submitted_date                     │  │     │
│  │  └────────────────────────────────────────────┘  │     │
│  │                                                   │     │
│  │  ┌────────────────────────────────────────────┐  │     │
│  │  │      Security Layer                        │  │     │
│  │  │  - Nonce verification                      │  │     │
│  │  │  - Role checks                             │  │     │
│  │  │  - File validation                         │  │     │
│  │  │  - Input sanitization                      │  │     │
│  │  └────────────────────────────────────────────┘  │     │
│  └───────────────────────────────────────────────────┘     │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

## Data Flow

### User Registration
```
1. User visits /wp-login.php?action=register
                    ↓
2. Fills registration form
                    ↓
3. WordPress creates user account
                    ↓
4. Plugin hook: user_register
                    ↓
5. Set user role to "applicant"
                    ↓
6. User can now access application form
```

### Form Submission
```
1. Applicant visits page with form block
                    ↓
2. Plugin checks authentication
                    ↓
3. Plugin checks user role
                    ↓
4. Form rendered with current user data
                    ↓
5. Applicant fills and submits form
                    ↓
6. Plugin validates nonce
                    ↓
7. Plugin validates all fields
                    ↓
8. Plugin validates file upload
                    ↓
9. File uploaded to wp-content/uploads/
                    ↓
10. Create job_application post
                    ↓
11. Save all meta fields
                    ↓
12. Redirect with success message
```

### Admin Review
```
1. Admin navigates to "Job Applications"
                    ↓
2. List of all applications displayed
                    ↓
3. Admin clicks on application
                    ↓
4. Full details shown in meta box
                    ↓
5. Admin can download resume
```

## File Structure

```
jb-job-application/
│
├── Core Plugin
│   └── jb-job-application.php      [Main plugin file]
│       ├── Plugin headers
│       ├── Constants
│       ├── Activation/deactivation hooks
│       ├── Role management
│       ├── Post type registration
│       ├── Block registration
│       ├── Form rendering
│       ├── Form submission handler
│       ├── Admin customization
│       └── Frontend enqueues
│
├── Block Assets
│   ├── src/                         [Source files]
│   │   ├── index.js                [Block definition]
│   │   ├── editor.css              [Editor styles]
│   │   └── style.css               [Frontend styles]
│   │
│   └── build/                       [Compiled files]
│       ├── index.js                [Compiled block]
│       ├── index.asset.php         [Dependencies]
│       ├── editor.css              [Compiled editor CSS]
│       └── style.css               [Compiled frontend CSS]
│
├── Assets
│   └── css/
│       └── frontend.css            [Form styles]
│
├── Configuration
│   ├── package.json                [NPM config]
│   ├── package-lock.json           [Locked versions]
│   └── .gitignore                  [Git exclusions]
│
└── Documentation
    ├── README.md                   [Main docs]
    ├── USAGE.md                    [Usage guide]
    ├── INSTALLATION.md             [Install guide]
    ├── VISUAL-GUIDE.md             [UI mockups]
    ├── SUMMARY.md                  [Implementation summary]
    ├── ARCHITECTURE.md             [This file]
    └── verify.sh                   [Verification script]
```

## Function Map

### Activation/Deactivation
- `jb_job_app_activate()` - Setup on activation
- `jb_job_app_deactivate()` - Cleanup on deactivation

### User Management
- `jb_job_app_add_applicant_role()` - Create applicant role
- `jb_job_app_set_default_role()` - Assign role to new users

### Post Type
- `jb_job_app_register_post_type()` - Register job_application CPT

### Block
- `jb_job_app_register_block()` - Register Gutenberg block
- `jb_job_app_render_form_block()` - Render form on frontend

### Form Processing
- `jb_job_app_handle_submission()` - Process form submission

### Admin Interface
- `jb_job_app_add_meta_boxes()` - Add meta boxes
- `jb_job_app_render_meta_box()` - Render application details
- `jb_job_app_custom_columns()` - Define list columns
- `jb_job_app_custom_column_content()` - Populate list columns

### Assets
- `jb_job_app_enqueue_styles()` - Load frontend CSS

## Database Schema

### wp_posts
```
ID               | Post ID
post_author      | User ID of applicant
post_date        | Submission timestamp
post_title       | Full name
post_type        | 'job_application'
post_status      | 'publish'
```

### wp_postmeta
```
post_id          | References wp_posts.ID
meta_key         | Field name
meta_value       | Field value

Keys:
- _jb_first_name
- _jb_last_name
- _jb_email
- _jb_phone
- _jb_resume_url
- _jb_submitted_date
```

### wp_usermeta
```
user_id          | User ID
meta_key         | 'wp_capabilities'
meta_value       | Serialized role array
                 | a:1:{s:9:"applicant";b:1;}
```

## Security Model

### Layers of Protection

1. **Authentication**
   - WordPress login required
   - Session management by WordPress

2. **Authorization**
   - Role-based access (applicant or admin)
   - Capability checks before actions

3. **Form Security**
   - Nonce verification (wp_nonce_field)
   - CSRF protection

4. **Input Validation**
   - Required field checks
   - Email format validation
   - Phone number sanitization

5. **File Upload Security**
   - Type validation (PDF only)
   - Size limit (5MB)
   - Secure upload handling
   - WordPress media handling

6. **Output Security**
   - Data escaping (esc_html, esc_url, esc_attr)
   - XSS prevention

7. **Database Security**
   - WordPress WPDB (prepared statements)
   - SQL injection protection
   - Data sanitization (sanitize_text_field, sanitize_email)

## Extension Points

### Adding Custom Fields

1. Add HTML in `jb_job_app_render_form_block()`
2. Add validation in `jb_job_app_handle_submission()`
3. Save with `update_post_meta()`
4. Display in `jb_job_app_render_meta_box()`
5. Add column in `jb_job_app_custom_columns()`

### Email Notifications

```php
// Add to jb_job_app_handle_submission() after successful save
$to = get_option('admin_email');
$subject = 'New Job Application';
$message = "New application from {$first_name} {$last_name}";
wp_mail($to, $subject, $message);
```

### Application Status

```php
// Add custom taxonomy
register_taxonomy('application_status', 'job_application', [
    'labels' => [...],
    'hierarchical' => true,
    'show_admin_column' => true,
]);
```

## Performance Considerations

### Caching
- Block output is dynamic (no caching needed)
- Admin queries use standard WP_Query (cached by WordPress)

### File Storage
- Resumes stored in wp-content/uploads/
- Uses WordPress media library
- File paths stored in database (not file content)

### Database Queries
- Minimal custom queries
- Uses WordPress post system (optimized)
- Indexed by default (post_type, post_status)

### Asset Loading
- CSS only loaded when needed
- Block JS only in editor
- No jQuery dependency
- Minimal JavaScript footprint

## Browser Compatibility

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Gutenberg editor requirements
- HTML5 form validation
- CSS Grid and Flexbox

## Accessibility

- Semantic HTML
- Proper label associations
- Required field indicators
- ARIA attributes (from WordPress)
- Keyboard navigation support

## Internationalization

- All strings wrapped in translation functions
- Text domain: 'jb-job-application'
- Ready for translation
- Supports RTL languages (CSS structure)
