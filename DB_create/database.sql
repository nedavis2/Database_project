CREATE TABLE user (
    fName       varchar(20)     not null,
    lName       varchar(20)     not null,
    DOB         varchar(10)     not null,
    email       varchar(30),
    streetAddr  varchar(30),
    city        varchar(20),
    state       varchar(20),
    country     varchar(20),
    ZIP         numeric(5,0),
    primary key (fName, lName, DOB)
);
CREATE TABLE avatar (
    uFName      varchar(20)     not null,
    uLName      varchar(20)     not null,
    uDOB        varchar(10)     not null,
    name        varchar(20),
    height      numeric(3,1),
    gender      varchar(10),
    species     varchar(20),
    primary key (uFName, uLName, uDOB, name),
    foreign key (uFName, uLName, uDOB) references user(fName, lName, DOB)
);
CREATE TABLE player (
    fName       varchar(20)     not null,
    lName       varchar(20)     not null,
    DOB         varchar(10)     not null,
    headset     varchar(20),
    favGenre    varchar(20),
    primary key (fName, lName, DOB),
    foreign key (fName, lName, DOB) references user(fName, lName, DOB)
);
CREATE TABLE developer (
    fName       varchar(20)     not null,
    lName       varchar(20)     not null,
    DOB         varchar(10)     not null,
    startDate   varchar(10),
    primary key (fName, lName, DOB),
    foreign key (fName, lName, DOB) references user(fName, lName, DOB)
);
CREATE TABLE proLang (
    dFName      varchar(20)     not null,
    dLName      varchar(20)     not null,
    dDOB        varchar(10)     not null,
    language    varchar(20),
    foreign key (dFName, dLName, dDOB) references developer(fName, lName, DOB)
);
CREATE TABLE devTeam (
    teamID      numeric(5,0)    not null,
    type        varchar(20),
    description varchar(100),
    primary key (teamID)
);
CREATE TABLE vrExp ( 
    expID       numeric(5,0)    not null,
    dFName      varchar(20),
    dLName      varchar(20),
    dDOB        varchar(10),
    name        varchar(30),
    type        varchar(20),
    primary key (expID),
    foreign key (dFName, dLName, dDOB) references developer(fName, lName, DOB)
);
CREATE TABLE suppHeadset (
    expID       numeric(5,0)    not null,
    headsetName varchar(20)     not null,
    primary key (expID, headsetName),
    foreign key (expID) references vrExp(expID)
);
CREATE TABLE devProcess (
    dFName      varchar(20)     not null,
    dLName      varchar(20)     not null,
    dDOB        varchar(10)     not null,
    expID       numeric(5,0)    not null,
    teamID      numeric(5,0)    not null,
    primary key (dFName, dLName, dDOB, expID, teamID),
    foreign key (dFName, dLName, dDOB) references developer(fName, lName, DOB),
    foreign key (expID) references vrExp(expID),
    foreign key (teamID) references devTeam(teamID)
);