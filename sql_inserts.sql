INSERT INTO ZIPS
VALUES (65401, 'Saint Louis', 'MO');

INSERT INTO ZIPS
VALUES (64064, 'Lee\'s Summit', 'MO');

INSERT INTO ZIPS
VALUES (65409, 'Rolla', 'MO');.

INSERT INTO ZIPS
VALUES (12345, 'cityville', 'HU');

INSERT INTO ZIPS
VALUES (54321, 'cityville', 'HU');

--------------------------------------------------------------------

INSERT INTO USERS
VALUES(1, '1', 1, 65401, 'a', 'z', 1, 'area');

INSERT INTO USERS
VALUES(2, '2', 2, 64064, 'b', 'y', 2, 'area2');

INSERT INTO USERS
VALUES(3, '3', 3, 65409, 'c', 'x', 3, 'area3');

INSERT INTO USERS
VALUES(4, '4', 4, 12345, 'd', 'w', 4, 'area4');

INSERT INTO USERS
VALUES(5, '5', 5, 54321, 'e', 'v', 5, NUll);

-----------------------------------------------------------------------

INSERT INTO MEDIA	
VALUES(1, 1, 'a', 'a', 'book', 'a', NULL, 123456, NULL, NULL, NULL);

INSERT INTO MEDIA	
VALUES(2, 2, 'b', 'b', 'book', 'b', NULL, 234567, NULL, NULL, NULL);

INSERT INTO MEDIA	
VALUES(3, 3, 'c', 'c', 'CD', NULL, NULL, NULL, 'a', NULL, NULL);

INSERT INTO MEDIA	
VALUES(7, 3, 'f', 'f', 'CD', NULL, NULL, NULL, 'a', NULL, NULL);

INSERT INTO MEDIA	
VALUES(4, 4, 'd', 'd', 'CD', NULL, NULL, NULL, 'b', NULL, NULL);

INSERT INTO MEDIA	
VALUES(6, 5, 'e', 'e', 'Movie', NULL, NULL, NULL, NULL, 'a', 'a');

INSERT INTO MEDIA	
VALUES(5, 5, 'f', 'd', 'Movie', NULL, NULL, NULL, NULL, 'b', 'b');

-----------------------------------------------------------------------

INSERT INTO BORROWS
VALUES(1, 1, 'pending', 1, NULL);

INSERT INTO BORROWS
VALUES(2, 2, 'active', 2, 3);

INSERT INTO BORROWS
VALUES(3, 3, 'confirmed', 3, NULL);

INSERT INTO BORROWS
VALUES(4, 4, 'returned', 4, NULL);

INSERT INTO BORROWS
VALUES(5, 7, 'pending', 4, NULL);

-------------------------------------------------------------------------

INSERT INTO COMMENTS
VALUES(1, 4, 'awesome', 10, 123);

INSERT INTO COMMENTS
VALUES(4, 1, 'sucks', 6, 321);

INSERT INTO COMMENTS
VALUES(2, 4, 'awesomer', 10, 123);

INSERT INTO COMMENTS
VALUES(5, 3, 'sucksest', 6, 3211);

--------------------------------------------------------------------------

INSERT INTO FRIENDS
VALUES(1, 2, false);

INSERT INTO FRIENDS
VALUES(1, 3, true);

INSERT INTO FRIENDS
VALUES(2, 5, true);

INSERT INTO FRIENDS
VALUES(2, 3, true);

INSERT INTO FRIENDS
VALUES(4, 3, false);

------------------------------------------------------------------------------

INSERT INTO REFERS
VALUES(1, 'bob@obb.com', 'Methusela');

INSERT INTO REFERS
VALUES(2, 'steve@obb.com', 'Jolee');

INSERT INTO REFERS
VALUES(3, 'susie@obb.com', 'qwrty');

INSERT INTO REFERS
VALUES(4, 'yqweoirue@obb.com', 'limpy');

INSERT INTO REFERS
VALUES(5, 'minde@obb.com', 'brain');

-------------------------------------------------------------------------------

INSERT INTO SUGGESTIONS
VALUES(1, 'improve', 12345, 'your site is perfectly awesomeness');

INSERT INTO SUGGESTIONS
VALUES(1, 'deprove', 54321, 'your site is perfectly suckiness');

INSERT INTO SUGGESTIONS
VALUES(2, 'average it', 234567, 'the cow is green');

INSERT INTO SUGGESTIONS
VALUES(4, 'deprove', 1547, 'the black hole is too bleack');

INSERT INTO SUGGESTIONS
VALUES(5, 'mouse', 15447, 'why do measles always weasle');



