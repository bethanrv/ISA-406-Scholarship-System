# ISA-406-Scholarship-System
ISA Department Scholarship Application Website

### Stack Details 
 - Front-end: No framework used (html/css/js included in directory 'front-end')
 - Back-end: WAMPS Server (PHP webmethods)
  + Database stored as csv files in directory 'back-end'
  
### Implementation Details
 - Student Applications: Froms handled in index.html file and passed to writeStudent.php and addFiles.php to write in student info
 - Admininstator View: Admin.html collects student info from back-end csvs and displays them in datatable
  + Searching/sorting/downloading results also availbale through admin.html
  + Admin username and password additionally stored in back-end
 
### Testing/Implementation
 - Move files in this repository to the folder 'www' in WAMPS
 - Base page is for student applications
 - Admin page can be accessed via admin_login page with valid credentials
