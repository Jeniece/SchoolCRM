/*Insert student data*/

INSERT INTO parent(email, password, activated, title, fname, mname, lname, age, landline, mobile, nationality, marital_status, address, business_name, business_address, business_phone, occupation, annual_income, gender, hasRegisteredStudent, hasCompletedInfo)
VALUES('test@test.com', 'testpassword', 1, 'Mr', 'Test', 'Tester', 'Testing', 25, '12345678970', '12345678970', 'Barbadian', 'single', 'Testing testing lane', 'Test business', 'Testing business address', '12345678970', 'Tester', '50000', 'male', true, true );

INSERT INTO student(fname, mname, lname, age, gender, religion, nationality, is_complete, enrollment_year, is_accepted, status, birth_certificate, photo_id)
  VALUES('Jeniece', 'Dionne', 'Skeete', 15, 'female', 'Christian', 'Barbadian', true, 2017, true, 'accepted', '../student/documents/test_photo.png', '../student/documents/test_document_id.png');

INSERT INTO student(fname, mname, lname, age, gender, religion, nationality, is_complete, enrollment_year, is_accepted, status, birth_certificate, photo_id)
  VALUES('Susan', 'George', 'Bones', 14, 'female', 'Muslim', 'American', true, 2017, false, 'pending', '../student/documents/test_photo.png', '../student/documents/test_document_id.png');

INSERT INTO student(fname, mname, lname, age, gender, religion, nationality, is_complete, enrollment_year, is_accepted, status, birth_certificate, photo_id)
  VALUES('Derrick', 'Ramon', 'Rose', 12, 'male', 'Atheist', 'Guya', true, 2017, true, 'accepted', '../student/documents/test_photo.png', '../student/documents/test_document_id.png');

/*Insert news*/
INSERT INTO news(article, title, created) VALUES('Lorem ipsum dolor emmet test article', 'Test Article', 1497587177);
INSERT INTO news(article, title, created) VALUES('Lorem ipsum dolor emmet test test test article 2', 'Test Article 2', 1497587177);
INSERT INTO news(article, title, created) VALUES('Lorem ipsum dolor emmet test test test article 3', 'Test Article 3', 1497587177);

INSERT INTO subject(name) VALUES('Mathematics');
INSERT INTO subject(name) VALUES('English');
INSERT INTO subject(name) VALUES('Spanish');

INSERT INTO studentparent(student_id, parent_id, relation) VALUES(1, 1, 'father');

INSERT INTO studentsubject(student_id, subject_id, percentage, grade, academic_year, notes) VALUES (1, 1, 75, 'A', 2017, 'Good job!');
INSERT INTO studentsubject(student_id, subject_id, percentage, grade, academic_year, notes) VALUES (1, 2, 95, 'A', 2017, 'Excellent!');
INSERT INTO studentsubject(student_id, subject_id, percentage, grade, academic_year, notes) VALUES (1, 3, 65, 'A', 2017, 'Need to do better.');

INSERT INTO studentsubject(student_id, subject_id, percentage, grade, academic_year, notes) VALUES (1, 1, 85, 'A', 2017, 'Great job!');
INSERT INTO studentsubject(student_id, subject_id, percentage, grade, academic_year, notes) VALUES (1, 2, 75, 'A', 2017, 'Good job!');
INSERT INTO studentsubject(student_id, subject_id, percentage, grade, academic_year, notes) VALUES (1, 3, 95, 'A', 2017, 'Excellent!');

INSERT INTO survey(file_path, created, name) VALUES ('../surveys/test.txt', 1497587177, 'TestSurvey');
-- INSERT INTO student() VALUES()
-- INSERT INTO student() VALUES()
-- INSERT INTO student() VALUES()
-- INSERT INTO student() VALUES()
