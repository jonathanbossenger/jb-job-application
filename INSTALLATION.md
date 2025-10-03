# Installation & Testing Guide

## Prerequisites

- WordPress 5.8 or higher
- PHP 7.4 or higher
- Write permissions for uploads directory
- User registration enabled in WordPress

## Installation Steps

### Method 1: Direct Upload (Recommended for Production)

1. **Download or Clone** the repository
   ```bash
   git clone https://github.com/jonathanbossenger/jb-job-application.git
   ```

2. **Upload to WordPress**
   - Upload the entire `jb-job-application` folder to `/wp-content/plugins/`
   - Or zip the folder and upload via WordPress admin

3. **Activate Plugin**
   - Go to WordPress Admin → Plugins
   - Find "JB Job Application"
   - Click "Activate"

4. **Enable User Registration**
   - Go to Settings → General
   - Check "Anyone can register"
   - Set "New User Default Role" to "Subscriber" (will be overridden to "Applicant")
   - Click "Save Changes"

### Method 2: Development Setup

1. **Clone Repository**
   ```bash
   cd /path/to/wordpress/wp-content/plugins/
   git clone https://github.com/jonathanbossenger/jb-job-application.git
   cd jb-job-application
   ```

2. **Install Dependencies**
   ```bash
   npm install
   ```

3. **Build Block Assets**
   ```bash
   npm run build
   ```

4. **Activate Plugin**
   - Follow steps 3-4 from Method 1

## Configuration

### Required Settings

1. **Permalink Structure**
   - Go to Settings → Permalinks
   - Choose any structure except "Plain"
   - Save changes

2. **Upload Directory**
   - Ensure `/wp-content/uploads/` is writable
   - Test by uploading an image through Media Library

### Optional Settings

1. **Email Notifications**
   - Currently not implemented
   - Can be added as future enhancement

2. **CAPTCHA**
   - Not included
   - Can be added for spam prevention

## Testing Checklist

### Phase 1: Plugin Activation

- [ ] Plugin activates without errors
- [ ] "Job Applications" menu appears in admin
- [ ] No PHP errors in debug log
- [ ] Applicant role is created

#### Verification Commands:
```php
// Check if role exists
$role = get_role('applicant');
var_dump($role);

// Check if post type is registered
$post_type = get_post_type_object('job_application');
var_dump($post_type);
```

### Phase 2: Block Functionality

- [ ] Block appears in block inserter
- [ ] Block can be inserted into page/post
- [ ] Block editor shows placeholder
- [ ] Page saves without errors
- [ ] Frontend renders correctly

#### Test Steps:
1. Create new page
2. Add "Job Application Form" block
3. Publish page
4. View page on frontend

### Phase 3: User Registration & Login

- [ ] Registration form is accessible
- [ ] New users get "applicant" role
- [ ] Login works correctly
- [ ] Applicant can access form

#### Test Steps:
1. Logout of admin
2. Go to `/wp-login.php?action=register`
3. Register new account (username: testapplicant)
4. Check role in database or admin

#### SQL Verification:
```sql
SELECT * FROM wp_usermeta 
WHERE meta_key = 'wp_capabilities' 
AND user_id = [new_user_id];
```

### Phase 4: Form Display

Test different user states:

- [ ] **Not logged in**: Shows login/register message
- [ ] **Wrong role**: Shows role requirement message
- [ ] **Applicant role**: Shows full form
- [ ] **Administrator**: Shows full form

#### Test Matrix:
| User State      | Expected Display                |
|----------------|----------------------------------|
| Anonymous      | Login/Register links            |
| Subscriber     | Role requirement message        |
| Applicant      | Full application form           |
| Administrator  | Full application form           |

### Phase 5: Form Submission

- [ ] All required fields enforced
- [ ] Email validation works
- [ ] PDF file type validated
- [ ] File size limit enforced (5MB)
- [ ] Non-PDF files rejected
- [ ] Success message displays

#### Test Cases:

