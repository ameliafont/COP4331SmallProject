use COP4331;

/* Populate sample Users */ 
insert into Users (FirstName,LastName,Login,Password) VALUES ('Rick','Leinecker','RickL','COP4331');
insert into Users (FirstName,LastName,Login,Password) VALUES ('Sam','Hill','SamH','Test');
insert into Users (FirstName,LastName,Login,Password) VALUES ('Rick','Leinecker','RickL','5832a71366768098cceb7095efb774f2');
insert into Users (FirstName,LastName,Login,Password) VALUES ('Sam','Hill','SamH','0cbc6611f5540bd0809a388dc95a615b');

/* Populate sample Contacts (Some Information may or may not be available) */
insert into Contacts (FirstName,LastName,Email,Phone,UserID) VALUES ('John','Doe', 'JD00@test.com','0000000000', 3);
insert into Contacts (FirstName,LastName,Email,UserID) VALUES ('J','H', 'a@h.com', 0);
insert into Contacts (FirstName,Email,Phone,UserID) VALUES ('Sam', 'sammyT@test.com','0000000001', 1);
insert into Contacts (FirstName,LastName,Email,Phone,UserID) VALUES ('John','Doe', 'JD00@test.com','0000000000', 2);
insert into Contacts (FirstName,LastName,Email,UserID) VALUES ('Barry','Allen', 'def-not@theflash.com', 4);
insert into Contacts (FirstName,LastName,UserID) VALUES ('Pete','Parker', 4);
