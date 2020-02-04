
CREATE DATABASE IF NOT EXISTS dbbmx;

USE dbbmx;

DROP TABLE IF EXISTS tblriders;
DROP TABLE IF EXISTS tblsessions;
DROP TABLE IF EXISTS tblsessionriders;
DROP TABLE IF EXISTS tblclasses;


CREATE TABLE tblclasses
  (
    ClassId INTEGER PRIMARY KEY AUTO_INCREMENT,
    ClassName varchar(100),
    CoachId INTEGER(10),
    MaxRiders INTEGER(4),
    ClassTime varchar(50)
  );

INSERT INTO tblclasses (ClassName, CoachId, ClassTime, MaxRiders) 
VALUES ('Beginner', 3, 'Tue 5:00-6:00pm', 16),
  ('Intermediate', 3, 'Tue 6:00-7:00pm', 16),
  ('Off Track', 3, 'Tue 5:00-6:00pm', 16),
  ('Advanced', 2, 'Thu 6:30-8:00pm', 8),
  ('Girls only', 2, 'Thu 5:00-6:00pm', 8),
  ('Mums Class', 2, 'Sun 10:00-11:00am', 8),
  ('Beginner', 4, 'Sun 9:00-10:00am', 8),
  ('Bike maintenance', 2, 'Tue 5:00-6:00pm', 8),
  ('Advanced', 2, 'Tue 7:00-8:30pm', 8);  
  
CREATE TABLE tblriders
  (
    RiderId INTEGER PRIMARY KEY AUTO_INCREMENT,
    RiderType varchar(50),
    LicenceNum varchar(10),
    RiderName varchar(100),
    Gender varchar(10),
    ExpiryDate date,
    Phone varchar(20),
    Email varchar(100),
    ContactName varchar(100),
    ContactNum varchar(100),
    UserName varchar(100),
    Password varchar(50)
  );

INSERT INTO tblriders (RiderName, LicenceNum, Gender, ExpiryDate, Phone, ContactName, ContactNum, UserName, Email, Password, RiderType) 
VALUES ('Betty Bussle', '145689', 'female', '2017-04-30', '0340 873 093', 'Teddy Bussle', '0403 888 999', 'bbussle', 'bb@gmail.com', 'betty', 'Admin'),
  ('Layton Handle', '478654', 'male', '2017-09-30', '0340 123 093', 'Barney Fooseldorf', '0403 785 999', 'foose', 'foose@gmail.com', 'foose', 'Coach'),
  ('Thomas Tully', '789651', 'male', '2017-09-30', '0340 897 093', 'Wilma Tully', '0403 123 999', 'wilma', 'wilma@gmail.com', 'wilma', 'Coach'),
  ('Ellie Wanston', '785565', 'female', '2017-09-30', '0340 156 093', 'Barry Wanston', '0403 333 999', 'barry', 'barry@gmail.com', 'barry', 'Coach'),
  ('Mickey Duck', '123487', 'male', '2017-11-30', '0340 365 093', 'Deborah Duck', '0403 555 444', 'muck', 'md@gmail.com', 'muck', 'Rider'),
  ('Barney Rubble', '985632', 'male', '2017-11-30', '0340 154 093', 'Mr Rubble', '0403 555 333', 'rubble', 'rubble@gmail.com', 'rubble', 'Rider'),
  ('Gerturde Bubble', '755632', 'female', '2017-11-30', '0340 852 093', 'Brian Bubble', '0403 555 222', 'brian', 'brian@gmail.com', 'brian', 'Rider');


CREATE TABLE tblsessions
  (
  SessionId INTEGER PRIMARY KEY AUTO_INCREMENT,
  Class varchar(50),
  ClassId INTEGER(10),
  SessionDate DATE,
  SessionTime varchar(50),
  MaxRiders INTEGER(4)
  );

INSERT INTO tblsessions (Class, ClassId, SessionDate, SessionTime) 
VALUES ('Advanced skills', 3, '2017-05-02', '5:00pm'),
  ('Off track', 2, '2017-05-09', '5:00pm'),
  ('Mums class', 6, '2017-06-12', '10:00am'),
  ('Beginner', 1, '2017-06-16', '5:00pm');


CREATE TABLE tblsessionriders
  (
  SessionRiderId INTEGER PRIMARY KEY AUTO_INCREMENT,
  RiderId INTEGER(10),
  SessionId INTEGER(10),
  Comments LONGTEXT,
  Attended varchar(20)
  );

INSERT INTO tblsessionriders (RiderId, SessionId, Attended)
VALUES (5, 1, 'Yes'),
  (6, 1, 'Yes'),
  (7, 2, 'Yes');




