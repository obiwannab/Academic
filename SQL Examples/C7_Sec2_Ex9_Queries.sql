/*	Course 7 - Database and SQL
	Section 2: #9 DRILL: SQL Drill
	
	--Query Exercises--

*/

USE C7Sec2Drill9
GO

/*	SQL Query 1
	How many copies of the book titled The Lost Tribe are owned
	by the library branch whose name is "Sharpstown"?
*/
SELECT Bk.Title, BC.NumCopies, LB.BranchName, LB.Address
	FROM Books AS Bk INNER JOIN BookCopies AS BC
	ON Bk.BookID = BC.BookID
		INNER JOIN LibraryBranch AS LB
		ON BC.BranchID = LB.BranchID
	WHERE Bk.Title = 'The Lost Tribe'
		AND LB.BranchName = 'Sharpstown'

/*	SQL Query 2
	How many copies of the book titled The Lost Tribe are owned
	by each library branch?
*/
SELECT Bk.Title, BC.NumCopies, LB.BranchName, LB.Address
	FROM Books AS Bk INNER JOIN BookCopies AS BC
	ON Bk.BookID = BC.BookID
		INNER JOIN LibraryBranch AS LB
		ON BC.BranchID = LB.BranchID
	WHERE Bk.Title = 'The Lost Tribe'

/*	SQL Query 3
	Retrieve the names of all borrowers who do not have any books checked out.
*/
SELECT Brw.*
	FROM BookLoans AS BkL RIGHT OUTER JOIN Borrowers AS Brw
	ON BkL.CardNo = Brw.CardNo
	WHERE BkL.CardNo IS NULL

/*	SQL Query 4
	For each book that is loaned out from the "Sharpstown" branch
	and whose DueDate is today, retrieve the book title, the
	borrower's name, and the borrower's address.
	--Additional Note: When I created the datebase, I intended that
	March 16th (the day I wrote the database population script) would
	be the "today" spoken of in the query...
	--Whoops!  When I created the database, I forgot to include 
	an Address column for the Borrowers table.  Instead of wasting 
	time creating more "junk data" and re-populating the table, I
	just included the phone number in this query...
*/
SELECT B.Title, Brw.FirstName, Brw.LastName, Brw.Phone
	FROM BookLoans AS BkL INNER JOIN LibraryBranch AS LB
	ON BkL.BranchID = LB.BranchID
		INNER JOIN Books AS B
		ON BkL.BookID = B.BookID
		INNER JOIN Borrowers AS Brw
		ON BkL.CardNo = Brw.CardNo
	WHERE LB.BranchName = 'Sharpstown'
		AND BkL.DueDate = '03-16-15'

/*	SQL Query 5
	For each library branch, retrieve the branch name and the total 
	number of books loaned out from that branch.
*/
SELECT LB.BranchName, COUNT(*) AS TotalBooksOut
	FROM BookLoans AS BkL LEFT JOIN LibraryBranch AS LB
	ON BkL.BranchID = LB.BranchID
	GROUP BY LB.BranchName

/*	SQL Query 6
	Retrieve the names, addresses, and number of books checked out, for 
	all borrowers who have more than five books checked out.
*/
SELECT Brw.FirstName, Brw.LastName, Brw.Phone, COUNT(*) AS TotalBooksOut
	FROM BookLoans AS BkL LEFT JOIN Borrowers AS Brw
	ON BkL.CardNo = Brw.CardNo
	GROUP BY Brw.FirstName, Brw.LastName, Brw.Phone
	HAVING COUNT(*) > 5

/*	SQL Query 7
	For each book authored (or co-authored) by "Stephen King",
	retrieve the title and the number of copies owned by the library 
	branch whose name is "Central".
*/
SELECT Bks.Title, BkA.LastName, LB.BranchName, BC.NumCopies
	FROM Books AS Bks INNER JOIN BookAuthors AS BkA
	ON Bks.AuthorID = BkA.AuthorID
		INNER JOIN BookCopies AS BC
		ON Bks.BookID = BC.BookID
			INNER JOIN LibraryBranch AS LB
			ON BC.BranchID = LB.BranchID
	WHERE BkA.FirstName = 'Stephen' AND BkA.LastName = 'King'
		AND LB.BranchName = 'Central'

/*	Stored Procedure Exercise
	Create a stored procedure that will execute one or more of those queries,
	based on user choice.
*/
CREATE PROCEDURE uspBookOnLoan @Library VARCHAR(80) = NULL, @DueDate DATE = NULL
AS
SELECT B.Title, Brw.FirstName, Brw.LastName, Brw.Phone
	FROM BookLoans AS BkL INNER JOIN LibraryBranch AS LB
	ON BkL.BranchID = LB.BranchID
		INNER JOIN Books AS B
		ON BkL.BookID = B.BookID
		INNER JOIN Borrowers AS Brw
		ON BkL.CardNo = Brw.CardNo
	WHERE LB.BranchName = ISNULL(@Library,LB.BranchName)
		AND BkL.DueDate = ISNULL(@DueDate,GETDATE())

EXEC uspBookOnLoan 'Sharpstown', '03-16-15'
GO