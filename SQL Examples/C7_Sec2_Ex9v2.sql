/*	Course 7 - Database and SQL
	Section 2 #9 DRILL: SQL Drill
	
	--Database Script--
	This script was used to create a Database titled 'C7Sec2Drill9'
	to use for this drill.  Each table created was then populated with
	"junk data" per the specifications listed in the drill instructions.
	
	I enhanced the organization that was described in the database diagram in
	the drill instructions by creating an AuthorID for the Books table.  In this
	way, the authors do not need to be listed multiple times within their own
	table (same with the Publishers table), thus making the database more 
	efficient in its use of memory.
	
	I also attempted to establish Primary Keys and Foreign Keys relationships
	between the tables; I had to look up (and through some trial and error) the
	syntax for the Foreign Key relationships.  I know it wasn't a requirement, but
	I wanted to see if I could do it. :-)
	
	You will notice that I did not take the time to populate the Publishers table;
	I think I spent way too much time on this drill and I decided to not take the 
	time to look up all the publishers for the books I chose, since it the table 
	does not seem to be utilized in the query exercises in the drill.  I hope this
	is OK.
*/
USE master
GO

CREATE DATABASE C7Sec2Drill9
GO

USE C7Sec2Drill9
GO

CREATE TABLE BookAuthors (
	AuthorID INT PRIMARY KEY,
	FirstName VARCHAR(30) NULL,
	LastName VARCHAR(50) NOT NULL );
GO

INSERT INTO BookAuthors VALUES
	(10, NULL, 'Tolkien'),
	(21, NULL, 'Lewis'),
	(72, 'Mark', 'Lee'),
	(63, 'Stephen', 'King'),
	(42, 'James', 'Patterson'),
	(55, 'John', 'Grisham'),
	(34, 'Terry', 'Brooks'),
	(77, 'Suzanne', 'Collins'),
	(84, 'Jerry', 'Jenkins'),
	(87, 'Frank', 'Peretti')
GO

CREATE TABLE Publishers (
	PubID INT PRIMARY KEY,
	PublisherName VARCHAR(80) NOT NULL,
	[Address] VARCHAR(60) NULL,
	Phone VARCHAR(20) NULL );
GO

CREATE TABLE Books (
	BookID INT PRIMARY KEY,
	Title VARCHAR(75) NOT NULL,
	AuthorID INT FOREIGN KEY(AuthorID)
		REFERENCES BookAuthors(AuthorID),
	PubID INT FOREIGN KEY(PubID)
		REFERENCES Publishers(PubID) );
GO

INSERT INTO Books VALUES
	(101, 'The Fellowship of the Ring', 10, NULL),
	(102, 'The Two Towers', 10, NULL),
	(103, 'The Return of the King', 10, NULL),
	(201, 'The Lion, the Witch, and the Wardrobe', 21, NULL),
	(202, 'Prince Caspian', 21, NULL),
	(203, 'The Voyage of the Dawn Treader', 21, NULL),
	(204, 'The Silver Chair', 21, NULL),
	(205, 'The Horse and His Boy', 21, NULL),
	(206, 'The Magician''s Nephew', 21, NULL),
	(207, 'The Last Battle', 21, NULL),
	(729, 'The Lost Tribe', 72, NULL),
	(345, 'The Shining', 63, NULL),
	(349, 'Under the Dome', 63, NULL),
	(423, 'Hope to Die', 42, NULL),
	(425, 'Maximum Ride: The Angel Experiment', 42, NULL),
	(427, 'Along Came a Spider', 42, NULL),
	(512, 'The Firm', 55, NULL),
	(515, 'The Rainmaker', 55, NULL),
	(519, 'The Runaway Jury', 55, NULL),
	(134, 'The Sword of Shannara', 34, NULL),
	(135, 'The Elfstones of Shannara', 34, NULL),
	(136, 'The Heritage of Shannara', 34, NULL),
	(247, 'The Hunger Games', 77, NULL),
	(248, 'Catching Fire', 77, NULL),
	(249, 'Mockingjay', 77, NULL),
	(801, 'Left Behind', 84, NULL),
	(802, 'Tribulation Force', 84, NULL),
	(803, 'Nicolae', 84, NULL),
	(804, 'Soul Harvest', 84, NULL),
	(805, 'Apollyon', 84, NULL),
	(806, 'Assassins', 84, NULL),
	(807, 'The Indwelling', 84, NULL),
	(808, 'The Mark', 84, NULL),
	(809, 'The Desecration', 84, NULL),
	(810, 'The Remnant', 84, NULL),
	(811, 'Armageddon', 84, NULL),
	(812, 'Glorious Appearing', 84, NULL),
	(813, 'Kingdom Come', 84, NULL),
	(850, 'This Present Darkness', 87, NULL),
	(851, 'Piercing the Darkness', 87, NULL),
	(855, 'The Oath', 87, NULL),
	(856, 'The Visitation', 87, NULL),
	(858, 'The Door in the Dragon''s Throat', 87, NULL)
