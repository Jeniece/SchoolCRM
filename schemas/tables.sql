CREATE TABLE if not exists parent (
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email varchar(255) NOT NULL UNIQUE,
  password varchar(255) NOT NULL,
  activated boolean default false,
  title varchar(255) default NULL,
  fname varchar(255) default NULL,
  mname varchar(255) default NULL,
  lname varchar(255) default NULL,
  age int default NULL,
  landline varchar(255) default NULL,
  mobile varchar(255) default NULL,
  nationality varchar(255) default NULL,
  marital_status varchar(255) default NULL,
  address varchar(255) default NULL,
  business_name varchar(255) default NULL,
  business_address varchar(255) default NULL,
  business_phone varchar(255) default NULL,
  occupation varchar(255) default NULL,
  annual_income varchar(255) default NULL,
  gender varchar(255) default NULL,
  hasRegisteredStudent boolean default false,
  hasCompletedInfo boolean default false
);

CREATE TABLE if not exists student (
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  fname varchar(255) default NULL,
  mname varchar(255) default NULL,
  lname varchar(255) default NULL,
  age int default NULL,
  gender varchar(255) default NULL,
  religion varchar(255) default NULL,
  nationality varchar(255) default NULL,
  is_complete boolean default false,
  enrollment_year int NOT NULL,
  is_accepted boolean default false,
  status varchar(10) default 'pending',
  birth_certificate text,
  photo_id text
);

CREATE TABLE if not exists studentparent (
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id int default NULL,
  parent_id int default NULL,
  relation varchar(255) default NULL
);

CREATE TABLE if not exists token (
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email varchar(255) NOT NULL,
  token varchar(255) NOT NULL,
  created bigint UNSIGNED NOT NULL
);

CREATE TABLE if not exists teacher (
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  fname varchar(255) default NULL,
  lname varchar(255) default NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  is_active boolean default false
);

CREATE TABLE if not exists survey(
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  file_path varchar(255) NOT NULL,
  created bigint UNSIGNED NOT NULL,
  name varchar(255) NOT NULL
);

CREATE TABLE if not exists news(
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  article varchar(255) NOT NULL,
  created bigint UNSIGNED NOT NULL,
  title varchar(255) NOT NULL
);

CREATE TABLE if not exists subject(
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) NOT NULL
);

CREATE TABLE if not exists studentsubject(
  id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id int NOT NULL,
  subject_id int NOT NULL,
  percentage float NOT NULL,
  grade varchar(255) NOT NULL,
  academic_year int NOT NULL,
  notes text default NULL
);
