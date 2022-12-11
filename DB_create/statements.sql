--Item 2 (insertion into tables)

INSERT INTO user 
    VALUES 
        ('Jordan', 'Jones', '01-05-1978', 'jjones1@groovr.com', '123 S Main St', 'Niceville', 'Texas', 'USA', 15647),
        ('Tim', 'Wilkinson', '04-16-1996', 'twilkinson4@groovr.com', '5834 Willow Cork Rd', 'Jonsmoor', 'Alabama', 'USA', 18952),
        ('Rachel', 'Rackers', '06-18-2001', 'rrackers6@groovr.com', '623 E Venison Dr', 'Rickwood', 'Kentucky', 'USA', 66987),
        ('Susan', 'Roberts', '11-18-1965', 'sroberts11@groovr.com', '8974 N Main St', 'Niceville', 'Texas', 'USA', 15647),
        ('Sam', 'Brenner', '05-16-1982', 'sbrenner5@groover.com', '8974 N Main St', 'Niceville', 'Texas', 'USA', 15647),
        ('John', 'Doe', '07-01-2004', 'jdoe7@groovr.com', '5816 Willow Ct', 'Oak Ridge', 'Tenessee', 'USA', 58479),
        ('Eric', 'Davis', '01-12-1965', 'edavis1@groovr.com', '923 N Ocean Blvd', 'Pompano', 'Florida', 'USA', 25003),
        ('Elizabeth', 'Brenner', '09-02-1985', 'ebrenner9@groovr.com', '8974 N Main St', 'Niceville', 'Texas', 'USA', 15647),
        ('Joyce', 'Daniels', '04-06-1998', 'jdaniels4@groovr.com', '1234 Lisa Ln', 'Niceville', 'Texas', 'USA', 15647),
        ('Patricia', 'Hite', '12-25-1973', 'phite12@groovr.com', '1854 Dead End Ct', 'Rock Hill', 'Georgia', 'USA', 78456);

INSERT INTO avatar 
    VALUES 
        ('Rachel', 'Rackers', '06-18-2001', 'RKilla', 6.8, 'Female', 'Feline'),
        ('John', 'Doe', '07-01-2004', 'unknownPlayer', 5.1, 'Male', 'Human'),
        ('Tim', 'Wilkinson', '04-16-1996', 'tDawg96', 5.9, 'Male', 'Human'),
        ('Joyce', 'Daniels', '04-06-1998', 'FlowerPrincess04', 4.9, 'Female', 'Human');

INSERT INTO player 
    VALUES 
        ('Patricia', 'Hite', '12-25-1973', 'Xbox', 'Sci-Fi'),
        ('Sam', 'Brenner', '05-16-1982', 'PC', 'Fantasy'),
        ('Jordan', 'Jones', '01-05-1978', 'Playstation', 'History'),
        ('Joyce', 'Daniels', '04-06-1998', 'PC', 'Action');

INSERT INTO developer 
    VALUES 
        ('Rachel', 'Rackers', '06-18-2001', '08-01-2018'),
        ('Susan', 'Roberts', '11-18-1965', '08-09-1986'),
        ('Eric', 'Davis', '01-12-1965', '02-05-1998'),
        ('Elizabeth', 'Brenner', '09-02-1985', '02-16-2015');

INSERT INTO proLang 
    VALUES 
        ('Rachel', 'Rackers', '06-18-2001', 'Java'),
        ('Rachel', 'Rackers', '06-18-2001', 'C++'),
        ('Rachel', 'Rackers', '06-18-2001', 'Python'),
        ('Susan', 'Roberts', '11-18-1965', 'Java'),
        ('Susan', 'Roberts', '11-18-1965', 'Javascript'),
        ('Susan', 'Roberts', '11-18-1965', 'C++'),
        ('Susan', 'Roberts', '11-18-1965', 'Python'),
        ('Eric', 'Davis', '01-12-1965', 'Python'),
        ('Eric', 'Davis', '01-12-1965', 'Java'),
        ('Eric', 'Davis', '01-12-1965', 'C'),
        ('Elizabeth', 'Brenner', '09-02-1985', 'C'),
        ('Elizabeth', 'Brenner', '09-02-1985', 'C++');

INSERT INTO devTeam 
    VALUES 
        (10023, 'Graphics', 'How good or bad the system looks to the user'),
        (10056, 'Design', 'General interface design and ease of use'),
        (10142, 'Space Local', 'Determine where the user is in physical space'),
        (11003, 'Communication', 'Manage communications as player to player or server to player');

INSERT INTO vrExp 
    VALUES 
        (10047, 'Rachel', 'Rackers', '06-18-2001', 'Stellar Cruisers', 'Sci-Fi'),
        (10236, 'Susan', 'Roberts', '11-18-1965', 'Forest of Dreams', 'Adventure'),
        (11564, 'Eric', 'Davis', '01-12-1965', 'Operation Desert Strom', 'Action'),
        (12653, 'Elizabeth', 'Brenner', '09-02-1985', 'Orc Invastion (IV)', 'Fantasy');

INSERT INTO suppHeadset 
    VALUES 
        (10047, 'PC'),
        (10236, 'Xbox'),
        (11564, 'Playstation'),
        (12653, 'PC');

INSERT INTO devProcess 
    VALUES 
        ('Rachel', 'Rackers', '06-18-2001', 10047, 10023),
        ('Susan', 'Roberts', '11-18-1965', 10236, 10056),
        ('Eric', 'Davis', '01-12-1965', 11564, 11003),
        ('Eric', 'Davis', '01-12-1965', 10047, 10142),
        ('Elizabeth', 'Brenner', '09-02-1985', 12653, 10056);

--Item 3 (updating tables)

UPDATE vrExp
    SET name = 'Starship Warriors'
    WHERE name = 'Stellar Cruisers'

UPDATE vrExp
    INNER JOIN suppHeadset ON vrExp.expID = suppHeadset.expID
    SET vrExp.type = suppHeadset.headsetName
    WHERE vrExp.expID = 10047 or vrExp.expID = 10236
    
--Item 4 (SQL queries)

--1 What are the programming languages that each developer knows?
SELECT developer.fName, developer.lName, proLang.language
FROM developer
INNER JOIN proLang ON developer.fName = proLang.dFName AND developer.lName = proLang.dLName AND developer.DOB = proLang.dDOB
--2 What are the names and emails of the developers in the Design devTeam?
SELECT user.fName, user.lName, user.email
FROM user
INNER JOIN devProcess ON user.fName = devProcess.dFName AND user.lName = devProcess.dLName AND user.DOB = devProcess.dDOB
INNER JOIN devTeam ON devProcess.teamID = devTeam.teamID
WHERE devTeam.type = 'Design' 
--3 What languages do both Eric and Susan know?
SELECT language
FROM proLang
WHERE dFName = 'Susan' AND LANGUAGE IN 
	(SELECT LANGUAGE
     FROM proLang
     WHERE dFName = 'Eric') 
--4 How many people are in each city?
SELECT COUNT(DISTINCT fName), city
FROM user
GROUP BY city
--5 What developers are in the Design or Graphics team?
SELECT devProcess.dFName, devProcess.dLName
FROM devProcess
INNER JOIN devTeam ON devProcess.teamID = devTeam.teamID
WHERE devTeam.type = 'Design'
UNION
SELECT devProcess.dFName, devProcess.dLName
FROM devProcess
INNER JOIN devTeam ON devProcess.teamID = devTeam.teamID
WHERE devTeam.type = 'Graphics'