**Valid Submission:**
```
First Name: John
Last Name: Doe
Email: john@example.com
Phone: 555-1234
Resume: valid-resume.pdf (< 5MB)
Expected: Success ✓
```

**Invalid Email:**
```
Email: notanemail
Expected: Error ✗
```

**Wrong File Type:**
```
Resume: document.docx
Expected: Error ✗
```

**File Too Large:**
```
Resume: huge-file.pdf (> 5MB)
Expected: Error ✗
```

### Phase 6: Admin Dashboard

- [ ] Applications appear in admin list
- [ ] All columns display correctly
- [ ] Application details are viewable
- [ ] Resume download link works
- [ ] Cannot manually create applications

#### Verification Steps:
1. Login as administrator
2. Go to "Job Applications"
3. Verify list shows submitted applications
4. Click on an application
5. Check all fields display
6. Click resume download link

### Phase 7: Security Tests

- [ ] Nonce verification works
- [ ] Non-logged users can't submit
- [ ] Direct POST blocked without nonce
- [ ] File upload outside form blocked
- [ ] SQL injection protected

#### Security Test Commands:
```bash
# Try to submit without nonce
curl -X POST http://yoursite.com/application-page \
  -d "jb_submit_application=1" \
  -d "jb_first_name=Test"

# Expected: Security check failed
```

### Phase 8: Edge Cases

- [ ] Form handles special characters in names
- [ ] International phone numbers accepted
- [ ] Email with + character works
- [ ] Unicode filenames handled
- [ ] Multiple rapid submissions handled

#### Test Cases:
```
Names with apostrophes: O'Brien, D'Angelo
Names with hyphens: Smith-Jones
International phones: +1-555-1234, (555) 123-4567
Emails: user+tag@domain.com, user.name@domain.co.uk
```

### Phase 9: Performance

- [ ] Form loads quickly
- [ ] File upload completes in reasonable time
- [ ] Admin list handles 100+ applications
- [ ] No memory issues with uploads

#### Performance Benchmarks:
- Page load: < 2 seconds
- File upload (2MB): < 5 seconds
- Admin list (100 items): < 3 seconds

## Troubleshooting

### Plugin Won't Activate
```bash
# Check PHP version
php -v

# Check for syntax errors
php -l jb-job-application.php

# Check WordPress version
wp core version
```

### Block Not Appearing
```bash
# Rebuild assets
npm run build

# Clear WordPress cache
wp cache flush

# Check browser console for JS errors
```

### File Upload Fails
```bash
# Check upload directory permissions
ls -la wp-content/uploads/

# Check PHP upload limits
php -i | grep upload_max_filesize
php -i | grep post_max_size

# Increase limits in php.ini if needed:
upload_max_filesize = 10M
post_max_size = 10M
```

### Applications Not Saving
```bash
# Enable debug mode
# Add to wp-config.php:
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

# Check debug.log
tail -f wp-content/debug.log
```

## Uninstallation

1. **Deactivate Plugin**
   - Go to Plugins page
   - Click "Deactivate"

2. **Optional: Remove Data**
   ```sql
   -- Delete applications
   DELETE FROM wp_posts WHERE post_type = 'job_application';
   DELETE FROM wp_postmeta WHERE post_id IN (
     SELECT ID FROM wp_posts WHERE post_type = 'job_application'
   );
   
   -- Remove applicant role
   -- Done automatically by WordPress when plugin is deleted
   ```

3. **Delete Plugin Files**
   - Click "Delete" on plugins page
   - Or manually remove from wp-content/plugins/

## Next Steps After Testing

- [ ] Customize form styling
- [ ] Add email notifications
- [ ] Implement application status workflow
- [ ] Add export functionality
- [ ] Set up automated backups
- [ ] Configure CAPTCHA if needed
- [ ] Add custom email templates
- [ ] Set up admin notification preferences

## Support Resources

- Plugin Documentation: README.md
- Usage Guide: USAGE.md
- Visual Guide: VISUAL-GUIDE.md
- GitHub Issues: [Repository URL]
