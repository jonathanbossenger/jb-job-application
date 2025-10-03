#!/bin/bash

# Simple verification script for JB Job Application Plugin

echo "=== JB Job Application Plugin - Structure Verification ==="
echo ""

# Check if main plugin file exists
if [ -f "jb-job-application.php" ]; then
    echo "✓ Main plugin file exists"
else
    echo "✗ Main plugin file missing"
    exit 1
fi

# Check PHP syntax
if php -l jb-job-application.php > /dev/null 2>&1; then
    echo "✓ PHP syntax is valid"
else
    echo "✗ PHP syntax errors found"
    exit 1
fi

# Check for required directories
directories=("assets/css" "src" "build")
for dir in "${directories[@]}"; do
    if [ -d "$dir" ]; then
        echo "✓ Directory $dir exists"
    else
        echo "✗ Directory $dir missing"
    fi
done

# Check for required files
files=(
    "assets/css/frontend.css"
    "src/index.js"
    "src/editor.css"
    "src/style.css"
    "build/index.js"
    "build/index.css"
    "build/style-index.css"
    "package.json"
    "README.md"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "✓ File $file exists"
    else
        echo "✗ File $file missing"
    fi
done

# Check for key functions in main file
functions=(
    "jb_job_app_activate"
    "jb_job_app_deactivate"
    "jb_job_app_add_applicant_role"
    "jb_job_app_register_post_type"
    "jb_job_app_render_form_block"
    "jb_job_app_handle_submission"
)

echo ""
echo "Checking for required functions..."
for func in "${functions[@]}"; do
    if grep -q "function $func" jb-job-application.php; then
        echo "✓ Function $func found"
    else
        echo "✗ Function $func missing"
    fi
done

echo ""
echo "=== Verification Complete ==="
