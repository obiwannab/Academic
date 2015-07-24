--DECLARE @FirstName VARCHAR(50)
--	SET @FirstName = NULL

--DECLARE @LastName VARCHAR(50)
--	SET @LastName = 'A'
	
--DECLARE @City VARCHAR(30)
--	SET @City = 'P'

CREATE PROCEDURE uspGetPersonAddress @LastName VARCHAR(50) = NULL, @City VARCHAR(30) = NULL AS
/*  This procedure will produce a report of names and address based on either criteria (or both)
of LastName and City.  The procedure utilizes wildcards so that the passed criteria can be
starting values for their fields.
*/
SELECT Per.FirstName, Per.LastName, A.AddressLine1, A.City, SP.StateProvinceCode, SP.CountryRegionCode, A.PostalCode
	FROM Person.Person AS Per INNER JOIN Person.BusinessEntityAddress AS BEA
	ON Per.BusinessEntityID = BEA.BusinessEntityID
		INNER JOIN Person.Address AS A
		ON BEA.AddressID = A.AddressID
			INNER JOIN Person.StateProvince AS SP
			ON A.StateProvinceID = SP.StateProvinceID
	WHERE Per.LastName LIKE ISNULL(@LastName,LastName) + '%'
		AND A.City LIKE ISNULL(@City,City) + '%'

EXEC uspGetPersonAddress 'M','R'