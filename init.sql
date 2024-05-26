-- Disable foreign key checks
SET foreign_key_checks = 0;

-- Drop eoi table if it exists
DROP TABLE IF EXISTS eoi;

-- Drop job_descriptions table if it exists
DROP TABLE IF EXISTS job_descriptions;

-- Re-enable foreign key checks
SET foreign_key_checks = 1;

-- Create job_descriptions table
CREATE TABLE IF NOT EXISTS job_descriptions (
    job_ref_number VARCHAR(5) PRIMARY KEY,
    job_title VARCHAR(100) NOT NULL,
    job_description TEXT NOT NULL
);

-- Create eoi table
CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    job_ref_number VARCHAR(5) NOT NULL,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    dob DATE NOT NULL CHECK (dob BETWEEN '1944-01-01' AND '2009-12-31'),
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    street_address VARCHAR(40) NOT NULL,
    suburb VARCHAR(40) NOT NULL,
    state ENUM('VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT') NOT NULL,
    postcode VARCHAR(4) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(12) NOT NULL,
    skill1 VARCHAR(50),
    skill2 VARCHAR(50),
    skill3 VARCHAR(50),
    other_skills TEXT,
    status ENUM('New', 'Current', 'Final') DEFAULT 'New',
    FOREIGN KEY (job_ref_number) REFERENCES job_descriptions(job_ref_number),
    CONSTRAINT chk_job_ref_number CHECK (job_ref_number REGEXP '^[A-Za-z0-9]{5}$'),
    CONSTRAINT chk_first_name CHECK (first_name REGEXP '^[a-zA-Z]{1,20}$'),
    CONSTRAINT chk_last_name CHECK (last_name REGEXP '^[a-zA-Z]{1,20}$'),
    CONSTRAINT chk_postcode CHECK (postcode REGEXP '^[0-9]{4}$'),
    CONSTRAINT chk_email CHECK (email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$'),
    CONSTRAINT chk_phone CHECK (phone REGEXP '^[0-9]{8,12}$'),
    INDEX idx_job_ref_number (job_ref_number),
    INDEX idx_first_name (first_name),
    INDEX idx_last_name (last_name),
    INDEX idx_status (status)
);-- Insert job descriptions
INSERT INTO job_descriptions (job_ref_number, job_title, job_description) VALUES
(
    'ABC12', 
    'Project Manager', 
    'As the IT Project Manager, you will play a pivotal role in driving the successful execution of our organization\'s IT projects. 
    You\'ll be responsible for overseeing the planning, implementation, and delivery of various IT initiatives, ensuring they align with the company\'s strategic objectives and meet the highest standards of quality.
    \n
    \n
    Salary range: $70,000 - $90,000
    \n
    \n
    Key Responsibilities
    \n
    \n
    - Lead and manage IT projects from initiation to completion, employing best practices in project management methodologies to ensure successful outcomes
    \n
    - Effectively coordinate project team members and allocate resources, fostering collaboration and accountability to achieve project goals within defined scope, schedule, and budget
    \n
    - Develop comprehensive project plans and timelines, identifying key milestones, deliverables, and dependencies to facilitate efficient project execution
    \n
    - Facilitate regular communication and reporting with stakeholders, providing timely updates on project progress, risks, and mitigation strategies
    \n
    - Proactively identify and address potential risks and issues, implementing appropriate solutions to keep projects on track and minimize disruptions
    \n
    - Continuously monitor and evaluate project performance, leveraging feedback and lessons learned to drive process improvements and optimize project delivery
    \n
    - Ensure compliance with regulatory requirements, industry standards, and company policies throughout the project lifecycle
    \n
    - Lead post-project reviews and lessons learned sessions to identify successes, challenges, and areas for improvement\n\nRequired Qualifications
    \n
    \n
    Essential:
    \n
    - Bachelor\'s degree in Computer Science, Information Technology, or related field
    \n- 
    Minimum of 3 years of proven experience in project management, with a successful track record of managing IT projects of varying size and complexity
    \n- 
    Strong understanding of project management methodologies and tools, with the ability to effectively apply them to drive project success
    \n
    \n
    Preferable:
    \n
    - Project Management Professional (PMP) certification or equivalent
    \n
    - Demonstrated experience with Agile methodologies and frameworks such as Scrum or Kanban
    \n
    - Excellent leadership, communication, and interpersonal skills, with the ability to effectively engage and collaborate with diverse stakeholders
    \n
    - Experience in leading cross-functional teams and managing stakeholders at all levels of the organization'
),
(
    'XYZ34', 
    'Frontend Developer', 
    'Join our dynamic team as a Frontend Developer and contribute to the creation of cutting-edge web applications that deliver exceptional user experiences. 
    You\'ll collaborate closely with cross-functional teams to design and develop innovative frontend solutions that meet the needs of our users and align with our brand identity.
    \n
    \n
    Salary range: $60,000 - $80,000\n\nKey Responsibilities
    \n
    \n
    - Design, develop, and maintain responsive and user-friendly frontend components of web applications, ensuring optimal performance, accessibility, and compatibility across various devices and browsers
    \n
    - Collaborate closely with UI/UX designers, backend developers, and other stakeholders to translate design mockups and requirements into functional, visually appealing user interfaces
    \n
    - Implement best practices and standards for frontend development, including code optimization, modularization, and documentation, to enhance maintainability and scalability of codebase
    \n
    - Stay updated on emerging trends and technologies in frontend development, evaluating and integrating new tools and frameworks to improve efficiency and enhance user experience
    \n
    - Contribute to the continuous improvement of development processes and workflows, actively participating in code reviews, knowledge sharing, and mentoring junior team members
    \n
    - Collaborate with QA engineers to ensure thorough testing of frontend components, identifying and resolving any bugs or issues in a timely manner
    \n
    - Provide technical guidance and support to internal teams and external partners, helping to troubleshoot and resolve frontend-related issues
    \n
    \n
    Required Qualifications
    \n
    \n
    Essential:
    \n
    - Proficiency in HTML, CSS, and JavaScript, with a strong foundation in frontend development principles and practices
    \n
    - Minimum of 2 years of hands-on experience in frontend development, with a portfolio showcasing your work and projects
    \n
    \n
    Preferable:
    \n
    - Experience with modern frontend frameworks and libraries such as React, Vue.js, or Angular, and proficiency in related technologies like TypeScript
    \n
    - Knowledge of UI/UX design principles and usability concepts, with the ability to collaborate effectively with designers to create intuitive and visually appealing interfaces
    \n
    - Strong problem-solving and analytical skills, with a passion for learning and adapting to new technologies and methodologies
    \n
    - Experience with version control systems such as Git and familiarity with CI/CD pipelines'
);


