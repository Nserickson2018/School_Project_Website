DROP TABLE IF EXISTS organizations;
DROP TABLE IF EXISTS stylesheets;
DROP TABLE IF EXISTS pUsers;
DROP TABLE IF EXISTS pages;
DROP TABLE IF EXISTS homepage;
DROP TABLE IF EXISTS userorg;

CREATE TABLE pUsers(
    uid INT unsigned NOT NULL AUTO_INCREMENT,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    birthday VARCHAR(10) NOT NULL,
    email VARCHAR(128) NOT NULL,
    acctype VARCHAR(20),
    username VARCHAR(50) NOT NULL, 
    hashedpass VARCHAR(200) NOT NULL,
    CONSTRAINT User_PK PRIMARY KEY(uid)
);

CREATE TABLE organizations(
    orgid INT unsigned NOT NULL AUTO_INCREMENT,
    orgName VARCHAR(50) NOT NULL,
    footerText VARCHAR(200) NOT NULL,
    stylesheetid INT NOT NULL,
    PRIMARY KEY(orgid)
);

CREATE TABLE userorg(
    orgid INT NOT NULL,
    uid INT NOT NULL,
    orgacctype VARCHAR(20) NOT NULL
);

INSERT INTO userorg(orgid, uid, orgacctype) VALUES(1, 1,"orgadmin");
INSERT INTO userorg(orgid, uid, orgacctype) VALUES(1, 2,"orgadmin");

CREATE TABLE pages (
    id INT NOT NULL AUTO_INCREMENT,
    urlTitle VARCHAR(32) NOT NULL, /* what word goes into the url that distinguishes this page from others */
    pageTitle VARCHAR(32) NOT NULL, /* title shown on bookmarks, tab, etc. */
    menuTitle VARCHAR(32) NOT NULL, /* title shown in menus */
    orgid INT NOT NULL,
    parent INT, /* parent page */
    bodyTitle VARCHAR(128) NOT NULL, /* title shown in the body of the page */
    body TEXT, /* content of the page (only text for now) */
    asideTitle VARCHAR(128), /*add aside block if wanted*/
    asideBody Text, /*content of aside*/
    template INT NOT NULL,
    image VARCHAR(300),
    PRIMARY KEY (ID)
);
--FOREIGN KEY(userID) REFERENCES pUsers(uid),
--FOREIGN KEY(pageID) REFERENCES pages(id)

INSERT INTO organizations(orgName, footerText, stylesheetid) VALUES('Iowa Powerlifting Club', '&copy; 2016 Iowa Powerlifting Club. All Rights Reserved.', 2);

CREATE TABLE stylesheets(
    sheetid INT unsigned NOT NULL AUTO_INCREMENT,
    sheetName VARCHAR(50) NOT NULL,
    description VARCHAR(200),
    link VARCHAR(200) NOT NULL,
    thumbnail VARCHAR(200) NOT NULL,
    CONSTRAINT stylesheet_PK PRIMARY KEY(sheetid)
);

INSERT INTO pUsers(uid, fname, lname, birthday, email, acctype, username, hashedpass)
VALUES(1, 'Nicholas', 'Erickson', '09/27/1993', 'nicholas-erickson@uiowa.edu', 'admin', 'nserickson', '$2a$12$sOdb2AszxFwZ5ugtcJyU3upel/16dUJC/G5w.3c19btV4vya0eW4W');
INSERT INTO pUsers(uid, fname, lname, birthday, email, acctype, username, hashedpass)
VALUES(2, 'Malachi', 'Melville', '12/20/1993', 'malachi-melville@uiowa.edu', 'admin', 'mtmelville', '$2a$12$fkpGCLJWoAG2qLUX0/4EY.XJLncna0I3RiNk2yx43SNg6XTQGez1O');
INSERT INTO pUsers(uid, fname, lname, birthday, email, acctype, username, hashedpass)
VALUES(3, 'Jacob', 'Sikorski', '02/04/1995', 'jacob-sikorski@uiowa.edu', 'admin', 'jsikorski', '$2a$12$OS3/Tq5hKPNXVLAqL/ud.e9mJlxWop7lK2PSTD9ifTcGOgd2zS0om');
/*Jacob's password is jsikorski*/

INSERT INTO pages (urlTitle, pageTitle, menuTitle, orgid, parent, bodyTitle, body, asideTitle, asideBody, template, image)
VALUES ("Home", "Home - Iowa Powerlifting Club", "Home", 1, -1, "Welcome to the Iowa Powerlifting Club", "Weights, weights, and more weights.", "News", "Welcome to the club. Stay up to date with our events.", "2", "IPL2.png");

INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Cosmo', '', 'https://bootswatch.com/cosmo/bootstrap.min.css', 'https://bootswatch.com/cosmo/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Cyborg', '', 'https://bootswatch.com/cyborg/bootstrap.min.css', 'https://bootswatch.com/cyborg/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Darkly', '', 'https://bootswatch.com/darkly/bootstrap.min.css', 'https://bootswatch.com/darkly/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Flatly', '', 'https://bootswatch.com/flatly/bootstrap.min.css', 'https://bootswatch.com/flatly/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Journal', '', 'https://bootswatch.com/journal/bootstrap.min.css', 'https://bootswatch.com/journal/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Lumen', '', 'https://bootswatch.com/lumen/bootstrap.min.css', 'https://bootswatch.com/lumen/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Paper', '', 'https://bootswatch.com/paper/bootstrap.min.css', 'https://bootswatch.com/paper/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Readable', '', 'https://bootswatch.com/readable/bootstrap.min.css', 'https://bootswatch.com/readable/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Sandstone', '', 'https://bootswatch.com/sandstone/bootstrap.min.css', 'https://bootswatch.com/sandstone/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Simplex', '', 'https://bootswatch.com/simplex/bootstrap.min.css', 'https://bootswatch.com/simplex/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Slate', '', 'https://bootswatch.com/slate/bootstrap.min.css', 'https://bootswatch.com/slate/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Spacelab', '', 'https://bootswatch.com/spacelab/bootstrap.min.css', 'https://bootswatch.com/spaelab/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Superhero', '', 'https://bootswatch.com/superhero/bootstrap.min.css', 'https://bootswatch.com/superhero/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('United', '', 'https://bootswatch.com/united/bootstrap.min.css', 'https://bootswatch.com/united/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Yeti', '', 'https://bootswatch.com/yeti/bootstrap.min.css', 'https://bootswatch.com/yeti/thumbnail.png');
INSERT INTO stylesheets(sheetName, description, link, thumbnail)
VALUES('Cerulean', '', 'https://bootswatch.com/cerulean/bootstrap.min.css', 'https://bootswatch.com/cerulean/thumbnail.png');