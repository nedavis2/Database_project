/*Question 3
get the start date, first and last name, state of residence, known programming language, and development team ID
of everyone in the inegration team type who lives in NC, SC, or OH and knows C*/

/*drop old indexes if already exists*/
drop index type_index on developmentTeam;
drop index language_index on progLanguage;
drop index state_index on user;

create index type_index on developmentTeam(type);
create index language_index on progrLanguage(language);
create index state_index on user(state);

select d.startDate, u.fName, u.lName, u.state, pl.language, dt.teamID
from developer d
inner join user u on d.fName = u.fName and d.lName = u.lName and d.dateOfBirth = u.dateOfBirth
inner join work w on d.fName = w.dFname and d.lName = w.dLname and d.dateOfBirth = w.dDateOfBirth and u.fName = w.dFname and u.lName = w.dLname and u.dateOfBirth = w.dDateOfBirth
inner join progLanguage pl on d.fName = pl.dFName and d.lName = pl.dLName and d.dateOfBirth = pl.dDateOfBirth and u.fName = pl.dFName and u.lName = pl.dLName and u.dateOfBirth = pl.dDateOfBirth and w.dFname = pl.dFName and w.dLname = pl.dLName and w.dDateOfBirth = pl.dDateOfBirth
inner join developmentTeam dt on w.teamID = dt.teamID
WHERE dt.type = 'integration' and (u.state = 'NC' or u.state = 'SC' or u.state = 'OH') and pl.language = 'C'

/*Question 4
Create a view that finds the average height of each player's avatars, sorted by player's name.*/

create view avgPlayerAvatarHeight as
    select p.fName, p.lName, 
        round(avg(height), 2) as avgAvatarHeight
    from avatar a
    inner join user u on 
        a.fName = u.fName and a.lName = u.lName and a.dateOfBirth = u.dateOfBirth
    inner join player p on 
        u.fName = p.fName and u.lName = p.lName and u.dateOfBirth = p.dateOfBirth and 
        a.fName = p.fName and a.lName = p.lName and a.dateOfBirth = p.dateOfBirth
    group by fName, lName

/*EC (question 5)
Create a view that calculates the average experience, in years, 
of all developers per development team type. 
Include also the number of developers in each team. Name the view "avgExpByTeam".*/

/* secondarty view used to calculate each developer's experience in years */
create view devExperience as
    select fName, lName, dateOfBirth, datediff(startDate, CURRENT_DATE)/-365 as expYears
    from developer

create view teamExpByType as
	select dt.teamID, dt.type, 
        count(DISTINCT d.fName, d.lName, d.dateOfBirth) as numDevelopers, 
        round(avg(expYears), 1) as avgExpByTeam
    from developmentTeam dt
    inner join work w on dt.teamID = w.teamID
    inner join developer d on 
        d.fName = w.dFname and d.lName = w.dLname and d.dateOfBirth = w.dDateOfBirth
    inner join devExperience de on 
        de.fName = d.fName and de.lName = d.lName and de.dateOfBirth = d.dateOfBirth and 
        de.fName = w.dFname and de.lName = w.dLname and de.dateOfBirth = w.dDateOfBirth
    group by dt.teamID