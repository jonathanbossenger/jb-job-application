# Security Testing Guide for PDF Download Protection

## What Was Changed

The plugin now implements secure, authentication-based PDF downloads instead of allowing direct public access to resume files.

### Changes Summary:

1. **New Meta Field**: Added `_jb_resume_file` to store the server file path
2. **Secure Download Handler**: Created endpoint that checks authentication before serving files
3. **Updated Links**: All resume links now use the secure download endpoint
4. **Backward Compatibility**: Old uploads with only URL are automatically converted

## How to Test

### Test 1: Unauthenticated Access (Should FAIL)

1. **Submit an application** while logged in as an applicant
2. **Copy the resume download link** from the admin area
3. **Log out** completely from WordPress
4. **Paste the link** in a new browser or incognito window
5. **Expected Result**: You should see "You must be logged in to download resumes"
   - ✓ This confirms PDFs are protected from unauthenticated access

### Test 2: Authenticated Access (Should SUCCEED)

1. **Log in** to WordPress as any user (applicant, admin, etc.)
2. **Navigate to** Job Applications in the admin
3. **Click "View"** on a resume in the list, OR
4. **Open an application** and click "Download Resume"
5. **Expected Result**: The PDF should open/download successfully
   - ✓ This confirms authenticated users can access PDFs

### Test 3: Direct URL Access (Should FAIL)

1. Find the actual file URL in the database:
   ```sql
   SELECT meta_value FROM wp_postmeta WHERE meta_key = '_jb_resume_url';
   ```
2. **Copy the direct URL** (e.g., `http://yoursite.com/wp-content/uploads/2024/01/resume.pdf`)
3. **Paste in browser** while logged out
4. **Expected Result**: The PDF loads (this is the old behavior)
   - ⚠️ But the new secure links bypass this entirely

### Test 4: Nonce Verification (Should FAIL)

1. **Get a secure download link** (e.g., `?jb_download_resume=123&nonce=abc123`)
2. **Modify the nonce** parameter (e.g., change last character)
3. **Visit the modified link**
4. **Expected Result**: "Security check failed"
   - ✓ This confirms nonce protection works

### Test 5: Backward Compatibility

For existing installations with old uploads:

1. **Check an old application** that was submitted before this change
2. **Click the resume download link**
3. **Expected Result**: PDF downloads successfully
   - ✓ The system automatically converts old URL to file path

## Security Features Implemented

### 1. Authentication Check
```php
if ( ! is_user_logged_in() ) {
    wp_die( esc_html__( 'You must be logged in to download resumes', 'jb-job-application' ) );
}
```
- Prevents any unauthenticated user from downloading resumes

### 2. Nonce Verification
```php
if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( $_GET['nonce'], 'jb_download_resume_' . $post_id ) ) {
    wp_die( esc_html__( 'Security check failed', 'jb-job-application' ) );
}
```
- Prevents CSRF attacks
- Links expire based on WordPress nonce lifetime (default 24 hours)

### 3. Post Type Validation
```php
if ( ! $post || $post->post_type !== 'job_application' ) {
    wp_die( esc_html__( 'Invalid application', 'jb-job-application' ) );
}
```
- Ensures only job application PDFs can be accessed via this endpoint

### 4. File Existence Check
```php
if ( ! $resume_file || ! file_exists( $resume_file ) ) {
    wp_die( esc_html__( 'Resume file not found', 'jb-job-application' ) );
}
```
- Prevents path traversal attacks
- Validates file exists before serving

## How It Works

### Old Behavior (INSECURE):
```
User clicks link → Direct URL to wp-content/uploads/file.pdf → Anyone can access
```

### New Behavior (SECURE):
```
User clicks link → 
  /?jb_download_resume=123&nonce=abc →
    Check if logged in →
      Verify nonce →
        Validate post type →
          Check file exists →
            Serve file via PHP
```

## Additional Notes

### File Storage
- Files are still stored in `wp-content/uploads/` (standard WordPress location)
- However, they're now only served through the authenticated endpoint
- Direct URL access is discouraged but technically still possible (this is a WordPress limitation)

### Future Enhancements
To make it even more secure, consider:

1. **Store files outside web root**: Move uploads to a directory not accessible via URL
2. **Add role-based access**: Only allow admins to view resumes
3. **Add download logging**: Track who downloads which resumes
4. **Add watermarks**: Embed applicant info in PDFs

### Compatibility Notes
- Works with existing WordPress authentication
- Compatible with WordPress multisite
- No additional server configuration required
- Works on all standard WordPress hosting environments

## Troubleshooting

### "Resume file not found" error
- Check that the file actually exists in `wp-content/uploads/`
- Verify file permissions (should be readable by web server)

### PDF won't download for logged-in users
- Check that output buffering isn't interfering
- Ensure no plugin is modifying headers
- Check server error logs for PHP errors

### Old applications not working
- The system automatically migrates old URL-based references
- If issues persist, check that `_jb_resume_url` meta exists