GO
	
CREATE TABLE LibraryBranch (
	BranchID INT PRIMARY KEY,
	BranchName VARCHAR(80) NOT NULL,
	[Address] VARCHAR(60) NOT NULL );
GO

INSERT INTO LibraryBranch VALUES
	(111, 'Central', '111 NE First Ave.'),
	(222, 'Midway', '222 NW Second St.'),
	(333, 'Sharpstown', '333 SW Third Blvd.'),
	(444, 'Highville', '444 SE Fourth Parkway')
GO

CREATE TABLE BookCopies (
	BookID INT FOREIGN KEY(BookID)
		REFERENCES Books(BookID),
	BranchID INT FOREIGN KEY(BranchID)
		REFERENCES LibraryBranch(BranchID),
	NumCopies INT NULL );
GO

INSERT INTO BookCopies VALUES
	(101, 111, 2),
	(101, 222, 3),
	(101, 444, 5),
	(102, 111, 2),
	(102, 333, 2),
	(103, 111, 2),
	(103, 444, 3),
	(201, 222, 2),
	(201, 333, 2),
	(202, 222, 2),
	(202, 333, 3),
	(203, 222, 3),
	(203, 333, 2),
	(203, 444, 2),
	(204, 222, 3),
	(204, 111, 5),
	(205, 222, 2),
	(205, 333, 3),
	(206, 222, 2),
	(206, 333, 2),
	(206, 444, 2),
	(207, 222, 4),
	(729, 333, 3),
	(729, 111, 4),
	(345, 444, 3),
	(349, 444, 2),
	(349, 111, 2),
	(423, 333, 5),
	(425, 111, 2),
	(425, 444, 3),
	(427, 222, 2),
	(427, 333, 5),
	(512, 111, 2),
	(515, 111, 2),
	(519, 444, 3),
	(134, 444, 2),
	(134, 333, 2),
	(135, 444, 2),
	(135, 333, 2),
	(135, 111, 3),
	(136, 444, 2),
	(247, 222, 5),
	(247, 333, 5),
	(248, 222, 5),
	(248, 333, 5),
	(249, 222, 5),
	(249, 333, 4),
	(801, 111, 2),
	(802, 222, 2),
	(803, 333, 2),
	(804, 444, 2),
	(805, 444, 2),
	(806, 333, 2),
	(807, 222, 2),
	(808, 111, 2),
	(809, 111, 2),
	(810, 333, 2),
	(811, 222, 2),
	(812, 444, 2),
	(813, 444, 3),
	(813, 333, 3),
	(813, 111, 3),
	(850, 111, 4),
	(851, 222, 4),
	(855, 333, 4),
	(856, 444, 4),
	(858, 111, 2),
	(858, 222, 2),
	(858, 333, 2),
	(858, 444, 2)
GO

CREATE TABLE Borrowers (
	CardNo INT PRIMARY KEY,
	FirstName VARCHAR(50) NOT NULL,
	LastName VARCHAR(50) NOT NULL,
	Phone VARCHAR(20) NULL );
GO

INSERT INTO Borrowers VALUES
	(98765, 'Boz', 'Phonecia', '453-892-3390'),
	(87654, 'Gloria', 'Potts', NULL),
	(76543, 'Yevette', 'Townsend', '982-344-6518'),
	(65432, 'Harry', 'Lown', NULL),
	(54321, 'Nwabudike', 'Morgan', '997-342-8874'),
	(13579, 'Nell', 'Vraczk', '637-886-2001'),
	(24680, 'George', 'Polland', NULL),
	(35724, 'Thomas', 'Uganda', '320-933-6717'),
	(46801, 'Charles', 'Omagee', '343-202-3358'),
	(43210, 'Susan', 'Bereal', '520-876-0981'),
	(31086, 'Geoffrey', 'Howard', '233-990-1745'),
	(34892, 'Carl', 'Powers', NULL)
