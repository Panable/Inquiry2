
# Assignment Requirements and Rubric Alignment

## A. Specified Requirements (70 marks total)

### 1. PHP Include and Table Structure (5 marks)
- **Highest Mark Criteria (5 marks):** Implement all requirements with high quality and follow the in-house standard.
- **Requirements:**
  - Use PHP to modularize and reuse common web application code (menu, header, footer).
  - Create and include files with a `.inc` extension.
  - Ensure the web pages are renamed with a `.php` extension.

### 2. Process Page (20 marks)
- **Highest Mark Criteria (17-20 marks):** Implement all requirements with high quality and follow the in-house standard.
- **Requirements:**
  - Create `processEOI.php` to add EOI records to the table.
  - Ensure server-side validation and data sanitization.
  - Implement server-side data format checking (e.g., Job Reference number, Name, Age, Address, Email, Phone number, etc.).
  - Display confirmation with the unique auto-generated EOInumber.
  - Ensure the table is programmatically created if it doesn't exist.
  - Redirect if accessed directly via URL.

### 3. Manage Page (10 marks)
- **Highest Mark Criteria (9-10 marks):** Implement all requirements with high quality and follow the in-house standard.
- **Requirements:**
  - Create `manage.php` to allow HR managers to:
    - List all EOIs.
    - List EOIs by job reference number.
    - List EOIs by applicant name.
    - Delete EOIs by job reference number.
    - Change the status of an EOI.

### 4. Enhancements (10 marks)
- **Highest Mark Criteria (9-10 marks):** Excellent enhancements that enhance the functionality of the website and are technically advanced.
- **Possible Enhancements:**
  - Store job descriptions in a database table and dynamically create HTML using PHP.
  - Normalize dataset structure with primary-foreign key links.
  - Provide sorting options for EOI records.
  - Implement manager registration with unique username, password rules, and access control.
  - Create a logout page with proper session handling.

### 5. Video Demonstration (5 marks)
- **Highest Mark Criteria (5 marks):** Demonstrate excellent knowledge of the project with a highly creative and accomplished presentation.
- **Requirements:**
  - Create a 4-5 minute video demonstrating the web application.
  - Ensure all team members present for a similar amount of time.
  - Upload the video to YouTube and include a hyperlink in `index.html`.

## B. Individual Report (30 marks total)

### 1. Overall Presentation of Report (10 marks)
- **Highest Mark Criteria (9-10 marks):** Professional, clear, easy to follow, well-structured, cohesive, and reader-friendly.
- **Requirements:**
  - Follow the suggested structure: Cover Page, Introduction, Website, Security, Contribution, Reflection and Discussion, Conclusion, References, Appendix.

### 2. Research on Security (15 marks)
- **Highest Mark Criteria (13-15 marks):** Comprehensive research with at least 8 citations and at least 5 points of improvements discussed.
- **Requirements:**
  - Research ways to improve website security.
  - Implement security tips in your code and website.

### 3. The Website (5 marks)
- **Highest Mark Criteria (5 marks):** Provide detailed information on the functionality and technical details of the website.
- **Requirements:**
  - Include website introduction, main functionalities, technical details, and screenshots.

### 4. Your Contribution (10 marks)
- **Highest Mark Criteria (10 marks):** Clearly list and discuss contributions, including challenges in group work.
- **Requirements:**
  - List and discuss your main contributions to the project.

### 5. Reflection and Comments (10 marks)
- **Highest Mark Criteria (9-10 marks):** Deep commitment to reflection, convincing and critical discussions on web development issues.
- **Requirements:**
  - Reflect on your experience, teamwork, and effective communication.
  - Discuss web development issues such as privacy, security, environmental sustainability, commercial or social issues.



# Website Requirements Checklist

## Requirement

### HTML Menus and Common Elements
- [ ] Created and included using PHP

### EOI Table
- [ ] Schema can store the necessary information

### processEOI.php
- [ ] Records added from website
- [ ] Table automatically created if it does not exist when accessed
- [ ] Status added = New
- [ ] EOInumber programmatically generated
- [ ] Redirect if tried to access directly via URL

### Data Sanitisation and Format Checking (at server)
- [ ] JobRefNo
- [ ] Name
- [ ] Age format
- [ ] Age range
- [ ] Address/suburb
- [ ] State
- [ ] Pcode
- [ ] State-pcd match
- [ ] Email
- [ ] Phone
- [ ] Other skills not empty if checked

### manage.php
- [ ] HTML well presented
- [ ] List all EOIs
- [ ] List all EOIs for a particular position (given Ref num)
- [ ] List all EOIs for a particular applicant given firstname, lastname, or both
- [ ] Change the status of an EOI for a particular applicant
- [ ] Delete all EOIs with a specified job reference number

## Other Deductions

### PHP and HTML
- [ ] Invalid HTML
- [ ] Meta-data does not follow in-house standard
- [ ] HTML has Style information embedded
- [ ] HTML form elements do not follow in-house standard
- [ ] Deprecated elements/attributes used
- [ ] Inadequate comments
- [ ] Lack of appropriate header comments as per in-house standard
- [ ] Lack of appropriate line comments
- [ ] Uses commands other than mysqli

### Website
- [ ] Directory structure not as specified, absolute links
- [ ] Third party content inadequately acknowledged
- [ ] Other deductions (no progress check)
