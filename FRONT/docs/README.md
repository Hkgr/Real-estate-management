# FRONT/docs Reference Files

This folder is reference-only.

It contains extracted Blade, CSS, and JavaScript files from a separate Laravel dashboard implementation.

Use these files only as a visual, Blade-structure, CSS, and UX reference for:

GET /viewer-new/reports/properties

Do not copy this reference project blindly.

Do not copy:
- routes
- controllers
- authentication
- database logic
- static JavaScript data
- full layout structure
- full CSS file
- full JavaScript file

The real implementation target remains:

- app/Http/Controllers/ViewerNew/Reports/PropertiesReportController.php
- resources/views/viewer-new/reports/properties.blade.php
- resources/css/viewer-new/app.css
- resources/js/viewer-new/app.js

Use FRONT/docs only to understand:
- visual hierarchy
- report page layout
- filter layout
- KPI/card layout
- table styling
- action button styling
- useful scoped JavaScript behavior

Any adapted CSS must be scoped under:

.viewer-new .vn-properties-report

Do not import dashboard-ar.css globally.
Do not paste dashboard-ar.js into the real app.
Do not edit or delete this folder unless explicitly requested.