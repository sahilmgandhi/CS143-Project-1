# CS143_Project1
CS 143 Project 1 Code: Internet Movie DataBase

Project design: We incrementally wrote the code for this project, starting with the create.sql and then load.sql, then the queries.sql. We then
created the query.php file and then after thinking about constraints, we modified the create.sql file and created the violate.sql files.
The work was split quite evenly between both of team members.

* Keep in mind for the create.sql and violate.sql, the "CHECK" statements do NOT work since mysql does not support the check statement*.

 In English a list of constraints the DB should satisfy:

 1) Movies must be made after the first ever recorded movie (1978)
 2) Movie ids must be unique since we cant have more than 1 movie with the same id
 3) Actor's date of birth must be less than the current date (what newborn is immediately an actor?)
 4) Actor's date of death must be after their birth OR null if they aren't dead.
 5) Actor id should be unique since no 2 actors are the same
 6) Sales' movie Id should be unique since there should only be 1 tuple of sales per movie
 7) Director's id should be unique since no 2 directors are the same
 8) Directors date of birth must be less than the current date
 9) Director's date of death must be after their birth or null if they aren't dead
 10) Movie ratings id must be unique since there can only be one aggregate rating per movie
 11) The movie rating's imdb score must be between 0 and 100
 12) The movie rating's rotten tomatoes score must be between 0 and 100
 13) The rating of a review must be between 0 and 5 as per the comment in the spec (ie. x out of 5).
 14) A lot of different things such as ids, or roles or titles and years should not be allowed to be NULL since these are identifiers!