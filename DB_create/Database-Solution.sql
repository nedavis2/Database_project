DROP TABLE IF EXISTS work;
DROP TABLE IF EXISTS developmentTeam;
DROP TABLE IF EXISTS avatar;
DROP TABLE IF EXISTS supportedHeadset;
DROP TABLE IF EXISTS VRExperience;
DROP TABLE IF EXISTS progLanguage;
DROP TABLE IF EXISTS developer;
DROP TABLE IF EXISTS player;
DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`(
  fName        VARCHAR(25),
  lName        VARCHAR(25),
  dateOfBirth  DATE,
  email        VARCHAR(40),
  streetAddr   VARCHAR(50),
  city         VARCHAR(25),
  state        VARCHAR(15),
  country      VARCHAR(50),
  zip          VARCHAR(9),

  PRIMARY KEY(fName, lName, dateOfBirth)
);

CREATE TABLE player(
  fName        VARCHAR(25),
  lName        VARCHAR(25),
  dateOfBirth  DATE,
  headset      SET('HTC VIVE', 'Varjo', 'HTC Vive Pro', 'HP Reverb', 'Oculus Quest', 'Valve Index'),
  favGenre     VARCHAR(20),

  PRIMARY KEY(fName, lName, dateOfBirth),

  FOREIGN KEY(fName, lName, dateOfBirth) REFERENCES user(fName, lName, dateOfBirth)
);

CREATE TABLE developer(
  fName        VARCHAR(25),
  lName        VARCHAR(25),
  dateOfBirth  DATE,
  startDate    DATE,

  PRIMARY KEY(fName, lName, dateOfBirth),

  FOREIGN KEY(fName, lName, dateOfBirth) REFERENCES user(fName, lName, dateOfBirth)
);

CREATE TABLE progLanguage(
  dFName        VARCHAR(25),
  dLName        VARCHAR(25),
  dDateOfBirth  DATE,
  language      VARCHAR(30),

  PRIMARY KEY(dFName, dLName, dDateOfBirth, language),

  FOREIGN KEY(dFName, dLName, dDateOfBirth) REFERENCES developer(fName, lName, dateOfBirth)
);

CREATE TABLE VRExperience(
  expID            INTEGER AUTO_INCREMENT PRIMARY KEY,
  maintainerFName  VARCHAR(25) NOT NULL,
  maintainerLName  VARCHAR(25) NOT NULL,
  maintainerDOB    DATE NOT NULL,
  name             VARCHAR(100) NOT NULL,
  type             VARCHAR(40),

  FOREIGN KEY(maintainerFName, maintainerLName, maintainerDOB) REFERENCES developer(fName, lName, dateOfBirth)
);

CREATE TABLE supportedHeadset(
  expID    INTEGER,
  headset  SET('HTC VIVE', 'Varjo', 'HTC Vive Pro', 'HP Reverb', 'Oculus Quest', 'Valve Index'),

  PRIMARY KEY(expID, headset),

  FOREIGN KEY(expID) REFERENCES VRExperience(expID)
);

CREATE TABLE avatar(
  fName        VARCHAR(25),
  lName        VARCHAR(25),
  dateOfBirth  DATE,
  name         VARCHAR(35),
  height       DECIMAL(6,2),
  gender       VARCHAR(30),
  species      VARCHAR(30),

  PRIMARY KEY(fName, lName, dateOfBirth, name),

  FOREIGN KEY(fName, lName, dateOfBirth) REFERENCES user(fName, lName, dateOfBirth)
);

CREATE TABLE developmentTeam(
  teamID      INTEGER AUTO_INCREMENT PRIMARY KEY,
  type        VARCHAR(40),
  description TEXT
);

CREATE TABLE work(
  dFname         VARCHAR(25),
  dLname         VARCHAR(25),
  dDateOfBirth   DATE,
  teamID         INTEGER,
  expID          INTEGER,

  PRIMARY KEY(dFname, dLname, dDateOfBirth, teamID, expID),

  FOREIGN KEY(dFname, dLname, dDateOfBirth) REFERENCES developer(fName, lName, dateOfBirth),
  FOREIGN KEY(teamID) REFERENCES developmentTeam(teamID),
  FOREIGN KEY(expID) REFERENCES VRExperience(expID)
);