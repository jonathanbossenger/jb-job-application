# Visual Guide - JB Job Application Plugin

## Frontend - Login Required View

When a non-authenticated user visits a page with the Job Application Form block:

```
┌─────────────────────────────────────────────────┐
│                                                 │
│  ⚠ Please log in to submit a job application.  │
│     Log in | Register                           │
│                                                 │
└─────────────────────────────────────────────────┘
```

## Frontend - Application Form (Authenticated Applicant)

When an authenticated applicant views the form:

```
┌─────────────────────────────────────────────────┐
│  Job Application Form                           │
├─────────────────────────────────────────────────┤
│                                                 │
│  First Name *                                   │
│  [_________________________________]            │
│                                                 │
│  Last Name *                                    │
│  [_________________________________]            │
│                                                 │
│  Email *                                        │
│  [_________________________________]            │
│                                                 │
│  Phone *                                        │
│  [_________________________________]            │
│                                                 │
│  Resume (PDF only) *                            │
│  [Choose File] No file chosen                   │
│  Maximum file size: 5MB                         │
│                                                 │
│  [  Submit Application  ]                       │
│                                                 │
└─────────────────────────────────────────────────┘
```

## Frontend - Success Message

After successful submission:

```
┌─────────────────────────────────────────────────┐
│                                                 │
│  ✓ Your application has been submitted         │
│    successfully!                                │
│                                                 │
└─────────────────────────────────────────────────┘
```

## Block Editor View

When editing a page in Gutenberg:

```
┌─────────────────────────────────────────────────┐
│  ┌─────────────────────────────────────────┐   │
│  │                                         │   │
│  │      Job Application Form               │   │
│  │                                         │   │
│  │  This form will be displayed to         │   │
│  │  authenticated applicants on the        │   │
│  │  frontend.                              │   │
│  │                                         │   │
│  └─────────────────────────────────────────┘   │
└─────────────────────────────────────────────────┘
```

## Admin Dashboard - Applications List

WordPress Admin → Job Applications:

```
┌──────────────────────────────────────────────────────────────────────┐
│  Job Applications                                         [ Add New ] │
├──────────────────────────────────────────────────────────────────────┤
│  □  Applicant Name    Email              Phone         Resume  Date  │
├──────────────────────────────────────────────────────────────────────┤
│  □  John Doe          john@email.com     555-1234      View    Oct 3 │
│  □  Jane Smith        jane@email.com     555-5678      View    Oct 2 │
│  □  Bob Johnson       bob@email.com      555-9012      View    Oct 1 │
└──────────────────────────────────────────────────────────────────────┘
```

## Admin Dashboard - Single Application View

When clicking on an application:

```
┌─────────────────────────────────────────────────┐
│  Edit Job Application                           │
├─────────────────────────────────────────────────┤
│                                                 │
│  John Doe                                       │
│                                                 │
│  ┌─ Application Details ────────────────────┐  │
│  │                                          │  │
│  │  First Name:    John                     │  │
│  │  Last Name:     Doe                      │  │
│  │  Email:         john@email.com           │  │
│  │  Phone:         555-1234                 │  │
│  │  Resume:        Download Resume          │  │
│  │  Submitted:     2024-10-03 12:30:45      │  │
│  │                                          │  │
│  └──────────────────────────────────────────┘  │
│                                                 │
└─────────────────────────────────────────────────┘
```

## Color Scheme

- Success messages: Green (#d4edda background, #155724 text)
- Warning/Info messages: Yellow (#fff3cd background, #856404 text)
- Primary button: Blue (#2271b1)
- Form borders: Light gray (#ddd)
- Required field indicator: Red (#d63638)

## Responsive Design

The form is fully responsive and will adapt to different screen sizes:
- Mobile: Single column, full width inputs
- Tablet/Desktop: Centered form with max-width of 600px
- All devices: Touch-friendly input sizes