GO

CREATE TABLE BookLoans (
	BookID INT FOREIGN KEY(BookID)
		REFERENCES Books(BookID),
	BranchID INT FOREIGN KEY(BranchID)
		REFERENCES LibraryBranch(BranchID),
	CardNo INT FOREIGN KEY(CardNo)
		REFERENCES Borrowers(CardNo),
	DateOut DATE NOT NULL,
	DueDate DATE NULL );
GO

INSERT INTO BookLoans VALUES
	(512, 111, 98765, '02-23-15', '03-16-15'),
	(729, 111, 98765, '02-23-15', '03-16-15'),
	(425, 111, 98765, '01-03-15', '02-26-15'),
	(204, 111, 98765, '01-03-15', '04-10-15'),
	(850, 111, 98765, '03-03-15', '04-10-15'),
	(858, 222, 98765, '02-11-15', '03-28-15'),
	(247, 222, 98765, '02-11-15', '03-28-15'),
	(855, 333, 87654, '02-11-15', '03-28-15'),
	(806, 333, 87654, '02-11-15', '03-28-15'),
	(810, 333, 87654, '02-11-15', '03-28-15'),
	(247, 222, 76543, '03-03-15', '04-10-15'),
	(248, 222, 76543, '03-03-15', '04-10-15'),
	(201, 222, 76543, '03-03-15', '04-10-15'),
	(203, 222, 76543, '03-03-15', '04-10-15'),
	(205, 222, 76543, '03-03-15', '04-10-15'),
	(427, 222, 76543, '03-03-15', '04-10-15'),
	(101, 444, 65432, '02-23-15', '03-16-15'),
	(103, 444, 65432, '02-23-15', '03-16-15'),
	(349, 444, 65432, '01-13-15', '03-05-15'),
	(519, 444, 65432, '01-13-15', '03-05-15'),
	(134, 444, 65432, '02-23-15', '04-13-15'),
	(804, 444, 65432, '03-03-15', '04-10-15'),
	(805, 444, 65432, '03-03-15', '04-10-15'),
	(101, 111, 54321, '02-28-15', '03-27-15'),
	(102, 222, 54321, '03-03-15', '04-10-15'),
	(103, 111, 54321, '02-28-15', '03-27-15'),
	(810, 333, 13579, '03-12-15', '04-21-15'),
	(134, 333, 13579, '03-12-15', '04-21-15'),
	(135, 333, 13579, '03-12-15', '04-21-15'),
	(423, 333, 13579, '03-12-15', '04-21-15'),
	(205, 333, 24680, '02-23-15', '03-16-15'),
	(201, 333, 24680, '02-23-15', '03-16-15'),
	(202, 333, 24680, '02-23-15', '03-16-15'),
	(203, 333, 24680, '02-23-15', '03-16-15'),
	(729, 111, 35724, '01-03-15', '04-10-15'),
	(808, 111, 35724, '01-03-15', '04-10-15'),
	(809, 111, 46801, '01-13-15', '03-05-15'),
	(851, 222, 46801, '02-28-15', '03-27-15'),
	(206, 333, 46801, '02-23-15', '03-16-15'),
	(856, 444, 46801, '02-23-15', '03-16-15'),
	(249, 333, 43210, '02-28-15', '03-27-15'),
	(813, 333, 43210, '02-28-15', '03-27-15'),
	(248, 333, 43210, '03-12-15', '04-21-15'),
	(512, 111, 31086, '02-23-15', '03-16-15'),
	(515, 111, 31086, '02-23-15', '03-16-15'),
	(425, 111, 31086, '02-28-15', '03-27-15'),
	(811, 222, 31086, '03-12-15', '04-21-15'),
	(101, 444, 31086, '01-13-15', '03-05-15'),
	(349, 444, 31086, '02-23-15', '03-16-15')
GO
